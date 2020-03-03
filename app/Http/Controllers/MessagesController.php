<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use App\User;
use App\Messages;
use App\Threads;
use App\Files;
use App\Http\Controllers\MailController;

class MessagesController extends Controller {

    public function __construct(Request $request) {
        $this->middleware('auth');
        $this->users = new User;
        $this->projects = new Projects;
        $this->messages = new Messages;
        $this->threads = new Threads;
        $this->files = new Files;
        $this->mail = new MailController;
    }

    public function create(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator', 'Consultant', 'Customer'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();

        $project = $this->projects->find($params['id']);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        return view('single_projects/create_thread', [
            "project" => $project,
            "user" => $user
        ]);
    }

    public function createSave(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator', 'Consultant', 'Customer'])) {
            return redirect('/dashboard');
        }

        $input = $request->input();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);
        $project->ws_read = 0;
        $project->client_read = 0;
        $project->save();

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        $message = Messages::create([
                    'message' => $input['message'],
                    'user_name' => $user->name
        ]);

        $this->files->fileUpload($request->files, $message, $project, $user);

        $thread = $this->threads;

        $project->threads()->save($this->threads);
        $thread->messages()->save($message);
        $thread->title = $input['title'];
        $thread->ws_read = 0;
        $thread->client_read = 0;
        $thread->type = 'thread';
        $thread->save();

        $request->session()->flash('message', '<div class="alert alert-success">Created Successfully</div>');

        foreach ($project->users()->get() as $userMail) {

            if ($userMail->email != $user->email) {
                $this->mail->sendMessageNotification($userMail->email, $userMail->name, $user->name, '/dashboard/project/' . $project->id . '/messages/' . $thread->id);
            }

            foreach ($this->users->all() as $wildshark_users) {
                $role = $user->getRoleName($wildshark_users);
                if ($role == 'Consultant' || $role == 'Administrator') {
                    $this->mail->sendMessageNotification($wildshark_users->email, $wildshark_users->name, $user->name, '/dashboard/project/' . $project->id . '/messages/' . $thread->id);
                }
            }
        }

        if (count($request->files->all()) > 0) {
            echo '/dashboard/project/' . $project->id . '/messages/' . $thread->id;
        } else {
            return redirect('/dashboard/project/' . $project->id . '/messages/' . $thread->id);
        }
    }

    public function viewThread(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator', 'Consultant', 'Customer'])) {
            return redirect('/dashboard');
        }

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);
        $thread = $this->threads->find($params['thread_id']);
        $messages = $thread->messages()->get();

        $role = $user->getRoleName($user);

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        if ($role == 'Administrator' || $role == 'Consultant') {
            $thread->ws_read = 1;
            $thread->save();
            $project->ws_read = 1;
            $project->save();
        } else {
            $thread->client_read = 1;
            $thread->save();
            $project->client_read = 1;
            $project->save();
        }

        return view('single_projects/view_thread', [
            "project" => $project,
            "thread" => $thread,
            "messages" => $messages,
            "user" => $user
        ]);
    }

    public function saveThread(Request $request) {

        $user = $request->user();

        if (!$user->authorizeRoles(['Administrator', 'Consultant', 'Customer'])) {
            return redirect('/dashboard');
        }

        $input = $request->input();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        $params = request()->route()->parameters();

        $project = $this->projects->find($params['id']);
        $project->ws_read = 0;
        $project->client_read = 0;
        $project->save();

        $thread = $this->threads->find($params['thread_id']);
        $thread->ws_read = 0;
        $thread->client_read = 0;

        if (!$project->canAccessProject($project, $request->user())) {
            return redirect('/dashboard');
        }

        $message = Messages::create([
                    'message' => $input['message'],
                    'user_name' => $user->name
        ]);

        $this->files->fileUpload($request->files, $message, $project, $user);

        $project->threads()->save($thread);
        $thread->messages()->save($message);

        foreach ($project->users()->get() as $userMail) {
            $this->mail->sendMessageNotification($userMail->email, $userMail->name, $user->name, '/dashboard/project/' . $project->id . '/messages/' . $thread->id);
        }

        if (count($request->files->all()) > 0) {
            echo '/dashboard/project/' . $project->id . '/messages/' . $thread->id;
        } else {
            return redirect('/dashboard/project/' . $project->id . '/messages/' . $thread->id);
        }
    }

    public function saveThreadEditMessage(Request $request) {

        $user = $request->user();

        $input = $request->input();

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        $project = $this->projects->find($input['project_id']);
        $thread = $this->threads->find($input['thread_id']);

        $message = $this->messages->find($input['message_id']);
        $message->message = $input['message'];
        $message->save();

        if (isset($input['files_to_remove'])) {
            $this->files->fileDelete($input['files_to_remove'], $message);
        }

        if (count($request->files->all()) > 0) {
            $this->files->fileUpload($request->files, $message, $project, $user);
        }

        echo '/dashboard/project/' . $project->id . '/messages/' . $thread->id;
    }

}
