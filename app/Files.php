<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Files;
use App\Helpers;
use Storage;
use App\Messages;
use File;

class Files extends Model {

    public function projects() {
        return $this->belongsTo(Projects::class);
    }

    public function messages() {
        return $this->belongsTo(Messages::class);
    }

    public function fileUpload($files, $message, $project, $user) {

        $this->helpers = new Helpers;

        foreach ($files->all() as $file) {

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

                $message->files()->save($file);
                $project->files()->save($file);
            }
        }
    }

    public function fileDelete($files, $message) {

        $this->helpers = new Helpers;

        $fileObj = new Files;

        foreach ($files as $file) {
            $fileToDelete = $fileObj->find($file);
            Storage::disk('media')->delete($fileToDelete->filename);
            $fileToDelete->delete();
        }
    }

}
