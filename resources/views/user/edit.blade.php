@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ __('forms.edit_user') }}</h4>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-light btn-sm">
                            {{ __('forms.back') }}
                        </a>
                    </div>

                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <h6 class="fw-bold mb-2">{{ __('forms.errors_found') }}:</h6>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('user.update', $viewData['user']->getId()) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">{{ __('forms.name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $viewData['user']->getName()) }}"
                                        placeholder="{{ __('forms.name_placeholder_user') }}">

                                    @error('name')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">{{ __('forms.email') }}</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email', $viewData['user']->getEmail()) }}"
                                        placeholder="{{ __('forms.email_placeholder') }}">

                                    @error('email')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">{{ __('forms.password') }}</label>
                                    <input type="password" name="password" id="password" class="form-control">

                                    @error('password')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold">{{ __('forms.phone') }}</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        value="{{ old('phone', $viewData['user']->getPhone()) }}"
                                        placeholder="{{ __('forms.phone_placeholder') }}">

                                    @error('phone')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label fw-semibold">{{ __('forms.address') }}</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        value="{{ old('address', $viewData['user']->getAddress()) }}"
                                        placeholder="{{ __('forms.address_placeholder') }}">

                                    @error('address')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="role" class="form-label fw-semibold">{{ __('forms.role') }}</label>
                                    <select name="role" id="role" class="form-select">
                                        <option value="customer" {{ old('role', $viewData['user']->getRole()) == 'customer' ? 'selected' : '' }}>
                                            {{ __('auth.role_customer') }}
                                        </option>
                                        <option value="admin" {{ old('role', $viewData['user']->getRole()) == 'admin' ? 'selected' : '' }}>
                                            {{ __('auth.role_admin') }}
                                        </option>
                                    </select>

                                    @error('role')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                                    {{ __('forms.back') }}
                                </a>

                                <button type="submit" class="btn btn-primary px-4">
                                    {{ __('forms.edit_user') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection