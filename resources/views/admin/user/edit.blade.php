@extends('layouts.admin')

@section('title', $viewData['title'])

@section('content')
    <div class="admin-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="admin-card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-pencil-square"></i> {{ __('forms.edit_user') }}
                        </div>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-arrow-left"></i> {{ __('forms.back') }}
                        </a>
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

                        <form action="{{ route('user.update', $viewData['user']->getId()) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">{{ __('forms.name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $viewData['user']->getName()) }}"
                                        placeholder="{{ __('forms.name_placeholder_user') }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">{{ __('forms.email') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $viewData['user']->getEmail()) }}"
                                        placeholder="{{ __('forms.email_placeholder') }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">{{ __('forms.password') }}</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Dejar en blanco para mantener la contraseña actual">
                                    <small class="text-muted d-block mt-1">Dejar vacío para no cambiar</small>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold">{{ __('forms.phone') }}</label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $viewData['user']->getPhone()) }}"
                                        placeholder="{{ __('forms.phone_placeholder') }}">
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label fw-semibold">{{ __('forms.address') }}</label>
                                    <input type="text" name="address" id="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address', $viewData['user']->getAddress()) }}"
                                        placeholder="{{ __('forms.address_placeholder') }}">
                                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="role" class="form-label fw-semibold">{{ __('forms.role') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="role" id="role" class="form-select @error('role') is-invalid @enderror"
                                        required>
                                        <option value="">-- {{ __('forms.select_role') }} --</option>
                                        <option value="customer" {{ old('role', $viewData['user']->getRole()) == 'customer' ? 'selected' : '' }}>
                                            {{ __('auth.role_customer') }}
                                        </option>
                                        <option value="admin" {{ old('role', $viewData['user']->getRole()) == 'admin' ? 'selected' : '' }}>
                                            {{ __('auth.role_admin') }}
                                        </option>
                                    </select>
                                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4 flex-wrap">
                                <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> {{ __('forms.back') }}
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> {{ __('forms.save_changes') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection