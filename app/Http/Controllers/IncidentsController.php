<?php

namespace App\Http\Controllers;

use App\DataTables\IncidentsDataTable;

use Illuminate\Http\Request;
use App\Incident;
class IncidentsController extends Controller
{
    public function index(IncidentsDataTable $dataTable)
    {

        return $dataTable->render('incidents.index');
    }

    public function show(Incident $incident) {
        return view("incidents.show", ["incident"=>$incident]);
    }
}
