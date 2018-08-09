<?php

namespace App\Http\Controllers\Api\Videos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Video;
use App\Annotation;
use App\VideoColumnObject;
use App\VideoColumn;

class AnnotationsController extends Controller
{
    /**
     * Store a new annotation for a video
     *
     * @param Illuminate\Contracts\Auth\Guard
     * @param Illuminate\Http\Request $request
     * @param int $id
     */
    public function store($subdomain, Guard $auth, Request $request, $id)
    {
        // Get the video the user is commenting on
        $video = Video::findOrFail($id);

        // If the user doesn't have permission to annotate on this video then
        // throw a 403 error
        if ($auth->user()->cannot('annotate', $video)) {
            abort(403, 'You do not have permission to annotate this video');
        }

        $minutesStart = $request->get('minutes_start');
        $secondsStart = $request->get('seconds_start');

        $minutesEnd = $request->get('minutes_end');
        $secondsEnd = $request->get('seconds_end');

        $startTs = $minutesStart * 60 + $secondsStart;
        $endTs = $minutesEnd * 60 + $secondsEnd;

        $timeRange = $startTs + $endTs;

        $annotation = $video->annotations()->save(new Annotation([
            'author_id' => $auth->id(),
            'content' => $request->get('content'),
            //'time' => $request->get('time'),
            'time_start' => $startTs,
            'time_end' => $endTs
        ]));

        // Check if a column was selected
        if ($request->has('ann_column')) {
            $columnId = $request->get('ann_column');

            if (!empty($columnId) && $columnId > 0) {
                VideoColumnObject::create([
                    'video_column_id' => $columnId,
                    'object_id' => $annotation->id,
                    'object_type' => 'App\\Annotation',
                ]);
            }
        }

        // Check if a color was passed
        if ($request->has('column_color')) {
            // Check if a column with this color already exists
            $checkExist = VideoColumn::where('color', $request->get('column_color'))->where('video_id', $id)->get()->first();
            
            if ($checkExist) {
                $columnId = $checkExist->id;
            } else {
                $columnId = VideoColumn::create([
                    'video_id' => $id,
                    'author_id' => $auth->user()->id,
                    'name' => 'Untitled',
                    'color' => $request->get('column_color')
                ])->id;
            }

            // Add this annotation to this column
            VideoColumnObject::create([
                'video_column_id' => $columnId,
                'object_id' => $annotation->id,
                'object_type' => 'App\\Annotation',
            ]);
        }

        return $annotation ? response($annotation->id, 200) : abort(400);
    }
}
