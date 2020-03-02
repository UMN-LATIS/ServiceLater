<?php

namespace App\Http\Controllers;

use App\DataTables\IncidentsDataTable;

use Illuminate\Http\Request;
use App\Incident;
use Auth;
class IncidentsController extends Controller
{
    public function index(IncidentsDataTable $dataTable)
    {
        return $dataTable->render('incidents.index');
    }

    public function show(Incident $incident) {
        if(Auth::user()->assignmentGroups->contains($incident->assignmentGroup)) {
            activity()
                ->performedOn($incident)
                ->causedBy(Auth::user())
                ->log('Viewing Incident');
            return view("incidents.show", ["incident"=>$incident]);
        }
        else {
            abort(403);
        }
        
    }
}
