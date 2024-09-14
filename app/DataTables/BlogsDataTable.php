<?php

namespace App\DataTables;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BlogsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  QueryBuilder  $query  Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('user', function ($blog) {
                return $blog->user->fullName;
            })
            ->editColumn('status', function ($blog) {
                return $blog->status == 'ACTIVE' ? 'Active' : 'In-Active';
            })
            ->editColumn('created_at', function ($blog) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $blog->created_at)
                    ->format('M d, Y h:i a');

                return $formatedDate;
            })
            ->editColumn('updated_at', function ($blog) {
                $formatedDate = Carbon::createFromFormat('Y-m-d H:i:s', $blog->updated_at)
                    ->format('M d, Y h:i a');

                return $formatedDate;
            })
            ->addColumn('show', function ($blog) {

                if (auth()->user()->can('dashboard.blogs.show', App\Models\Blog::class)) {
                    return '<a class="btn btn-danger btn-sm" href="'.url(route('dashboard.blogs.show', $blog->id)).'"><i class="fa fa-magnifying-glass"></i></a>';
                }

                return '';
            })
            ->addColumn('edit', function ($blog) {

                if (auth()->user()->can('dashboard.blogs.edit', App\Models\Blog::class)) {
                    return '<a class="btn btn-danger btn-sm" href="'.url(route('dashboard.blogs.edit', $blog->id)).'"><i class="fa fa-pencil"></i></a>';
                }

                return '';
            })
            ->addColumn('delete', function ($blog) {

                if (auth()->user()->can('dashboard.blogs.destroy', App\Models\Blog::class)) {
                    return '<form action="'.url(route('dashboard.blogs.destroy', $blog->id)).'" method="post" onsubmit="return confirm(\'are you sure you want to delete this blog?\')">
                        <input type="hidden" name="_token" value="'.csrf_token().'" />
                        <input type="hidden" name="_method" value="delete">
                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>';
                }

                return '';
            })
            ->rawColumns(['show', 'edit', 'delete'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Blog  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query($user_id = null)
    {

        $query = Blog::select();

        if (! is_null($user_id)) {
            $query->where('user_id', $user_id);
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('blogs-table')
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
            Column::make('title'),
            Column::make('user')
                ->searchable(false)
                ->sortable(false),
            Column::make('status'),
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
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Blogs_'.date('YmdHis');
    }
}
