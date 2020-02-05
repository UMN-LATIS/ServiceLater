<?php

namespace App\DataTables;

use App\Incident;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

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
                        $query->where('opened_by', 'like', "%" . request('name') . "%");
                    }
                    // TODO VERIFY USER HAS PERMS
                    if (request()->has('assignmentGroup') && request('assignmentGroup') != "All") {
                        $query->where('assignment_group_id', '=', request('assignmentGroup'));
                    }
                })
            ->addColumn('incident', 'incidents.action')
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
                    ->setTableId('incidents-table')
                    ->columns($this->getColumns())
                    ->ajax([
                        'url' => route('incidents.index'),
                        'type' => 'GET',
                        'data' => "function (d) {
                            d.name = $('input[name=user]').val();
                            d.assignmentGroup = $('select[name=assignmentGroup]').val();
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
        return [
            Column::make('incident'),
            Column::make('short_description')
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
