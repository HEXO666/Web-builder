@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>My Websites</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('websites.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Create New Website
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($websites->count() > 0)
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($websites as $website)
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="badge {{ $website->published ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $website->published ? 'Published' : 'Draft' }}
                                </span>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $website->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $website->id }}">
                                        <li><a class="dropdown-item" href="{{ route('websites.edit', $website) }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="{{ route('websites.show', $website) }}"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                        <li><a class="dropdown-item" href="{{ route('websites.builder', $website) }}"><i class="bi bi-tools me-2"></i>Open Builder</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('websites.destroy', $website) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this website?')">
                                                    <i class="bi bi-trash me-2"></i>Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $website->name }}</h5>
                                <p class="card-text text-muted mb-2">
                                    @if($website->description)
                                        {{ Str::limit($website->description, 100) }}
                                    @else
                                        <span class="text-muted">No description provided</span>
                                    @endif
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        Last updated {{ $website->updated_at->diffForHumans() }}
                                    </small>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('websites.builder', $website) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-tools"></i> Edit Website
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $websites->links() }}
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <h3 class="text-muted mb-3">No websites found</h3>
                        <p>You haven't created any websites yet. Get started by creating your first website!</p>
                        <a href="{{ route('websites.create') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-plus-lg"></i> Create New Website
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 