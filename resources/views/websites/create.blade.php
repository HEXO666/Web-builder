@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Create New Website</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('websites.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Websites
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">Website Details</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('websites.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Website Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Give your website a descriptive name.</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Briefly describe the purpose of this website.</small>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input @error('published') is-invalid @enderror" type="checkbox" id="published" name="published" {{ old('published') ? 'checked' : '' }}>
                            <label class="form-check-label" for="published">
                                Publish immediately
                            </label>
                            @error('published')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">If unchecked, the website will be saved as a draft.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Create Website
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 