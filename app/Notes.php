<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    protected $guarded = ['id'];
    
    public function projects() {
        return $this->belongsTo(Projects::class);
    }
    
}
