@extends('layouts.app')

@section('title', 'EliteSport - Home')
@section('subtitle', 'EliteSport · Sports Equipment')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">

    <div class="home-card text-center p-5">

        <h2 class="mb-4 fw-bold">Welcome to EliteSport</h2>

        <div class="d-grid gap-3 col-8 mx-auto">

            <a href="{{ route('review.index') }}" class="btn btn-outline-primary btn-lg">
                View Reviews
            </a>

            <a href="{{ route('review.create') }}" class="btn btn-primary btn-lg">
               Create Review
            </a>

        </div>

    </div>

</div>
@endsection