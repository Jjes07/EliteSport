@extends('layouts.admin')

@section('title', $viewData['title'])

@section('content')
    <div class="admin-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="admin-card">
                    <div class="admin-card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-pencil-square"></i> {{ __('forms.edit_product') }}
                        </div>
                        <a href="{{ route('product.index') }}" class="btn btn-outline-light btn-sm">
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

                        <form action="{{ route('product.update', $viewData['product']->getId()) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">{{ __('forms.name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $viewData['product']->getName()) }}"
                                        placeholder="{{ __('forms.name_placeholder_product') }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="category_id" class="form-label fw-semibold">{{ __('forms.category') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">-- {{ __('products.select_category') }} --</option>
                                        @foreach($viewData['categories'] as $category)
                                            <option value="{{ $category->getId() }}" {{ old('category_id', $viewData['product']->getCategoryId()) == $category->getId() ? 'selected' : '' }}>
                                                {{ $category->getName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="price" class="form-label fw-semibold">{{ __('forms.price') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="0" name="price" id="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price', $viewData['product']->getPrice()) }}"
                                        placeholder="{{ __('forms.price_placeholder') }}" required>
                                    @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="stock" class="form-label fw-semibold">{{ __('forms.stock') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="number" min="0" name="stock" id="stock"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        value="{{ old('stock', $viewData['product']->getStock()) }}"
                                        placeholder="{{ __('forms.stock_placeholder') }}" required>
                                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <label for="image" class="form-label fw-semibold">{{ __('forms.image_url') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="image" id="image"
                                        class="form-control @error('image') is-invalid @enderror"
                                        value="{{ old('image', $viewData['product']->getImage()) }}"
                                        placeholder="{{ __('forms.image_url_placeholder') }}" required>
                                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-12">
                                    <label for="description" class="form-label fw-semibold">{{ __('forms.description') }}
                                        <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description"
                                        class="form-control @error('description') is-invalid @enderror" rows="5"
                                        placeholder="{{ __('forms.description_placeholder_product') }}"
                                        required>{{ old('description', $viewData['product']->getDescription()) }}</textarea>
                                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4 flex-wrap">
                                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
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