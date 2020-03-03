<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Threads extends Model
{
    
    protected $guarded = ['id'];
    
    public function projects() {
        return $this->belongsTo(Projects::class);
    }
    
    public function messages() {
        return $this->hasMany(Messages::class);
    }
    
}
