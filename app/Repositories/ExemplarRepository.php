<?php

namespace App\Repositories;

use App\Contracts\CanBeExemplar;
use App\Exemplar;
use App\User;
use App\Video;
use Auth;
use Exception;
use Mail;

class ExemplarRepository
{
    /**
     * Mark this model as being exemplar and give a reason
     *
     * @param App\Contracts\CanBeExemplar $model
     * @param string $reason
     * @return bool
     */
    public function markAsExemplar(CanBeExemplar $model, $reason)
    {
        // Create a new blank exemplar
        $exemplar = new Exemplar([
            'reason' => $reason,
            'author_id' => Auth::id(),
            'approved' => 1,
            'approver_id' => 1
        ]);

        // TODO: send an email to project admins to check out this exemplar
        $title = $model->title;

        if(get_class($model) == Video::class)
        {
            $url =  "video-center/".$model->id;
            $model_name =  "Video Center";
            $url2 = "video-center/exemplars";
        }
        else
        {
            $url = "instructional-design/".$model->id;
            $model_name = "Instructional Design";
            $url2 =  "instructional-design/exemplars";
        }

        $superAdmin = $owner_user = User::find(1);

        // Send the user an email to super admin
        Mail::send('emails.exemplar.request', compact('title','url','url2','model_name'), function ($m) use ($title,$url, $url2, $model_name, $superAdmin) {
            $m->from('support@earlyscienceinitiative.org', 'Early Science Initiative');
            $m->to($superAdmin->email, 'Super Admin')->subject("You have a new exemplar approval request");
        });

        // Assign the new exemplar to the model
        return $model->exemplars()->save($exemplar);
    }

    /**
     * Accept the exemplar attached to this model if one exists
     *
     * @param App\Contracts\CanBeExemplar $model
     * @return bool
     */
    public function acceptAsExemplar(CanBeExemplar $model)
    {
        // If the user is a super admin and the model isn't already exemplar then
        // just make it exemplar
        if (Auth::user()->is('super_admin') && !$model->hasExemplarRequest) {
            $exemplar = $this->markAsExemplar($model, '');
        } else if ($model->exemplar()) {
            $exemplar = $model->exemplar();
        } else {
            throw new Exception("This object hasn't been marked as exemplar, so cannot be accepted");
        }

        // TODO: send an email to the exemplar author that it has been accepted

        $title = $model->title;
        $url = get_class($model) == Video::class ? "video-center/".$model->id : "instructional-design/".$model->id;
        $owner_user = User::find($model->author_id);
        $name = $owner_user->name;
        // Send the user an email
        Mail::send('emails.exemplar.approved', compact('user', 'title','url','name'), function ($m) use ($owner_user,$title,$url,$name) {
            $m->from('support@earlyscienceinitiative.org', 'Early Science Initiative');
            $m->to($owner_user->email, $owner_user->name)->subject("You exemplar request has been approved");
        });

        return $exemplar->update([
            'approved' => 1,
            'approver_id' => Auth::id()
        ]);
    }

    /**
     * Deny the exemplar attached to this model if one exists
     *
     * @param App\Contracts\CanBeExemplar $model
     * @param string $reason
     * @return bool
     */
    public function denyAsExemplar(CanBeExemplar $model, $reason)
    {
        if (!$model->exemplar()) {
            throw new Exception("This object hasn't been marked as exemplar, so cannot be denied");
        }

        // TODO: send an email to the exemplar author that it has been denied

        $title = $model->title;
        $url = get_class($model) == Video::class ? "video-center/".$model->id : "instructional-design/".$model->id;
        $owner_user = User::find($model->author_id);
        $name = $owner_user->name;

        // Send the user an email
        Mail::send('emails.exemplar.rejected', compact('user', 'title','url','reason','name'), function ($m) use ($owner_user,$title,$url, $reason, $name) {
            $m->from('support@earlyscienceinitiative.org', 'Early Science Initiative');
            $m->to($owner_user->email, $owner_user->name)->subject("You exemplar request has been rejected");
        });

        return $model->exemplar()->update([
            'approved' => -1,
            'approver_id' => Auth::id(),
            'rejected_reason' => $reason
        ]);


    }
}
