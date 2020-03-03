<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projects;
use App\User;
use App\Helpers;
use App\Files;
use Storage;
use App\Http\Controllers\MailController;

class FilesController extends Controller {

    public function __construct(Request $request) {
        $this->middleware('auth');
        $this->files = new Files;
        $this->projects = new Projects;
        $this->mail = new MailController;
    }

    public function fileUploadFilesView(Request $request) {

        $this->helpers = new Helpers;
        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);
        $user = $request->user();

        foreach ($request->files as $file) {

            foreach ($file as $fileFinal) {

                $extension = $fileFinal->getClientOriginalExtension();

                $file = new Files;

                $file->mimeType = $fileFinal->getClientMimeType();
                $file->originalName = str_replace(' ', '', $fileFinal->getClientOriginalName());
                $file->filename = $fileFinal->getFilename() . '_' . $this->helpers->gen_uuid() . '.' . $extension;

                $file->path = '/storage/app/public/' . $file->filename;
                $file->type = 'file';
                $file->user_name = $user->name;

                $path = Storage::putFileAs(
                                'public', $fileFinal, $file->filename
                );

                $file->save();
                $project->files()->save($file);
            }
        }

        foreach ($project->users()->get() as $userMail) {
            $this->mail->sendFileNotification($userMail->email, $userMail->name, $user->name);
        }
    }

    public function fileDelete(Request $request) {

        $params = request()->route()->parameters();
        $project = $this->projects->find($params['id']);
        $file = $request->input('file_id');

        $fileToDelete = $project->files->find($file);
        Storage::disk('media')->delete($fileToDelete->filename);
        $fileToDelete->delete();
    }

}
