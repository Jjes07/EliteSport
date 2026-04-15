@extends('layouts.admin')

@section('title', $viewData['title'])

@section('content')
    <div class="admin-content">
        <div class="admin-card">
            <div class="admin-card-header d-flex justify-content-between align-items-center">
                <h5>{{ __('products.products_list') }}</h5>

                <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> {{ __('products.create_product') }}
                </a>
            </div>

            <div class="admin-card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="mb-4">
                    <form action="{{ route('product.search') }}" method="GET" class="d-flex gap-2 flex-wrap">
                        <input type="text" name="name" class="form-control"
                            placeholder="{{ __('products.search_by_name') }}" value="{{ $viewData['searchTerm'] ?? '' }}"
                            style="min-width: 200px;">

                        <select name="category" class="form-select" style="min-width: 150px;">
                            <option value=""> {{ __('products.select_category') }} </option>
                            @foreach($viewData['categories'] as $category)
                                <option value="{{ $category->getId() }}" {{ (($viewData['selectedCategory'] ?? '') == $category->getId()) ? 'selected' : '' }}>
                                    {{ $category->getName() }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="bi bi-search"></i> {{ __('products.search') }}
                        </button>
                        @if($viewData['showCleanButton'] ?? false)
                            <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-counterclockwise"></i> {{ __('products.clear_filters') }}
                            </a>
                        @endif
                    </form>
                </div>

                @if(isset($viewData['message']))
                    <div class="alert alert-info mb-3">
                        {{ $viewData['message'] }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">{{ __('products.name') }}</th>
                                <th scope="col">{{ __('products.image') }}</th>
                                <th scope="col">{{ __('products.category') }}</th>
                                <th scope="col">{{ __('products.price') }}</th>
                                <th scope="col" style="width: 280px;">{{ __('products.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($viewData['products'] as $product)
                                <tr>
                                    <td class="fw-semibold">{{ $product->getId() }}</td>
                                    <td>{{ $product->getName() }}</td>
                                    <td>
                                        <img src="{{ $product->getImage() }}" alt="{{ $product->getName() }}"
                                            class="img-fluid rounded"
                                            style="max-width: 60px; max-height: 60px; object-fit: contain;">
                                    </td>
                                    <td>{{ $product->getCategory()?->getName() }}</td>
                                    <td class="fw-semibold">${{ number_format($product->getPrice(), 2) }}</td>
                                    <td>
                                        <div class="d-flex justify-content-start flex-wrap gap-2">
                                            <a href="{{ route('product.edit', ['id' => $product->getId()]) }}"
                                                class="btn btn-warning btn-sm" title="Editar">
                                                <i class="bi bi-pencil"></i> {{ __('products.edit') }}
                                            </a>

                                            <form action="{{ route('product.delete', ['id' => $product->getId()]) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('{{ __('products.confirm_delete') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                    <i class="bi bi-trash"></i> {{ __('products.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        {{ __('products.no_products_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection