<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\DeleteRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\VideoRepository;
use App\Exemplar;

class PendingRequestsController extends Controller
{
    /**
     * Shows a list of all pending requests
     *
     * @param Illuminate\Contracts\Auth\Guard $auth
     * @param Illuminate\Http\Request $request
     * @return Illuminate\View\View
     */
    public function index(Guard $auth, Request $request)
    {
        $pendingResource = Exemplar::where('approved', 0)
            ->orderBy('updated_at', 'desc')
            ->get();
        $pendingRecovered = collect([]);
        $pendingDeleted = DeleteRequest::where('approved', 0)
            ->get();

        return view('pending-requests.index', [
            'page' => 'pending-requests',
            'title' => 'Pending Requests',
            'pendingResource' => $pendingResource,
            'pendingRecovered' => $pendingRecovered,
            'pendingDeleted' => $pendingDeleted
        ]);
    }
}
