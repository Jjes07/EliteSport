@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
    <div class="container py-4">
        <div class="cart-header mb-4">
            <h1 class="display-5 fw-bold mb-2">🛒 {{ __('cart.cart_title') }}</h1>
            <p class="text-muted">{{ __('cart.checkout_products') }}</p>
        </div>

        <div class="card shadow-sm border-0 fade-in">
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(count($viewData["products"]) > 0)
                    <div class="table-responsive">
                        <table class="table cart-table">
                            <thead>
                                32
                                    <th>{{ __('products.id') }}</th>
                                    <th>{{ __('products.name') }}</th>
                                    <th>{{ __('products.price') }}</th>
                                    <th>{{ __('products.quantity_label') }}</th>
                                    <th>{{ __('cart.subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($viewData["products"] as $product)
                                    <tr>
                                        <td class="fw-bold text-primary">#{{ $product->getId() }}</td>
                                        <td class="fw-semibold">{{ $product->getName() }}</td>
                                        <td class="text-success fw-semibold">${{ number_format($product->getPrice(), 0, ',', '.') }}</td>
                                        <td>
                                            <span class="quantity-badge">
                                                {{ session('products')[$product->getId()] }}
                                            </span>
                                        </td>
                                        <td class="fw-bold">${{ number_format($product->getPrice() * session('products')[$product->getId()], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="cart-summary mt-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <a href="{{ route('home.index') }}" class="btn btn-outline-secondary btn-lg">
                                    ← {{ __('cart.continue_shopping') }}
                                </a>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="cart-total-box mb-3">
                                    <span class="cart-total-label">{{ __('cart.total_to_pay') }}:</span>
                                    <span class="cart-total-value">${{ number_format($viewData["total"], 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex gap-2 justify-content-md-end">
                                    <button class="btn btn-success btn-lg px-4" onclick="alert('{{ __('cart.buy') }}')">
                                        💳 {{ __('cart.buy') }}
                                    </button>
                                    <a href="{{ route('cart.delete') }}" class="btn btn-outline-danger btn-lg" 
                                    onclick="return confirm('¿Estás seguro de vaciar el carrito?')">
                                        🗑️ {{ __('cart.empty_cart') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-cart text-center py-5">
                        <div class="empty-cart-icon mb-3">🛒</div>
                        <h3 class="mb-2">{{ __('cart.empty_cart_message') }}</h3>
                        <p class="text-muted mb-4">{{ __('cart.no_products_added') }}</p>
                        <a href="{{ route('home.index') }}" class="btn btn-primary btn-lg">
                            🛍️ {{ __('cart.go_shopping') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection