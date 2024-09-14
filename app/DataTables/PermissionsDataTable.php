<?php

namespace App\DataTables;

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PermissionsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  QueryBuilder  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function ($permission) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $permission->created_at)
                    ->format('M d, Y h:i a');

                return $formatedDate;
            })
            ->editColumn('updated_at', function ($permission) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $permission->updated_at)
                    ->format('M d, Y h:i a');

                return $formatedDate;
            })
            ->addColumn('edit', function ($permission) {

                if (auth()->user()->can('backend.permissions.edit', App\Models\User::class)) {
                    return '<a class="btn btn-danger btn-sm" href="'.url(route('backend.permissions.edit', $permission->id)).'"><i class="fa fa-pencil"></i></a>';
                }

                return '';
            })
            ->addColumn('delete', function ($permission) {

                if (auth()->user()->can('backend.permissions.destroy', App\Models\User::class)) {
                    return '<form action="'.url(route('backend.permissions.destroy', $permission->id)).'" method="post" onsubmit="return confirm(\'are you sure you want to delete this permission?\')">
                    <input type="hidden" name="_token" value="'.csrf_token().'" />
                    <input type="hidden" name="_method" value="delete">
                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                    </form>';
                }

                return '';
            })
            ->rawColumns(['edit', 'delete'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Permission $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('permissions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'dom' => "<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                'buttons' => ['excel', 'csv', 'pdf', 'print'],
                'autoWidth' => false,
                'responsive' => true,
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('edit')
                ->title('')
                ->exportable(false)
                ->printable(false)
                ->width(50),
            Column::computed('delete')
                ->title('')
                ->exportable(false)
                ->printable(false)
                ->width(50),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Permissions_'.date('YmdHis');
    }
}
