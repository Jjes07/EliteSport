@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
    <div class="container">
        <div class="content-box home-hero mb-4">
            <div class="text-center">
                <h1 class="home-title">{{ __('products.title') }}</h1>
            </div>
        </div>
        <div class="mb-4">
            <form action="{{ route('home.index') }}" method="GET" class="d-flex gap-2">
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
                    <a href="{{ route('home.index') }}" class="btn btn-secondary">
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

        @if($viewData['products']->isEmpty())
            <div class="content-box text-center">
                <h3 class="mb-2">{{ __('products.no_products') }}</h3>
                <p class="mb-0">{{ __('products.coming_soon') }}</p>
            </div>
        @else
            <div class="products-grid">
                @foreach($viewData['products'] as $product)
                    <a href="{{ route('product.show', ['id' => $product->getId()]) }}" class="product-card-link">
                        <div class="product-card">
                            <div class="product-card-image-container">
                                <img src="{{ $product->getImage() }}" alt="{{ $product->getName() }}" class="product-card-image">
                            </div>

                            <div class="product-card-body">
                                <span
                                    class="badge product-card-status-badge {{ $product->getStock() > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->getStock() > 0 ? __('products.available') : __('products.out_of_stock') }}
                                </span>

                                <h2 class="product-card-title">{{ $product->getName() }}</h2>
                                <p class="product-card-price">${{ number_format($product->getPrice(), 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection