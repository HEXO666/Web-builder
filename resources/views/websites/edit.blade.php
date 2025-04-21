@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Edit Website</h1>
                <a href="{{ route('websites.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Websites
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('websites.update', $website) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Website Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $website->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Choose a descriptive name for your website.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $website->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Briefly describe the purpose of this website.</div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="hidden" name="published" value="0">
                            <input type="checkbox" class="form-check-input @error('published') is-invalid @enderror" 
                                   id="published" name="published" value="1" {{ old('published', $website->published) ? 'checked' : '' }}>
                            <label class="form-check-label" for="published">Published</label>
                            @error('published')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">When published, your website will be visible to others.</div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update Website</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 