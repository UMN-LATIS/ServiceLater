<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use FullTextSearch;
    protected $dates = [
        "opened_at",
        "closed_at"
    ];

    protected $searchable = [
        'search'
    ];

    public $timestamps = false;
     

    public function getRouteKeyName()
    {
        return 'incident';
    }
    /**
     * Get the post that owns the comment.
     */
    public function assignmentGroup()
    {
        return $this->belongsTo('App\AssignmentGroup');
    }
}
