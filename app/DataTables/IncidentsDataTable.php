<?php

namespace App\DataTables;

use App\Incident;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Auth;
class IncidentsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->filter(function ($query) {
                    if (request()->has('name') && strlen(request('name')) > 2 ) {
                        $query->where(function($q) {
                            $q->where('opened_by_internet_id', "=", request('name'));
                            $q->orWhere('opened_by_name', 'like', "%" . request('name') . "%");
                        });
                        
                    }
                    if (request()->has('incident') && strlen(request('incident')) > 2 ) {
                        $incident = strtoupper(request("incident"));
                        if(strpos($incident, "INC") === false) {
                            $incident = "INC" . request("incident");
                        }
                       
                        $query->where('incident', "=",   $incident);
                    }
                    // TODO VERIFY USER HAS PERMS
                    if (request()->has('assignmentGroup') && request('assignmentGroup') != "All") {
                        if(!Auth::user()->assignmentGroups->pluck("id")->contains(request('assignmentGroup'))) {
                            abort(403);
                        }
                        $query->where('assignment_group_id', '=', request('assignmentGroup'));
                    }

                    if (request()->has('assignmentGroup') && request('assignmentGroup') == "All") {
                        $query->whereIn("assignment_group_id", Auth::user()->assignmentGroups->pluck("id"));
                    }
                    if (request()->has('searchField') && strlen(request('searchField'))>2) {
                        if(request()->has('fullText') && request('fullText') == "true") {
                            $query->search(request('searchField'));
                        }
                        else {
                            $searchTerm = request("searchField");
                            $query->whereRaw("CONCAT(short_description,work_notes_and_comments,close_notes) like ?", ["%{$searchTerm}%"]);
                        }
                      
                        
                    }
                })
            ->addColumn('incident', 'incidents.action')
            ->editColumn('opened_by_name', function ($incident) {
                  return $incident->opened_by_name .' ('.$incident->opened_by_internet_id . ')';
            })
            ->rawColumns(['incident']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Incident $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Incident $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->parameters([
                        'pageLength' => 20,
                    ])
                    ->setTableId('incidents-table')
                    ->columns($this->getColumns())
                    ->ajax([
                        'url' => route('incidents.index'),
                        'type' => 'GET',
                        'data' => "function (d) {
                            d.name = $('input[name=user]').val();
                            d.assignmentGroup = $('select[name=assignmentGroup]').val();
                            d.searchField = $('input[name=searchField]').val();
                            d.incident = $('input[name=incident]').val();
                            d.fullText = $('input[name=fullText]').is(':checked');
            }",
                    ])
                    ->dom('rtip')
                    ->orderBy(1);

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $openedBy = Column::make('opened_by_name');
        $openedBy->title("Opened By");
        return [
            Column::make('incident'),
            Column::make('opened_at'),
            Column::make('short_description'),
            $openedBy
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Incidents_' . date('YmdHis');
    }
}
