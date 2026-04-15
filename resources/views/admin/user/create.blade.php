@extends('layouts.admin')

@section('title', $viewData['title'])

@section('content')
    <div class="admin-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <i class="bi bi-person-plus"></i> {{ __('forms.create_user') }}
                    </div>

                    <div class="admin-card-body">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle"></i>
                                    {{ __('forms.errors_found') }}:</h6>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('user.save') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">{{ __('forms.name') }} <span
                                        class="text-danger">*</span></label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}"
                                    placeholder="{{ __('forms.name_placeholder_user') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">{{ __('auth.email') }} <span
                                        class="text-danger">*</span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}"
                                    placeholder="{{ __('forms.email_placeholder') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">{{ __('auth.password') }} <span
                                        class="text-danger">*</span></label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="{{ __('forms.password_placeholder_form') }}" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label fw-semibold">{{ __('forms.address') }}</label>
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                    name="address" value="{{ old('address') }}"
                                    placeholder="{{ __('forms.address_placeholder') }}">
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label fw-semibold">{{ __('auth.phone') }}</label>
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}"
                                    placeholder="{{ __('forms.phone_placeholder') }}">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-4">
                                <label for="role" class="form-label fw-semibold">{{ __('forms.role') }} <span
                                        class="text-danger">*</span></label>
                                <select name="role" id="role" class="form-select @error('role') is-invalid @enderror"
                                    required>
                                    <option value="">-- {{ __('forms.select_role') }} --</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                        {{ __('auth.role_admin') }}
                                    </option>
                                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>
                                        {{ __('auth.role_customer') }}
                                    </option>
                                </select>
                                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2 flex-wrap">
                                <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> {{ __('forms.back') }}
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> {{ __('forms.save_user') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection