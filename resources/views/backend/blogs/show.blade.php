@extends('layouts.app')

@push('css')

@endpush

@push('js')
<!-- Page JS Code -->
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
                Show <small>Blog</small>
            </h3>
            <div class="block-options">
                @can('create', App\Models\Blog::class)
                <a href="{{ route('dashboard.blogs.create') }}" class="btn btn-sm btn-primary">Add Blog</a>
                @endcan
                @can('edit', App\Models\Blog::class)
                <a href="{{ route('dashboard.blogs.edit', $blog->id) }}" class="btn btn-sm btn-primary">Edit This Blog</a>
                @endcan
            </div>
        </div>
        <div class="block-content block-content-full">


            <div class="mt-4">
                <h4 class="mb-1">{{ $blog->title }}</h4>
                <img id="output" class="img-fluid rounded" src="{{ asset('storage/' . $blog->photo) }}" />
                <div class="block-content">
                  <p class="fs-sm">
                    <span class="text-primary">
                        <a href="{{ route('dashboard.users.show', $blog->user->id) }}">{{ $blog->user->fullName }}</a>
                    </span> on {{ Carbon\Carbon::parse($blog->updated_at)->format('M d, Y') }} · <span class="text-muted">{{ Carbon\Carbon::parse($blog->updated_at)->diffForHumans()}}</span>
                  </p>
                  <p>
                    {{ $blog->content }}
                  </p>
                </div>
            </div>
            <hr />
            <div class="mt-4">
                <div class="mb-4">
                    <h5>Video Link</h5>
                    <span>{{ $blog->video ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>Status</h5>
                    <span>{{ $blog->status ?? '-' }}</span>
                </div>
            </div>

        </div>

        <div class="block-header block-header-default">
            <h3 class="block-title">

            </h3>
            <div class="block-options">
                @can('destory', App\Models\Blog::class)
                <form action="{{ url(route('dashboard.blogs.destroy', $blog->id)) }}" method="post" onsubmit="return confirm('are you sure you want to delete this blog?')">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="_method" value="delete">
                    <button class="btn btn-sm btn-secondary">Delete Blog</button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
