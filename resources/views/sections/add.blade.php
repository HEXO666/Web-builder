@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Section to Website</h1>
    
    <div class="card">
        <div class="card-header">
            Add Section Form
        </div>
        <div class="card-body">
            <form action="{{ route('website.add.section') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="website_id" class="form-label">Website ID</label>
                    <input type="text" class="form-control" id="website_id" name="website_id" value="{{ request('website_id') }}">
                </div>
                
                <div class="mb-3">
                    <label for="section_id" class="form-label">Section ID</label>
                    <input type="text" class="form-control" id="section_id" name="section_id" value="{{ request('section_id') ?? 1 }}">
                </div>
                
                <div class="mb-3">
                    <label for="section_theme_id" class="form-label">Theme ID</label>
                    <input type="text" class="form-control" id="section_theme_id" name="section_theme_id" value="{{ request('section_theme_id') ?? 1 }}">
                </div>
                
                <button type="submit" class="btn btn-primary">Add Section</button>
            </form>
            
            <hr>
            
            <h4>Debugging Information:</h4>
            <ul>
                <li>Website ID: {{ request('website_id') }}</li>
                <li>Section ID: {{ request('section_id') }}</li>
                <li>Theme ID: {{ request('section_theme_id') }}</li>
                <li>Form Action: {{ route('website.add.section') }}</li>
                <li>Route Value: {{ route('website.sections.store', ['website' => request('website_id')]) }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection 