<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use App\User;
use App\Time;
use Carbon\Carbon;

class TimeController extends Controller {

    public function __construct(Request $request) {
        $this->middleware('auth');
        $this->users = new User;
        $this->projects = new Projects;
        $this->time = new Time;
    }

    public function create(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        return view('single_projects/time/create_time', [
            "project" => $project,
            "user" => $user
        ]);
    }

    public function createSave(Request $request) {

        $user = $request->user();
        $time = $this->time;

        if (!$user->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $input = $request->input();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);
        $project->time()->save($time);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        $timeLogged = $input['hours'] . ":" . $input['minuites'] . ":00";

        $time->time_logged = $time->time_to_decimal($timeLogged);
        $time->hours = $input['hours'];
        $time->minutes = $input['minuites'];
        $time->user_name = $user->name;
        $time->date = Carbon::createFromFormat('d/m/Y', $input['date']);
        $time->title = $input['title'];
        $time->description = $input['description'];
        $time->type = 'time';
        $time->save();

        $project->touch();

        $request->session()->flash('message', '<div class="alert alert-success">Created Successfully</div>');

        return redirect('/dashboard/project/' . $project->id . '/time/');
    }

    public function edit(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);
        $time = $project->time()->find($params['time_id']);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        return view('single_projects/time/edit_time', [
            "project" => $project,
            "user" => $user,
            "time" => $time
        ]);
    }

    public function editSave(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();

        $input = $request->input();
        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        $project = $this->projects->find($params['id']);

        $time = $project->time()->find($params['time_id']);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        $timeLogged = $input['hours'] . ":" . $input['minuites'] . ":00";

        $time->time_logged = $time->time_to_decimal($timeLogged);
        $time->hours = $input['hours'];
        $time->minutes = $input['minuites'];
        $time->user_name = $user->name;
        $time->date = Carbon::createFromFormat('d/m/Y', $input['date']);
        $time->title = $input['title'];
        $time->description = $input['description'];
        $time->type = 'time';
        $time->save();

        return view('single_projects/time/edit_time', [
            "project" => $project,
            "user" => $user,
            "time" => $time
        ]);
    }

    public function delete(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        $time = $project->time()->find($params['time_id']);
        $time->delete();
        
        $request->session()->flash('message', '<div class="alert alert-success">Deleted Successfully</div>');

        return redirect('/dashboard/project/' . $project->id . '/time/');

    }

    public function timeTracker(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $projects = $this->projects->all();
        $timeModal = $this->time;

        foreach ($projects as $project) {
            $project->timedata = $timeModal->getMonthTime($project, [1, 2, 3]);
        }

        return view('timetracker/timetracker', [
            "projects" => $projects,
            "user" => $user
        ]);
    }

}
