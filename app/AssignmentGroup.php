<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentGroup extends Model
{
    public function incidents()
    {
        return $this->hasMany('App\Incident');
    }
}
