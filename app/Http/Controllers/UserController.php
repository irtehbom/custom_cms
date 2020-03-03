<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Projects;
use App\Role;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\MailController;
use Auth;

class UserController extends Controller {

    public function __construct(Request $request) {

        $this->middleware('auth', ['except' => array('usersCreatePassword', 'usersPasswordSave')]);
        $this->users = new User;
        $this->projects = new Projects;
        $this->roles = new Role;
        $this->mail = new MailController;
        
    }

    public function all(Request $request) {


        if (!$request->user()->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        return view('users/all', [
            "data" => $this->users->all()
        ]);
    }

    public function create(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        return view('users/create', [
            "projects" => $this->projects->all()
        ]);
    }

    public function save(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        $input = $request->input();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        if ($this->users::where('email', Input::get('email'))->exists()) {
            $request->session()->flash('message', '<div class="alert alert-danger">A user exists with this email</div>');
            return redirect('dashboard/users/create');
        }

        $user = User::create([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'business_number' => $input['business_number'],
                    'primary_user' => $input['primary_user'],
                    'mobile_number' => $input['mobile_number'],
                    'mobile_number' => $input['mobile_number'],
        ]);

        $user->roles()->attach(Role::where('name', $input['level'])->first());

        $guid = bin2hex(openssl_random_pseudo_bytes(16));

        $user->password_url = url("/dashboard/user/$guid/create_password");
        $user->save();

        if (isset($input['projects'])) {
            $user->projects()->sync($input['projects']);
        } else {
            $user->projects()->detach();
        }

        //Send welcome

        $this->mail->sendWelcome($user->email, $user->name, $user->password_url);

        $request->session()->flash('message', '<div class="alert alert-success">Created Successfully</div>');

        return redirect('dashboard/users/all');
    }

    public function edit(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();

        return view('users/edit', [
            "data" => $this->users->find($params["id"]),
            "projects" => $this->projects->all(),
            "roles" => $this->roles->all()
        ]);
    }

    public function editSave(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $input = $request->input();

        $user = $this->users->find($params["id"]);
        $level = $input['level'];


        if (isset($input['projects'])) {
            $user->projects()->sync($input['projects']);
        } else {
            $user->projects()->detach();
        }

        if (isset($input['_token'])) {
            unset($input['_token']);
            unset($input['projects']);
            unset($input['level']);
        }

        foreach ($input as $key => $value) {
                $user->$key = $value;
        }

        $user->save();
        $user->roles()->update(array(
            'role_id' => $level
        ));


        $request->session()->flash('message', '<div class="alert alert-success">Saved Successfully</div>');

        return redirect('dashboard/users/edit/' . $params["id"]);
    }

    public function deleteObject(Request $request) {

        if (!$request->user()->authorizeRoles(['Administrator'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();

        $object = $this->users->find($params["id"]);
        $object->delete();

        $request->session()->flash('message', '<div class="alert alert-success">Deleted Successfully</div>');

        return redirect('dashboard/users/all');
    }

    public function random_password($length) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    public function usersCreatePassword(Request $request) {

        if ($this->users::where('password_url', $request->url())->exists()) {

            $user = $this->users::where('password_url', $request->url())->first();

            Auth::setUser($user);
            Auth::login($user);

            return view('users/create_password', [
                "user_data" => $user
            ]);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function usersCreatePasswordSave(Request $request) {

        $input = $request->input();

        if ($this->users::where('password_url', $input['id'])->exists()) {

            $user = $this->users::where('password_url', $input['id'])->first();
            $user->password = bcrypt($input['password']);
            $user->save();

            Auth::setUser($user);

            $request->session()->flash('message', '<div class="alert alert-success">Password Updated</div>');


            return redirect('/dashboard');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

}
