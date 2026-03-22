@extends('layouts.app')
@section('title', $viewData['title'])

@section('content')
    <div class="container">
        <div class="content-box home-hero mb-4">
            <div class="text-center">
                <h1 class="home-title">Nuestros Productos</h1>
            </div>
        </div>

        @if($viewData['products']->isEmpty())
            <div class="content-box text-center">
                <h3 class="mb-2">No hay productos disponibles</h3>
                <p class="mb-0">Muy pronto tendremos productos para ti.</p>
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
                                    {{ $product->getStock() > 0 ? 'Disponible' : 'Agotado' }}
                                </span>

                                <h2 class="product-card-title">{{ $product->getName() }}</h2>
                                <p class="product-card-price">${{ number_format($product->getPrice(), 2) }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection