<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentGroup extends Model
{
    protected $fillable = ['group_name'];
    public $timestamps = false;
    public function incidents()
    {
        return $this->hasMany('App\Incident');
    }
}
