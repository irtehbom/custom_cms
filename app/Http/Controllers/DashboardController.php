<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use App\User;
use App\Messages;
use App\Threads;
use App\Time;
use App\Planning;
use Carbon\Carbon;

class DashboardController extends Controller {

    public function __construct(Request $request) {
        $this->middleware('auth');
        $this->users = new User;
        $this->projects = new Projects;
        $this->threads = new Threads;
        $this->time = new Time;
        $this->messages = new Messages;
    }

    public function index(Request $request) {
        
        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator', 'Consultant', 'Customer'])) {
            return redirect('/dashboard');
        }
        
        return view('dashboard');
        
    }

    public function allActivityOverview(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $projects = $this->projects->all()->sortByDesc("updated_at");

        $projectArr = array();

        foreach ($projects as $project) {
            $messages = $project->threads()->get();
            $time = $project->time()->get();
            $files = $project->files()->get();
            $collection = collect([$messages, $time, $files])->collapse();
            $collectionSorted = $collection->sortByDesc("updated_at");

            array_push($projectArr, array(
                'project' => $project,
                'collection' => $collectionSorted
            ));
        }

        return view('all_activity', [
            "projects" => $projectArr
        ]);
    }

    public function planningView(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        $projects = $this->projects->all();

        $users = $this->users::whereHas('roles', function ($q) {
                    $q->where('role_id', '1')->orWhere('role_id', '2');
                })->get();
                
        $this->planning = new Planning;
                
        $planningData = $this->planning->all();
        
        foreach($planningData as $data) {
            $data->start_date = Carbon::parse($data->start_date)->toDateTimeString();
            $data->end_date = Carbon::parse($data->end_date)->toDateTimeString();
        }


        return view('planning/planning_view', [
            "projects" => $projects,
            "users" => $users,
            "planningData" => $planningData
        ]);
    }
    
    public function planningViewSave(Request $request) {

        $input = $request->input();
        
        $calanderData = $input['calanderData'];
        
        foreach($calanderData as $data) {
            
            $this->planning = new Planning;

            $dataArr = $data['data'];
            $instanceArr = $data['instance'];
            $propData = $dataArr['extendedProps'];
            $start = Carbon::parse($data['start']);
            $end = Carbon::parse($data['end']);
            
            $exists = $this->planning->where('guid', $propData['guid'])->exists();

            if(!$exists) {

                $this->planning->project_id = $propData['projectID'];
                $this->planning->user_id = $dataArr['resourceIds'][0];
                $this->planning->task_id = $propData['taskID'];
                $this->planning->task_name = $propData['taskName'];
                $this->planning->instance_id = $instanceArr['instanceId'];
                $this->planning->start_date = $start->toDateTimeString(); 
                $this->planning->end_date = $end->toDateTimeString(); 
                $this->planning->title = $dataArr['title'];
                $this->planning->notes = $propData['notes'];
                $this->planning->guid = $propData['guid'];
                $this->planning->save();
            
            } else {
                
                $record = $this->planning->where('guid', $propData['guid'])->first();

                $record->user_id = $dataArr['resourceIds'][0];
                $record->start_date = $start->toDateTimeString(); 
                $record->end_date = $end->toDateTimeString(); 
                
                $record->save();
                
            }
            
        }

    }

}
