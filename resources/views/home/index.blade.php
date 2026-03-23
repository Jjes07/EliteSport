@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
    <div class="container py-5">
        <!-- Hero Section -->
        <div class="hero-section text-center mb-5 fade-in">
            <h1 class="display-3 fw-bold mb-3">{{ __('products.title') }}</h1>
            <p class="lead text-muted">{{ __('home.hero_text') }}</p>
        </div>

        @if($viewData['products']->isEmpty())
            <div class="empty-state text-center py-5 fade-in">
                <div class="empty-state-icon mb-4">🛍️</div>
                <h3 class="mb-2">{{ __('products.no_products') }}</h3>
                <p class="text-muted mb-0">{{ __('products.coming_soon') }}</p>
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
                                <span class="badge product-card-status-badge {{ $product->getStock() > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->getStock() > 0 ? __('products.available') : __('products.out_of_stock') }}
                                </span>

                                <h3 class="product-card-title">{{ $product->getName() }}</h3>
                                <div class="product-card-price">${{ $product->getPrice() }}</div>
                                
                                @if($product->getStock() > 0)
                                    <div class="product-card-action mt-2">
                                        <span class="btn btn-sm btn-outline-primary w-100">{{ __('home.view_details') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection