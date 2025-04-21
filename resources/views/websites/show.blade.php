@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <a href="{{ route('websites.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Websites
                    </a>
                </div>
                <div>
                    <a href="{{ route('websites.edit', $website) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            </div>
            <h1>{{ $website->name }}</h1>
            @if($website->published)
                <span class="badge bg-success">Published</span>
            @else
                <span class="badge bg-secondary">Draft</span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Website Details</h5>
                </div>
                <div class="card-body">
                    @if($website->description)
                        <p class="mb-4">{{ $website->description }}</p>
                    @else
                        <p class="text-muted mb-4">No description provided.</p>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Created:</strong> {{ $website->created_at->format('M d, Y') }}</p>
                            <p><strong>Last Updated:</strong> {{ $website->updated_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Template:</strong> {{ $website->template ?? 'Custom' }}</p>
                            <p><strong>Status:</strong> {{ $website->published ? 'Published' : 'Draft' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Website Preview</h5>
                </div>
                <div class="card-body">
                    <div class="text-center p-5 bg-light border rounded mb-3">
                        <h3 class="text-muted">Preview Area</h3>
                        <p>Website preview will be displayed here</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Website Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('websites.builder', $website) }}" class="btn btn-primary">
                            <i class="bi bi-tools"></i> Open Builder
                        </a>
                        <a href="{{ route('websites.preview', $website) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-eye"></i> Preview Website
                        </a>
                        @if($website->published)
                            <a href="{{ route('websites.download', $website) }}" class="btn btn-outline-success">
                                <i class="bi bi-download"></i> Export Website
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Danger Zone</h5>
                </div>
                <div class="card-body">
                    <p>Once you delete a website, there is no going back.</p>
                    <form action="{{ route('websites.destroy', $website) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this website? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Delete Website
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 