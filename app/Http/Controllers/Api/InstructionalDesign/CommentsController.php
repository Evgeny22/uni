<?php

namespace App\Http\Controllers\Api\InstructionalDesign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\LessonPlan;
use App\Comment;

class CommentsController extends Controller
{
    /**
     * Store a new comment for a lesson plan
     *
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function store($subdomain, Guard $auth, Request $request, $id)
    {
        // Get the lesson plan the user is commenting on
        $lessonPlan = LessonPlan::findOrFail($id);

        // If the user doesn't have permission to comment on this lesson plan then
        // throw a 403 error
        if ($auth->user()->cannot('comment', $lessonPlan)) {
            abort(403, 'You do not have permission to comment on this Lesson Plan');
        }

        $saved = $lessonPlan->comments()->save(new Comment([
            'author_id' => $auth->id(),
            'content' => $request->get('content'),
            'approved' => 1,
            'type' => $request->get('type'),
            'parent_id' => !empty($parentId) ? $parentId : null
        ]));

        return $saved ? response(['comment_id' => $saved->id], 200) : abort(400);
    }

    /**
     * Stores a comment with a "comment_date"
     *
     * @param $subdomain
     * @param Guard $auth
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response|void
     */
    public function storeActivityComment($subdomain, Guard $auth, Request $request, $id)
    {
        // Get the lesson plan the user is commenting on
        $lessonPlan = LessonPlan::findOrFail($id);

        // If the user doesn't have permission to comment on this lesson plan then
        // throw a 403 error
        if ($auth->user()->cannot('comment', $lessonPlan)) {
            abort(403, 'You do not have permission to comment on this Lesson Plan');
        }

        $saved = $lessonPlan->comments()->save(new Comment([
            'author_id' => $auth->id(),
            'content' => $request->get('content'),
            'approved' => 1,
            'type' => $request->get('type'),
            'comment_date' => $request->get('comment_date')
        ]));

        return $saved ? response(null, 200) : abort(400);
    }
}
