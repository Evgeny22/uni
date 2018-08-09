<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\GroupRepository;
use Auth;
use stdClass;

class ParticipantsController extends Controller
{
    /**
     * Lists out the possible participants for a message
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View;
     */
    public function index($subdomain, Request $request)
    {
        $output = [];

        // Get the possible participants
        $participants = with(new UserRepository)->getVisibleUsers(Auth::user(), $request->get('q'));

        // Get the groups that this user can search
        $groups = with(new GroupRepository)->getUserGroupsPretty(Auth::user());

        foreach ($participants as $participant) {
            $obj = new stdClass;
            $obj->id = $participant->id;
            $obj->text = $participant->display_name;
            $obj->url = $participant->avatar->url();
            $output[] = $obj;
        }

        foreach ($groups as $key => $group) {
            $obj = new stdClass;
            $obj->id = $key;
            $obj->text = $group;
            $obj->url = '';
            $output[] = $obj;
        }

        return ['results' => collect($output)->values()];
        //print_r($groups);
    }

    /**
     * Lists out the possible participants minus user ids passed
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View;
     */
    public function exclude($subdomain, Request $request)
    {
      $output = [];

      $excluded_ids = explode(',', $request->get('ids'));

      // Get the possible participants
      $participants = with(new UserRepository)->getVisibleUsers(Auth::user(), $request->get('q'));

      foreach ($participants as $participant) {
        if (in_array($participant->id, $excluded_ids)) {
          continue;
        };

        $obj = new stdClass;
        $obj->id = $participant->id;
        $obj->text = $participant->display_name;
        $obj->url = $participant->avatar->url();
        $output[] = $obj;
      }

      return ['results' => collect($output)->values()];
     }

    public function destroyParticipant($subdomain, Request $request) {
        return redirect()->route('dashboard', [
            'subdomain' => $subdomain
        ]);
    }
}
