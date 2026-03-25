@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">{{ __('forms.create_product') }}</h4>
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

                        <form method="POST" action="{{ route('product.save') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">{{ __('forms.name') }}</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    placeholder="Ej: Balón Nike Premier">
                            </div>

                            <div class="mb-3">
                                <label for="description"
                                    class="form-label fw-semibold">{{ __('forms.description') }}</label>
                                <textarea id="description" class="form-control" name="description" rows="4"
                                    placeholder="Describe el producto...">{{ old('description') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label fw-semibold">{{ __('forms.price') }}</label>
                                    <input id="price" type="number" class="form-control" name="price"
                                        value="{{ old('price') }}" min="0" placeholder="Ej: 120000">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="stock" class="form-label fw-semibold">{{ __('forms.stock') }}</label>
                                    <input id="stock" type="number" class="form-control" name="stock"
                                        value="{{ old('stock') }}" min="0" placeholder="Ej: 10">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label fw-semibold">{{ __('forms.image_url') }}</label>
                                <input id="image" type="text" class="form-control" name="image" value="{{ old('image') }}"
                                    placeholder="https://...">
                            </div>

                            <div class="mb-4">
                                <label for="category_id" class="form-label fw-semibold">{{ __('forms.category') }}</label>
                                <select id="category_id" name="category_id" class="form-select">
                                    <option value="">{{ __('products.select_category') }}</option>
                                    @foreach($viewData['categories'] as $category)
                                        <option value="{{ $category->getId() }}" {{ old('category_id') == $category->getId() ? 'selected' : '' }}>
                                            {{ $category->getName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                                    {{ __('forms.back') }}
                                </a>

                                <button type="submit" class="btn btn-primary px-4">
                                    {{ __('forms.save_product') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection