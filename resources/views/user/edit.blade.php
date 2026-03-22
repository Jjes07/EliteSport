@extends('layouts.app')
@section('title', $viewData['title'])
@section('content')
    <div class="content-box form-section mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">{{ __('forms.edit_user') }}</h1>

            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                {{ __('forms.back') }}
            </a>
        </div>

        <form action="{{ route('user.update', $viewData['user']->getId()) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="name" class="form-label custom-label">{{ __('forms.name') }}</label>
                    <input type="text" name="name" id="name" class="form-control custom-input"
                        value="{{ old('name', $viewData['user']->getName()) }}">

                    @error('name')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label custom-label">{{ __('forms.email') }}</label>
                    <input type="email" name="email" id="email" class="form-control custom-input"
                        value="{{ old('email', $viewData['user']->getEmail()) }}">

                    @error('email')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label custom-label">{{ __('auth.password') }}</label>
                    <input type="password" name="password" id="password" class="form-control custom-input">

                    @error('password')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label custom-label">{{ __('forms.phone') }}</label>
                    <input type="text" name="phone" id="phone" class="form-control custom-input"
                        value="{{ old('phone', $viewData['user']->getPhone()) }}">

                    @error('phone')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="address" class="form-label custom-label">{{ __('forms.address') }}</label>
                    <input type="text" name="address" id="address" class="form-control custom-input"
                        value="{{ old('address', $viewData['user']->getAddress()) }}">

                    @error('address')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="role" class="form-label custom-label">{{ __('forms.role') }}</label>
                    <select name="role" id="role" class="form-select custom-input" disabled>
                        <option value="">{{ __('auth.roles_select') }}</option>
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
                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                    {{ __('forms.back') }}
                </a>

                <button type="submit" class="btn btn-custom-primary">
                    {{ __('forms.edit_user') }}
                </button>
            </div>
        </form>
    </div>
@endsection