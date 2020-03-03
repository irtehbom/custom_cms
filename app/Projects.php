<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $guarded = ['id'];
    
    public function users() {
        return $this->belongsToMany(User::class);
    }
    
    public function threads() {
        return $this->hasMany(Threads::class);
    }
    
    public function notes() {
        return $this->hasMany(Notes::class);
    }
    
    public function time() {
        return $this->hasMany(Time::class);
    }
    
    public function GuestPostingPipeline() {
        return $this->hasMany(GuestPostingPipeline::class);
    }
    
    public function citations() {
        return $this->hasOne(Citations::class);
    }
    
    public function qa() {
        return $this->hasOne(Qa::class);
    }
    
    public function files() {
        return $this->hasMany(Files::class);
    }
    
    public function canAccessProject($project, $user) {
        
         if ($user->authorizeRoles(['Administrator', 'Consultant'])) {
             return true;
         }
         
         if($project->users->contains($user)) {
             return true;
         }
         
         return false;
    }
    
}
