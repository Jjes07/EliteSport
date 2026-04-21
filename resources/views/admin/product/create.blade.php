@extends('layouts.admin')

@section('title', $viewData['title'])

@section('content')
    <div class="admin-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <i class="bi bi-plus-circle"></i> {{ __('forms.create_product') }}
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

                        <form method="POST" action="{{ route('product.save') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">{{ __('forms.name') }} <span
                                        class="text-danger">*</span></label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}"
                                    placeholder="{{ __('forms.name_placeholder_product') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">{{ __('forms.description') }} <span
                                        class="text-danger">*</span></label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror"
                                    name="description" rows="4"
                                    placeholder="{{ __('forms.description_placeholder_product') }}"
                                    required>{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label fw-semibold">{{ __('forms.price') }} <span
                                            class="text-danger">*</span></label>
                                    <input id="price" type="number" step="0.01"
                                        class="form-control @error('price') is-invalid @enderror" name="price"
                                        value="{{ old('price') }}" min="0" placeholder="{{ __('forms.price_placeholder') }}"
                                        required>
                                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="stock" class="form-label fw-semibold">{{ __('forms.stock') }} <span
                                            class="text-danger">*</span></label>
                                    <input id="stock" type="number"
                                        class="form-control @error('stock') is-invalid @enderror" name="stock"
                                        value="{{ old('stock') }}" min="0" placeholder="{{ __('forms.stock_placeholder') }}"
                                        required>
                                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label fw-semibold">{{ __('forms.image_url') }} <span
                                        class="text-danger">*</span></label>
                                <input id="image" type="text" class="form-control @error('image') is-invalid @enderror"
                                    name="image" value="{{ old('image') }}"
                                    placeholder="{{ __('forms.image_url_placeholder') }}" required>
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-4">
                                <label for="category_id" class="form-label fw-semibold">{{ __('forms.category') }} <span
                                        class="text-danger">*</span></label>
                                <select id="category_id" name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- {{ __('products.select_category') }} --</option>
                                    @foreach($viewData['categories'] as $category)
                                        <option value="{{ $category->getId() }}" {{ old('category_id') == $category->getId() ? 'selected' : '' }}>
                                            {{ $category->getName() }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2 flex-wrap">
                                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> {{ __('forms.back') }}
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> {{ __('forms.save_product') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection