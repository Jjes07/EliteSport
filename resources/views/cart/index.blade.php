@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">{{ __('cart.cart_title') }}</h4>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(count($viewData["products"]) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">{{ __('products.id') }}</th>
                                    <th scope="col">{{ __('products.name') }}</th>
                                    <th scope="col">{{ __('products.price') }}</th>
                                    <th scope="col">{{ __('products.quantity_label') }}</th>
                                    <th scope="col">{{ __('cart.subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($viewData["products"] as $product)
                                    <tr>
                                        <td>{{ $product->getId() }}</td>
                                        <td class="fw-semibold">{{ $product->getName() }}</td>
                                        <td>${{ number_format($product->getPrice(), 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ session('products')[$product->getId()] }}
                                            </span>
                                        </td>
                                        <td>
                                            ${{ number_format($product->getPrice() * session('products')[$product->getId()], 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-4">
                        <div>
                            <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">
                                {{ __('cart.continue_shopping') }}
                            </a>
                        </div>

                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <div class="px-3 py-2 border rounded bg-light">
                                <strong>{{ __('cart.total_to_pay') }}:</strong>
                                ${{ number_format($viewData["total"], 0, ',', '.') }}
                            </div>

                            <a href="#" class="btn btn-primary">
                                {{ __('cart.buy') }}
                            </a>

                            <a href="{{ route('cart.delete') }}" class="btn btn-danger">
                                {{ __('cart.empty_cart') }}
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <h5 class="mb-3">{{ __('cart.empty_cart_message') }}</h5>
                        <p class="text-muted">{{ __('cart.no_products_added') }}</p>
                        <a href="{{ route('home.index') }}" class="btn btn-primary">
                            {{ __('cart.go_shopping') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection