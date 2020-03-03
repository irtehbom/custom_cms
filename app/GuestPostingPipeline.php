<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuestPostingPipeline extends Model
{
    
    protected $guarded = ['id'];
    protected $table = 'guest_posting_pipeline';

    
    public function projects() {
        return $this->belongsTo(Projects::class);
    }
}
