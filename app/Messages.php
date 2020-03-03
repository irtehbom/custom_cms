<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $guarded = ['id'];
    
    public function threads() {
        return $this->belongsTo(Threads::class);
    }
    public function files() {
        return $this->hasMany(Files::class);
    }
    
}
