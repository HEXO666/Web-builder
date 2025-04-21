@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            @isset($website)
                <a href="{{ route('websites.builder', $website) }}" class="btn btn-primary mb-3 me-2">
                    <i class="bi bi-arrow-left"></i> Back to Website Builder
                </a>
            @endisset
            
            <a href="{{ route('sections.index') }}" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Back to Sections
            </a>
            <h1>{{ $section->name }}</h1>
            <p class="lead">{{ $section->description }}</p>
            <p><strong>Category:</strong> {{ $section->category->name }}</p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">HTML Preview</h5>
                </div>
                <div class="card-body">
                    <div class="border p-3 rounded">
                        {!! $section->html_template !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Available Themes</h2>
            <p>Select a theme to customize the style of this section.</p>
        </div>
    </div>

    <div class="row">
        @forelse($section->themes as $theme)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($theme->thumbnail)
                        <img src="{{ asset('storage/' . $theme->thumbnail) }}" class="card-img-top" alt="{{ $theme->name }}">
                    @else
                        <div class="bg-light text-center py-5">No Preview</div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $theme->name }}</h5>
                        <p class="card-text">{{ $theme->description }}</p>
                    </div>
                    <div class="card-footer bg-white">
                        @isset($website)
                            <a href="{{ route('themes.show', ['theme' => $theme, 'website_id' => $website->id]) }}" class="btn btn-primary">Customize Theme</a>
                            <form action="{{ route('website.add.section') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="website_id" value="{{ $website->id }}">
                                <input type="hidden" name="section_id" value="{{ $section->id }}">
                                <input type="hidden" name="section_theme_id" value="{{ $theme->id }}">
                                <button type="submit" class="btn btn-success">Add to Website</button>
                            </form>
                        @else
                            <a href="{{ route('themes.show', $theme) }}" class="btn btn-primary">View Theme</a>
                        @endisset
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No themes available for this section yet. Please check back later.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection 