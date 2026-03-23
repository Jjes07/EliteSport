@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="auth-card fade-in">
                    <div class="auth-header text-center">
                        <div class="auth-icon mb-3">📝</div>
                        <h2 class="fw-bold mb-2">{{ __('auth.register') }}</h2>
                        <p class="text-muted">{{ __('auth.already_registered') }} <a href="{{ route('login') }}">{{ __('auth.login') }}</a></p>
                    </div>

                    <div class="auth-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">{{ __('forms.name') }}</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="{{ __('forms.name') }}">
                                    @error('name')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">{{ __('auth.email') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="correo@ejemplo.com">
                                    @error('email')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="address" class="form-label fw-semibold">{{ __('forms.address') }}</label>
                                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                                        name="address" value="{{ old('address') }}" required autocomplete="address"
                                        placeholder="{{ __('forms.address') }}">
                                    @error('address')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold">{{ __('auth.phone') }}</label>
                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone') }}" required autocomplete="phone"
                                        placeholder="3001234567">
                                    @error('phone')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">{{ __('auth.password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" placeholder="{{ __('auth.password_placeholder') }}">
                                    @error('password')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password-confirm" class="form-label fw-semibold">{{ __('auth.password_confirm') }}</label>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('auth.password_confirm') }}">
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('auth.register') }} →
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection