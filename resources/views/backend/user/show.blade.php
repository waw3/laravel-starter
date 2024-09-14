@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
@endpush

@push('js')
<!-- Page JS Code -->

<!-- Page JS Plugins -->
<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

@section('content')

<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Users</h1>
            <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.users.index') }}">Users</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">

    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Show <small>User</small>
            </h3>
            <div class="block-options">
                @can('create', App\Models\User::class)
                <a href="{{ route('dashboard.users.create') }}" class="btn btn-sm btn-primary">Add User</a>
                @endcan
                @can('edit', App\Models\User::class)
                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit This User</a>
                @endcan
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="mt-4">
                <div class="mb-4">
                    <h5>First Name</h5>
                    <span>{{ $user->first_name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>Last Name</h5>
                    <span>{{ $user->last_name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>Email</h5>
                    <span>{{ $user->email ?? '-' }}</span>
                </div>
            </div>
        </div>



        <div class="block-header block-header-default">
            <h3 class="block-title">

            </h3>
            <div class="block-options">
                @can('destroy', App\Models\User::class)
                @if($user->id != auth()->user()->id || !$user->isAdmin())
                <form action="{{ url(route('dashboard.users.destroy', $user->id)) }}" method="post" onsubmit="return confirm('are you sure you want to delete this user?')">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="_method" value="delete">
                    <button class="btn btn-sm btn-secondary">Delete User</button>
                </form>
                @endif
                @endcan
            </div>
        </div>

    </div>

    @can('view-any', App\Models\Blog::class)
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                User <small>Blogs</small>
            </h3>
        </div>
        <div class="block-content block-content-full">
            {{ $dataTable->table(['class' => 'table table-bordered table-striped table-vcenter js-dataTable-responsive']) }}
        </div>
    </div>
    @endcan


</div>
@endsection
