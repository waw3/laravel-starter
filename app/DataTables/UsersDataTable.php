<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{

    public $model = \App\Models\User::class;

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('action', 'users.action')

            ->editColumn('blogs', function ($user) {
                return $user->blogs->count();
            })

            ->editColumn('created_at', function ($user) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('M d, Y h:i a');

                return $formatedDate;
            })

            ->editColumn('updated_at', function ($user) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->updated_at)->format('M d, Y h:i a');

                return $formatedDate;
            })

            ->addColumn('show', function ($user) {

                if (auth()->user()->can('backend.users.show', App\Models\User::class)) {
                    return '<a class="btn btn-danger btn-sm" href="'.url(route('backend.users.show', $user->id)).'"><i class="fa fa-magnifying-glass"></i></a>';
                }

                return '';
            })

            ->addColumn('edit', function ($user) {

                if (auth()->user()->can('backend.users.edit', App\Models\User::class)) {
                    return '<a class="btn btn-danger btn-sm" href="'.url(route('backend.users.edit', $user->id)).'"><i class="fa fa-pencil"></i></a>';
                }

                return '';
            })

            ->addColumn('delete', function ($user) {

                if (auth()->user()->can('backend.users.destroy', App\Models\User::class)) {

                    if (auth()->user()->id != $user->id || ! auth()->user()->hasRole('backend')) {
                        return '<form action="'.url(route('backend.users.destroy', $user->id)).'" method="post" onsubmit="return confirm(\'are you sure you want to delete this user?\')">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />
                            <input type="hidden" name="_method" value="delete">
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>';
                    }
                }

                return '';
            })

            ->rawColumns(['show', 'edit', 'delete'])

            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    // ->parameters([
                    //     'dom' => "<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    //     'buttons' => ['excel', 'csv', 'pdf', 'print'],
                    //     'autoWidth' => false,
                    //     'responsive' => true,
                    // ])
                    ->buttons([
                        Button::make('add'),
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),

            Column::make('id'),

            Column::make('first_name'),

            Column::make('last_name'),

            Column::make('email'),

            Column::make('blogs')
                ->searchable(false)
                ->sortable(false),

            Column::make('created_at'),

            Column::make('updated_at'),

            Column::computed('show')
                ->title('')
                ->exportable(false)
                ->printable(false)
                ->width(50),

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
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
