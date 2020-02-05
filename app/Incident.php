<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $dates = [
        "opened_at",
        "closed_at"
    ];
     public $timestamps = false;
     
    /**
     * Get the post that owns the comment.
     */
    public function assignmentGroup()
    {
        return $this->belongsTo('App\AssignmentGroup');
    }
}
