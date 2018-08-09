<?php

namespace App\Repositories;

use App\Exemplar;
use App\LessonPlan;
use App\Tag;
use App\User;
use App\Document;
use App\Answer;
use Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\AnswerCollection;

class LessonPlanRepository
{

    /**
     * Get the latest lesson plans for a user
     *
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function lessonPlansForUser($id, $take = 10, $sort = 'desc', $query = '')
    {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's lesson plans
        $lessonPlans = LessonPlan::with([
                'comments',
                'comments.author',
                'author',
                'participants']
        )->orderBy('updated_at', $sort);

        if($sort == 'exemplar')
        {
            $exemplars = Exemplar::where('approved',1)->where('exemplarable_type',LessonPlan::class)->get();
            $ids = $exemplars->keyBy('exemplarable_id')->keys();
            $lessonPlans = LessonPlan::whereIn('id',$ids)->with([
                    'comments',
                    'comments.author',
                    'author',
                    'participants']
            )->orderBy('updated_at', $sort);
        }
        // If a search query is provided then find a video by title or author
        if ($query) {
            $lessonPlans->searchTitleOrAuthor($query);
        }

        // If the user isn't a project admin or super admin then scope the lesson
        // plans to only include plans they have authored or are participating in
        if (!$user->isEither(['project_admin', 'super_admin'])) {
            $lessonPlans->authoredOrParticipatingExemplar($user->id);
        }
        
        return $lessonPlans->paginate($take);
    }
    /**
     * Get the latest lesson plans for a user by tag
     *
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function lessonPlansForUserByTag($id, $take = 10, $sort = 'desc', $query = '')
    {
        // Get the user that is logged in
        $user = User::find($id);

        // Setup the query for retrieving a user's lesson plans
        $lessonPlans = LessonPlan::with([
            'comments',
            'comments.author',
            'author',
            'participants']
        )->orderBy('updated_at', $sort);

        
        // If a search query is provided then find a lesson plan by title or author
        if ($query) {
            $tags = explode(',',$query);
            $lessonPlans = LessonPlan::all()->keyBy('id');
            foreach ($tags as $tag_name)
            {
                $collection = $lessonPlans;

                $tag = Tag::where('tag',$tag_name)->first();
                if($tag != null)
                    $intersect = $collection->intersect($tag->lessonPlans->keyBy('id'));
                else
                    $intersect = $collection->intersect([]);
                $lessonPlans = $intersect;

            }
            $ids = $lessonPlans->keyBy('id')->keys();
            $lessonPlans = LessonPlan::whereIn('id',$ids)->with([
                    'comments',
                    'comments.author',
                    'author',
                    'participants']
            )->orderBy('updated_at', $sort);

        }
        
        // If the user isn't a project admin or super admin then scope the lesson
        // plans to only include plans they have authored or are participating in
        if (!$user->isEither(['project_admin', 'super_admin'])) {
            $lessonPlans->authoredOrParticipatingExemplar($user->id);
        }
        return $lessonPlans->paginate($take);
    }

    /**
     * Store a new document on this lesson plan
     *
     * @param LessonPlan $lessonPlan
     * @param UploadedFile $file
     * @param array $properties
     */
    public function document(LessonPlan $lessonPlan, UploadedFile $file, $properties)
    {
        // Create a new document
        $document = new Document;
        $document->extension = $file->getClientOriginalExtension();
        $document->author_id = \Auth::id();
        $document->title = array_get($properties, 'title', $file->getClientOriginalName());
        $document->description = array_get($properties, 'description');
        $document->type = array_get($properties, 'type');

        // Create a new obfuscated filename
        $filename = str_random(16) . '.' . $document->extension;

        // Move the file to a more sensible location
        $file->move(public_path('uploads'), $filename);

        // Store the new path on the document
        $document->path = '/uploads/' . $filename;

        // Attach the new document to the lesson plan
        return $lessonPlan->documents()->save($document);
    }

    /**
     * Stores an array of answers on a lesson plan
     *
     * @param App\LessonPlan $lessonPlan
     * @param array $answers
     * @return void
     */
    public function storeAnswers(LessonPlan $lessonPlan, array $answers)
    {
        $tagIds = [];
        $lessonPlan->answers()->delete();
        foreach ($answers as $key => $value) {

            // Find an answer by the user or make a new one
            $answer = Answer::firstOrNew([ 'key' => $key, 'author_id' => Auth::id() ]);
            $answer->value = $value;

            // Store it on the lesson plan
            $lessonPlan->answers()->save($answer);
            $tag = explode('_',$key);
            if(count($tag)>1)
            {
                $tagType = str_replace("-"," ",$tag[0]);
                $tagName = str_replace("-"," ",$tag[1]);
                echo $tagName."<br>";
                $tag = Tag::where(['tag'=>$tagName,'type'=>$tagType])->first();
                if($tag != null)
                    $tagIds[] = $tag->id;
            }
        }
        $lessonPlan->tags()->sync($tagIds);
    }

    /**
     * Get the latest answers that were created for a lesson plan. Users can collaborate
     * on the same lesson plan, but viewing a lesson plan should only show the
     * most recent answers that were created by users.
     *
     * @param App\LessonPlan $lessonPlan
     * @return Illuminate\Support\Collection
     */
    public function latestAnswers(LessonPlan $lessonPlan)
    {
        return new AnswerCollection($lessonPlan->answers()
            ->orderBy('answers.updated_at', 'desc')
            ->groupBy('answers.key')
            ->get());
    }

    /**
     * Gets answers for a lesson plan that were created by a user
     *
     * @param App\LessonPlan $lessonPlan
     * @param App\User $user
     * @return Illuminate\Support\Collection
     */
    public function usersAnswers(LessonPlan $lessonPlan, User $user)
    {
        return $lessonPlan->answers()
            ->where('author_id', $user->id)
            ->get();
    }

    /**
     * Generates an array of answers to display on a PDF
     *
     * @param App\LessonPlan $lessonPlan
     * @return array
     */
    public function generatePdfData(LessonPlan $lessonPlan)
    {
        $user = Auth::user();
        $answers = $this->usersAnswers($lessonPlan, $user);

        return [
            'date' => date('jS M Y'),
            'teacher' => $user->display_name,
            'title' => $lessonPlan->title,
            'answers' => $this->latestAnswers($lessonPlan)
        ];
    }

    /**
     * Get the lesson Plans with approval request
     *
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function lessonPlansWaitingForApprove($id, $take = 10, $sort = 'desc', $query = '')
    {
        $exemplars = Exemplar::where('approved',0)->where('exemplarable_type',LessonPlan::class)->orderBy('updated_at', $sort);

        return $exemplars->paginate($take);
    }
}
