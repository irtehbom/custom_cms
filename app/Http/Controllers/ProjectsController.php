<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use App\User;
use Illuminate\Support\Facades\Input;
use App\Citations;
use App\Qa;

class ProjectsController extends Controller {

    public function __construct(Request $request) {
        $this->middleware('auth');
        $this->users = new User;
        $this->projects = new Projects;
        $this->citations = new Citations;
        $this->qa = new Qa;
    }

    public function all(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        $projects = $this->projects->all();

        return view('projects/all', [
            "data" => $projects
        ]);
    }

    public function create(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        return view('projects/create');
    }

    public function save(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        $input = $request->input();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        if ($this->projects::where('name', Input::get('name'))->exists()) {
            $request->session()->flash('message', '<div class="alert alert-danger">A Project exists with this name</div>');
            return redirect('dashboard/projects/create');
        }
        
        $this->projects->name = $input['name'];
        $this->projects->description = $input['description'];
        $this->projects->website = $input['website'];
        $this->projects->ws_read = 1;
        $this->projects->client_read = 0;
        $this->projects->start = $input['start'];
        $this->projects->end = $input['end'];
        $this->projects->hours = $input['hours'];
        $this->projects->cms_url = $input['cms_url'];
        $this->projects->cms_username = $input['cms_username'];
        $this->projects->cms_password = $input['cms_password'];
        $this->projects->ftp_ip = $input['ftp_ip'];
        $this->projects->ftp_username = $input['ftp_username'];
        $this->projects->ftp_password = $input['ftp_password'];
        $this->projects->save();
        
        $this->citations->company_owners = $input['company_owners'];
        $this->citations->genders = $input['genders'];
        $this->citations->business_name = $input['business_name'];
        $this->citations->address_line_1 = $input['address_line_1'];
        $this->citations->address_line_2 = $input['address_line_2'];
        $this->citations->city = $input['city'];
        $this->citations->state = $input['state'];
        $this->citations->postcode = $input['postcode'];
        $this->citations->virtual = $input['virtual'];
        $this->citations->offices_same_city = $input['offices_same_city'];
        $this->citations->phone = $input['phone'];
        $this->citations->business_changes = $input['business_changes'];
        $this->citations->email_address = $input['email_address'];
        $this->citations->hours_of_operation = $input['hours_of_operation'];
        $this->citations->years_in_business = $input['years_in_business'];
        $this->citations->tagline = $input['tagline'];
        $this->citations->business_description = $input['business_description'];
        $this->citations->payments_accepted = $input['payments_accepted'];
        $this->citations->website_url = $input['website_url'];
        $this->citations->google_maps_url = $input['google_maps_url'];
        $this->citations->twitter = $input['twitter'];
        $this->citations->facebook = $input['facebook'];
        $this->citations->linkedin = $input['linkedin'];
        $this->citations->youtube = $input['youtube'];
        $this->citations->google_plus = $input['google_plus'];
        $this->citations->categories = $input['categories'];
        $this->citations->services_offer = $input['services_offer'];
        $this->citations->products_offer = $input['products_offer'];
        $this->citations->service_description_1 = $input['service_description_1'];
        $this->citations->service_description_2 = $input['service_description_2'];
        $this->citations->service_description_3 = $input['service_description_3'];
        $this->citations->areas_served = $input['areas_served'];
        $this->citations->company_logo = $input['company_logo'];
        $this->citations->profile_logo = $input['profile_logo'];
        $this->projects->citations()->save($this->citations);
        
        $this->qa->main_contact = $input['profile_logo'];
        $this->qa->other_contact = $input['other_contact'];
        $this->qa->sales = $input['sales'];
        $this->qa->potential_keywords = $input['potential_keywords'];
        $this->qa->popular_products_services = $input['popular_products_services'];
        $this->qa->profitable_products_services = $input['profitable_products_services'];
        $this->qa->competitors = $input['competitors'];
        $this->qa->geography = $input['geography'];
        $this->qa->goals = $input['goals'];
        $this->qa->other_urls = $input['other_urls'];
        $this->projects->qa()->save($this->qa);
       
        $request->session()->flash('message', '<div class="alert alert-success">Created Successfully</div>');

        return redirect('dashboard/projects/create');
    }

    public function edit(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();

        return view('projects/edit', [
            "project" => $this->projects->find($params["id"])
        ]);
    }

    public function editSave(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $input = $request->input();
        
        if (isset($input['_token'])) {
            unset($input['_token']);
        }
       
        $project = $this->projects->find($params["id"]);
        
        $project->name = $input['name'];
        $project->description = $input['description'];
        $project->website = $input['website'];
        $project->ws_read = 1;
        $project->client_read = 0;
        $project->start = $input['start'];
        $project->end = $input['end'];
        $project->hours = $input['hours'];
        $project->cms_url = $input['cms_url'];
        $project->cms_username = $input['cms_username'];
        $project->cms_password = $input['cms_password'];
        $project->ftp_ip = $input['ftp_ip'];
        $project->ftp_username = $input['ftp_username'];
        $project->ftp_password = $input['ftp_password'];
        $project->save();
        
        $citations = $project->citations->first();
        
        $citations->company_owners = $input['company_owners'];
        $citations->genders = $input['genders'];
        $citations->business_name = $input['business_name'];
        $citations->address_line_1 = $input['address_line_1'];
        $citations->address_line_2 = $input['address_line_2'];
        $citations->city = $input['city'];
        $citations->state = $input['state'];
        $citations->postcode = $input['postcode'];
        $citations->virtual = $input['virtual'];
        $citations->offices_same_city = $input['offices_same_city'];
        $citations->phone = $input['phone'];
        $citations->business_changes = $input['business_changes'];
        $citations->email_address = $input['email_address'];
        $citations->hours_of_operation = $input['hours_of_operation'];
        $citations->years_in_business = $input['years_in_business'];
        $citations->tagline = $input['tagline'];
        $citations->business_description = $input['business_description'];
        $citations->payments_accepted = $input['payments_accepted'];
        $citations->website_url = $input['website_url'];
        $citations->google_maps_url = $input['google_maps_url'];
        $citations->twitter = $input['twitter'];
        $citations->facebook = $input['facebook'];
        $citations->linkedin = $input['linkedin'];
        $citations->youtube = $input['youtube'];
        $citations->google_plus = $input['google_plus'];
        $citations->categories = $input['categories'];
        $citations->services_offer = $input['services_offer'];
        $citations->products_offer = $input['products_offer'];
        $citations->service_description_1 = $input['service_description_1'];
        $citations->service_description_2 = $input['service_description_2'];
        $citations->service_description_3 = $input['service_description_3'];
        $citations->areas_served = $input['areas_served'];
        $citations->company_logo = $input['company_logo'];
        $citations->profile_logo = $input['profile_logo'];
        $citations->save();
        
        $qas = $project->qa->first();
        
        $qas->main_contact = $input['profile_logo'];
        $qas->other_contact = $input['other_contact'];
        $qas->sales = $input['sales'];
        $qas->potential_keywords = $input['potential_keywords'];
        $qas->popular_products_services = $input['popular_products_services'];
        $qas->profitable_products_services = $input['profitable_products_services'];
        $qas->competitors = $input['competitors'];
        $qas->geography = $input['geography'];
        $qas->goals = $input['goals'];
        $qas->other_urls = $input['other_urls'];
        $qas->save();

        $request->session()->flash('message', '<div class="alert alert-success">Saved Successfully</div>');

        return redirect('dashboard/projects/edit/' . $params["id"]);
    }

    public function deleteObject(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();

        $request->session()->flash('message', '<div class="alert alert-success">Deleted Successfully</div>');

        $object = $this->projects->find($params["id"]);
        $object->delete();

        return redirect('dashboard/projects/all');
    }

}
