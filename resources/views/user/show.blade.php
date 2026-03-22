@extends('layouts.app')
@section('title', $viewData['title'])
@section('content')
    <div class="content-box">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <p><strong>{{ __('products.id') }}:</strong> {{ $viewData['user']->getId() }}</p>
        <p><strong>{{ __('forms.name') }}:</strong> {{ $viewData['user']->getName() }}</p>
        <p><strong>{{ __('forms.email') }}:</strong> {{ $viewData['user']->getEmail() }}</p>
        <p><strong>{{ __('forms.address') }}:</strong> {{ $viewData['user']->getAddress() }}</p>
        <p><strong>{{ __('forms.phone') }}:</strong> {{ $viewData['user']->getPhone() }}</p>
        <p><strong>{{ __('forms.role') }}:</strong> {{ $viewData['user']->getRole() }}</p>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                {{ __('forms.back') }}
            </a>
        </div>
    </div>
@endsection