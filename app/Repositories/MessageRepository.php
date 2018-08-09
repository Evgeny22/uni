<?php

namespace App\Repositories;

use App\Message;
use App\User;
use App\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MessageRepository
{
    /**
     * Get the latest messages for a user
     *
     * @param int $id
     * @param int $take
     * @param string $sort
     * @param string $query
     * @return Illuminate\Support\Collection
     */
    public function messagesForUser($take = 10, $sort = 'desc', $query = '')
    {
        // Setup the query for retrieving a user's messages
        $messages = Message::with([
            'comments',
            'comments.author',
            'author',
            'participants']
        )->orderBy('updated_at', $sort);

        // If the user isn't a project admin or super admin then scope the messages
        // to only include messages they have authored or are participating in
        if (!Auth::user()->isEither(['project_admin', 'super_admin'])) {
            $messages->authoredOrParticipating(Auth::user()->id);
        }

        // If a search query is provided then find a message by title or author
        if ($query) {
            $messages->searchTitleOrAuthor($query);
        }

        return $messages->paginate($take);
    }

    public function messagesForUserSearch($id, $take = 10, $sort = 'desc', $year = '', $month = '', $day = '', $author = '', $title = '', $tags = []) {
        if ($tags) {
            // If a search query is provided then find learning modules by title

            //$tags = explode(',', $tags);
            $messages = Message::all()->keyBy('id');
            $collection = $messages;

            foreach ($tags as $tag_id) {
                $tag = Tag::where('id', $tag_id)->first();

                if ($tag != null) {
                    $intersect = $collection->intersect($tag->messages->keyBy('id'));
                } else {
                    $intersect = $collection->intersect([]);
                }

                $messages = $intersect;
            }

            $ids = $messages->keyBy('id')->keys();
            $messages = Message::whereIn('id', $ids)->with([
                    'comments',
                    'comments.author',
                    'author',
                    'participants']
            )->orderBy('updated_at', $sort);
        } else {
            // Setup the query for retrieving a user's messages
            $messages = Message::with(['comments', 'comments.author', 'author', 'participants'])->orderBy('updated_at', $sort);

            if ($year) {
                $messages->where(DB::raw('YEAR(created_at)'), '=', $year);
            }

            if ($month) {
                $messages->where(DB::raw('MONTH(created_at)'), '=', $month);
            }

            if ($day) {
                $messages->where(DB::raw('DAY(created_at)'), '=', $day);
            }

            if ($author) {
                /*$messages->where(function ($q) use ($author) {
                    $q->whereHas('author', function ($q) use ($author) {
                        $q->where('name', 'LIKE', "%$author%");
                        $q->orWhere('nickname', 'LIKE', "%$author%");
                    });
                });*/
                $messages->whereIn('author_id', $author);
            }

            if ($title) {
                $messages->where(DB::raw('title'), 'LIKE', '%' . $title . '%');
            }
        }

        return $messages->paginate($take);
    }
}
