@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4">Build Your Website Without Coding</h1>
            <p class="lead mb-5">
                Select from a variety of pre-designed sections, customize colors, and export your website as static HTML, CSS, and JavaScript.
            </p>
            <div class="d-flex justify-content-center gap-3">
                @auth
                    <a href="{{ route('websites.create') }}" class="btn btn-primary btn-lg">Create New Website</a>
                    <a href="{{ route('websites.index') }}" class="btn btn-outline-secondary btn-lg">My Websites</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">Register</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="row mt-5 pt-5">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h3 class="card-title">Choose Sections</h3>
                    <p class="card-text">
                        Browse and select from a variety of pre-designed sections like headers, heroes, features, testimonials, and more.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h3 class="card-title">Customize Colors</h3>
                    <p class="card-text">
                        Customize the colors of each section to match your brand identity, without writing any CSS code.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h3 class="card-title">Export Website</h3>
                    <p class="card-text">
                        Export your website as static HTML, CSS, and JavaScript files that you can host anywhere.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
