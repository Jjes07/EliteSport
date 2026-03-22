@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ __('forms.edit_product') }}</h4>

                <a href="{{ route('product.index') }}" class="btn btn-outline-light">
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

                <form action="{{ route('product.update', $viewData['product']->getId()) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">{{ __('forms.name') }}</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $viewData['product']->getName()) }}"
                                placeholder="Ej: Balón Nike Premier">

                            @error('name')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label fw-semibold">{{ __('forms.price') }}</label>
                            <input type="number" step="0.01" min="0" name="price" id="price" class="form-control"
                                value="{{ old('price', $viewData['product']->getPrice()) }}" placeholder="Ej: 120000">

                            @error('price')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="stock" class="form-label fw-semibold">{{ __('forms.stock') }}</label>
                            <input type="number" min="0" name="stock" id="stock" class="form-control"
                                value="{{ old('stock', $viewData['product']->getStock()) }}" placeholder="Ej: 10">

                            @error('stock')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="category" class="form-label fw-semibold">{{ __('forms.category') }}</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">{{ __('products.select_category') }}</option>
                                <option value="Futbol" {{ old('category', $viewData['product']->getCategory()) == 'Futbol' ? 'selected' : '' }}>
                                    Futbol
                                </option>
                                <option value="Voleibol" {{ old('category', $viewData['product']->getCategory()) == 'Voleibol' ? 'selected' : '' }}>
                                    Voleibol
                                </option>
                            </select>

                            @error('category')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="image" class="form-label fw-semibold">{{ __('forms.image_url') }}</label>
                            <input type="text" name="image" id="image" class="form-control"
                                value="{{ old('image', $viewData['product']->getImage()) }}" placeholder="https://...">

                            @error('image')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">{{ __('forms.description') }}</label>
                            <textarea name="description" id="description" class="form-control" rows="5"
                                placeholder="Describe el producto...">{{ old('description', $viewData['product']->getDescription()) }}</textarea>

                            @error('description')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 flex-wrap">
                        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                            {{ __('forms.back') }}
                        </a>

                        <button type="submit" class="btn btn-primary px-4">
                            {{ __('forms.edit_product') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection