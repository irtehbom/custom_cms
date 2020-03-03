<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class qa extends Model
{
     public function projects() {
        return $this->belongsTo(Projects::class);
    }
}
