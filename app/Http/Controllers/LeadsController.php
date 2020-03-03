<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class LeadsController extends Controller {

    public function __construct(Request $request) {
        $this->middleware('auth');
        $this->users = new User;
    }

    public function index(Request $request) {
        
        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }
        
        return view('leads/add');
    }

    public function save(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        return view('all_activity', [
            "projects" => $projectArr
        ]);
    }

}
