<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use App\User;
use App\Messages;
use App\Threads;
use App\Time;
use Carbon\Carbon;
use Analytics;
use Spatie\Analytics\Period;

//use MailClient;

class SingleProjectsController extends Controller {

    public function __construct(Request $request) {
        $this->middleware('auth');
        $this->users = new User;
        $this->projects = new Projects;
        $this->threads = new Threads;
        $this->time = new Time;
        $this->messages = new Messages;
    }

    public function overview(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator', 'Consultant', 'Customer'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        $role = $user->getRoleName($user);

        if ($role == 'Administrator' || $role == 'Consultant') {
            $project->ws_read = 1;
            $project->save();
        } else {
            $project->client_read = 1;
            $project->save();
        }

        $messages = $project->threads()->get();
        $time = $project->time()->get();
        $qa = $project->qa()->first();
        $files = $project->files()->get();
        $citations = $project->citations()->first();
        $collection = collect([$messages, $time, $files])->collapse();

        $activities = $collection->sortByDesc("updated_at")->groupBy(function($date) {
            return Carbon::parse($date->updated_at)->format('d M y');
        });

        $analyticsData = new \stdClass();

        try {
            Analytics::setViewId('83857086');

            $analytics = Analytics::performQuery(
                            Period::years(1), 'ga:sessions', [
                        'metrics' => 'ga:sessions',
                        'dimensions' => 'ga:yearMonth',
                        'filters' => 'ga:medium==organic'
                            ]
            );

            $rows = $analytics->rows;

            $dates = array();
            $visitors = array();

            foreach ($rows as $row) {
                $date = substr($row[0], 0, 4) . "/" . substr($row[0], 4);
                array_push($dates, $date);
                array_push($visitors, $row[1]);
            }

            $analyticsData->dates = $dates;
            $analyticsData->visitors = $visitors;
            $analyticsData->error = null;
            
        } catch (\Exception $e) {
            $analyticsData->dates = null;
            $analyticsData->visitors = null;
            $analyticsData->error = json_decode($e->getMessage());
        }

        return view('single_projects/overview', [
            "project" => $project,
            "activities" => $activities,
            "qa" => $qa,
            "citations" => $citations,
            "analytics" => $analyticsData
        ]);
    }

    public function messages(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant', 'Customer'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);

        $threads = $project->threads()->get()->sortByDesc("updated_at");

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        return view('single_projects/messages', [
            "project" => $project,
            "threads" => $threads
        ]);
    }

    public function time(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant', 'Customer'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        $timeModal = $this->time;

        $allTime = $project->time()->get()->sortByDesc("date")->groupBy(function($item) {
            return $item->date->format('d M y');
        });

        $currentMonthData = $timeModal->getMonthTime($project, [1]);

        return view('single_projects/time/time', [
            "project" => $project,
            "time" => $allTime->toArray(),
            "timeModal" => $timeModal,
            "currentMonth" => $currentMonthData
        ]);
    }

    public function GuestPostingPipelineOverview(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant', 'Customer'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        return view('single_projects/guest_posting_pipeline/overview', [
            "project" => $project
        ]);
    }

    public function GuestPostingPipelineSourcingAnalysing(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);
        $domains = $project->GuestPostingPipeline()
                        ->where('flagged', 0)
                        ->where('analysed', 0)->get();

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        $analysis = array(
            0 => "Not Analysed",
            1 => "Yes - Outreach",
            2 => "Yes - Don't Outreach"
        );

        return view('single_projects/guest_posting_pipeline/sourcing_analysing', [
            "project" => $project,
            "domains" => $domains,
            "analysis" => $analysis
        ]);
    }

    public function GuestPostingPipelineOutreachView(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);
        $domains = $project->GuestPostingPipeline()
                        ->where('flagged', 0)
                        ->where('analysed', 1)->get();

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        $stage = array(
            0 => "N/A",
            1 => "Need To Reach Out",
            2 => "Email Sent",
            3 => "Recieved Response",
            4 => "Topic Approved",
            5 => "Link Aquired",
        );

        $category = array(
            0 => "Not Set",
            1 => "Business",
            2 => "Travel"
        );

        /*
          $oClient = MailClient::account('gmail');
          $oClient->connect();
          $aFolder = $oClient->getFolders();
          dd($aFolder);
         */

        return view('single_projects/guest_posting_pipeline/outreach', [
            "project" => $project,
            "domains" => $domains,
            "stage" => $stage,
            "category" => $category
        ]);
    }

    public function qaView(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant', 'Customer'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        $qa = $project->qa()->first();

        return view('single_projects/qa', [
            "qa" => $qa,
            "project" => $project
        ]);
    }

    public function citationsView(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant', 'Customer'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        $citations = $project->citations()->first();

        return view('single_projects/citations', [
            "citations" => $citations,
            "project" => $project
        ]);
    }

    public function filesView(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant', 'Customer'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        $files = $project->files()->get();

        return view('single_projects/files', [
            "files" => $files,
            "project" => $project
        ]);
    }

}
