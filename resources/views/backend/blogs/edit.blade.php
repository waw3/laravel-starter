@extends('layouts.app')

@push('css')

@endpush

@push('js')

@endpush

@section('content')

<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">Blogs</h1>
            <nav class="flex-shrink-0 my-2 my-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.index') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.blogs.index') }}">Blogs</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                Edit <small>Blog</small>
            </h3>
        </div>
        <div class="block-content block-content-full">
            <form action="{{ route('dashboard.blogs.update', $blog->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                @include('dashboard.blogs._form', [
                    'button' => 'Update'
                ])
            </form>
        </div>
    </div>
</div>
@endsection
