@extends('layouts.app')
@section('title', $viewData['title'])
@section('content')
    <div class="content-box">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <p><strong>Id:</strong> {{ $viewData['user']->getId() }}</p>
        <p><strong>Name:</strong> {{ $viewData['user']->getName() }}</p>
        <p><strong>Email:</strong> {{ $viewData['user']->getEmail() }}</p>
        <p><strong>Address:</strong> {{ $viewData['user']->getAddress() }}</p>
        <p><strong>Phone:</strong> {{ $viewData['user']->getPhone() }}</p>
        <p><strong>Role:</strong> {{ $viewData['user']->getRole() }}</p>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </div>
    </div>
@endsection