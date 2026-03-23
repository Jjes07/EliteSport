@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ __('products.products_list') }}</h4>

                <a href="{{ route('product.create') }}" class="btn btn-primary">
                    {{ __('products.create_product') }}
                </a>
            </div>

            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4">
                    <form action="{{ route('product.search') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="name" class="form-control"
                            placeholder="{{ __('products.search_by_name') }}" value="{{ $viewData['searchTerm'] ?? '' }}">

                        <select name="category" class="form-select">
                            <option value=""> {{ __('products.select_category') }} </option>
                            @foreach($viewData['categories'] as $category)
                                <option value="{{ $category->getId() }}" {{ (($viewData['selectedCategory'] ?? '') == $category->getId()) ? 'selected' : '' }}>
                                    {{ $category->getName() }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-info">
                            {{ __('products.search') }}
                        </button>
                        @if($viewData['showCleanButton'] ?? false)
                            <a href="{{ route('product.index') }}" class="btn btn-secondary">
                                {{ __('products.clear_filters') }}
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
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">{{ __('products.id') }}</th>
                                <th scope="col">{{ __('products.name') }}</th>
                                <th scope="col">{{ __('products.image') }}</th>
                                <th scope="col">{{ __('products.actions') }}</th>
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
                                            style="max-width: 95px; max-height: 70px; object-fit: contain;">
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center flex-wrap gap-2">
                                            <a href="{{ route('product.show', ['id' => $product->getId()]) }}"
                                                class="btn btn-primary btn-sm">
                                                {{ __('products.details') }}
                                            </a>

                                            <a href="{{ route('product.edit', ['id' => $product->getId()]) }}"
                                                class="btn btn-secondary btn-sm">
                                                {{ __('products.edit') }}
                                            </a>

                                            <form action="{{ route('product.delete', ['id' => $product->getId()]) }}"
                                                method="POST" onsubmit="return confirm('{{ __('products.confirm_delete') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    {{ __('products.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted py-4">
                                        @if(isset($viewData['searchTerm']) && $viewData['searchTerm'])
                                            {{ __('products.no_products_found') }}
                                        @elseif(isset($viewData['selectedCategory']) && $viewData['selectedCategory'])
                                            {{ __('products.no_products_category') }}
                                        @else
                                            {{ __('products.no_products_registered') }}
                                        @endif
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