@extends('layouts.admin')

@section('title', $viewData['title'])

@section('content')
    <div class="admin-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <i class="bi bi-plus-circle"></i> {{ __('forms.create_category') }}
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

                        <form method="POST" action="{{ route('category.save') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">{{ __('forms.name') }} <span
                                        class="text-danger">*</span></label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}"
                                    placeholder="{{ __('forms.name_placeholder_category') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">{{ __('forms.description') }} <span
                                        class="text-danger">*</span></label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                                    name="description" rows="5"
                                    placeholder="{{ __('forms.description_placeholder_category') }}"
                                    required>{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2 flex-wrap">
                                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> {{ __('forms.back') }}
                                </a>

                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle"></i> {{ __('forms.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection