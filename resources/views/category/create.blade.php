@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">{{ __('forms.create_category') }}</h4>
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

                        <form method="POST" action="{{ route('category.save') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">{{ __('forms.name') }}</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    placeholder="{{ __('forms.name_placeholder_category') }}">

                                @error('name')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description"
                                    class="form-label fw-semibold">{{ __('forms.description') }}</label>
                                <textarea id="description" class="form-control" name="description" rows="5"
                                    placeholder="{{ __('forms.description_placeholder_category') }}">{{ old('description') }}</textarea>

                                @error('description')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                                    {{ __('forms.back') }}
                                </a>

                                <button type="submit" class="btn btn-primary px-4">
                                    {{ __('forms.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection