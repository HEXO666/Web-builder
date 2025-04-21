@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Browse Sections</h1>
            <p class="lead">Select sections to include in your website.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="btn-group" role="group">
                <a href="{{ route('sections.index') }}" class="btn btn-{{ $categoryId ? 'outline-' : '' }}primary">All</a>
                @foreach($categories as $category)
                    <a href="{{ route('sections.index', ['category' => $category->id]) }}" class="btn btn-{{ $categoryId == $category->id ? '' : 'outline-' }}primary">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($sections as $section)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($section->thumbnail)
                        <img src="{{ asset('storage/' . $section->thumbnail) }}" class="card-img-top" alt="{{ $section->name }}">
                    @else
                        <div class="bg-light text-center py-5">No Preview</div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $section->name }}</h5>
                        <p class="card-text">{{ $section->description }}</p>
                        <p class="card-text"><small class="text-muted">Category: {{ $section->category->name }}</small></p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ route('sections.show', $section) }}" class="btn btn-primary">View Themes</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No sections found. Please check back later.
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $sections->links() }}
    </div>
</div>
@endsection 