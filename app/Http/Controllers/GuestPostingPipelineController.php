<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use App\User;
use App\GuestPostingPipeline;
use Carbon\Carbon;

class GuestPostingPipelineController extends Controller {

    public function __construct(Request $request) {
        $this->middleware('auth');
        $this->users = new User;
        $this->projects = new Projects;
    }

    public function sourcingAddView(Request $request) {

        $user = $request->user();

        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        return view('single_projects/guest_posting_pipeline/prospect_add', [
            "project" => $project,
            "user" => $user
        ]);
    }

    public function sourcingAddSave(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $input = $request->input();
        $params = request()->route()->parameters();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        $project = $this->projects->find($params["id"]);

        $domains = str_replace(array(' ', "\t", "\r"), '', $input['domains']);
        $domainToArray = explode("\n", preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $domains));

        $request->session()->forget(['domains_added', 'domains_exist', 'domains_flagged']);

        foreach ($domainToArray as $domain) {

            $rootDomain = parse_url($domain);

            if (!isset($rootDomain['scheme'])) {
                $rootDomain['scheme'] = 'http';
            }

            if (!isset($rootDomain['host'])) {
                $rootDomain['host'] = $domain;
            }

            if (!isset($rootDomain['path']) || $rootDomain['path'] == $domain) {
                $rootDomain['path'] = '/';
            }

            $exists = $project->GuestPostingPipeline()->where('root_domain', $rootDomain['host'])->exists();
            $flagged = \DB::table('guest_posting_pipeline')->where('root_domain', $rootDomain['host'])->where('flagged', 1)->first();

            if ($flagged) {
                
                $request->session()->push('domains_flagged', $rootDomain['host']);
                
            } else {

                if (!$exists) {

                    $this->guest_posting_pipeline = new GuestPostingPipeline;

                    if (filter_var($rootDomain['scheme'] . '://' . $rootDomain['host'], FILTER_VALIDATE_URL)) {
                        $this->guest_posting_pipeline->scheme = $rootDomain['scheme'];
                        $this->guest_posting_pipeline->root_domain = $rootDomain['host'];
                        $this->guest_posting_pipeline->url = $rootDomain['path'];
                        $this->guest_posting_pipeline->category = 'Not Set';
                        $this->guest_posting_pipeline->analysed = 0;
                        $this->guest_posting_pipeline->flagged = 0;
                        $this->guest_posting_pipeline->added_by_user = $request->user()->name;
                        $project->GuestPostingPipeline()->save($this->guest_posting_pipeline);
                        $request->session()->push('domains_added', $rootDomain['host']);
                    }
                    
                } else {

                    $request->session()->push('domains_exist', $rootDomain['host']);
                }
            }
        }

        return redirect('/dashboard/project/' . $project->id . '/guest-post-pipeline/sourcing-analysing');
    }

    public function sourcingAjax(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $input = $request->input();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        $project = $this->projects->find($input["projectID"]);

        $record = $project->GuestPostingPipeline->find($input['id']);
        $record->analysed = $input['analyses'];

        if ($input['analyses'] == 2) {
            $record->flagged = 1;
        }

        $record->updated_by_user = $request->user()->name;
        $record->save();

        echo $request->user()->name;
    }
    
    
    public function saveDomainNotes(Request $request) {
        
        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $input = $request->input();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        $project = $this->projects->find($input["projectID"]);
        $record = $project->GuestPostingPipeline->find($input['id']);
        $record->notes = $input["notes"];
        $record->save();
        
    }
    
    public function saveDomainDetails(Request $request) {
        
        if (!$request->user()->authorizeRoles(['Administrator', 'Consultant'])) {
            return redirect('/dashboard');
        }

        $input = $request->input();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        $project = $this->projects->find($input["projectID"]);
        
        if($input["type"] == 'Category') {
            $record = $project->GuestPostingPipeline->find($input['id']);
            $record->category = $input["value"];
            $record->save();
        }
        
        if($input["type"] == 'Stage') {
            $record = $project->GuestPostingPipeline->find($input['id']);
            $record->stage = $input["value"];
            $record->save();
        }
        
    }

}
