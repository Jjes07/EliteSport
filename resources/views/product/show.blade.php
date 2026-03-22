@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Detalle del Producto</h4>
            </div>

            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row align-items-center g-4">
                    <div class="col-md-4 text-center">
                        <img src="{{ $viewData['product']->getImage() }}" class="img-fluid rounded product-detail-image"
                            alt="{{ $viewData['product']->getName() }}">
                    </div>

                    <div class="col-md-8">
                        <h2 class="fw-bold mb-3">
                            {{ $viewData['product']->getName() }}
                        </h2>

                        <p class="mb-2">
                            <strong>ID:</strong> {{ $viewData['product']->getId() }}
                        </p>

                        <p class="mb-2">
                            <strong>Descripción:</strong> {{ $viewData['product']->getDescription() }}
                        </p>

                        <p class="mb-2 fs-4 fw-bold text-primary">
                            ${{ number_format($viewData['product']->getPrice(), 0, ',', '.') }}
                        </p>

                        <p class="mb-4">
                            <strong>Stock:</strong>
                            @if($viewData['product']->getStock() > 0)
                                <span class="badge bg-success">
                                    Disponible ({{ $viewData['product']->getStock() }})
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Agotado
                                </span>
                            @endif
                        </p>

                        @if($viewData['product']->getStock() > 0)
                            <form method="POST" action="{{ route('cart.add', ['id' => $viewData['product']->getId()]) }}">
                                @csrf

                                <div class="d-flex flex-wrap align-items-end gap-3">
                                    <div>
                                        <label for="quantity" class="form-label fw-semibold">Cantidad</label>
                                        <input id="quantity" type="number" min="1" max="{{ $viewData['product']->getStock() }}"
                                            class="form-control" name="quantity" value="1" style="width: 120px;">
                                    </div>

                                    <div>
                                        <button class="btn btn-primary px-4" type="submit">
                                            Agregar al carrito
                                        </button>
                                    </div>

                                    <div>
                                        <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">
                                            Volver al inicio
                                        </a>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-secondary" disabled>
                                    Producto agotado
                                </button>

                                <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">
                                    Volver al inicio
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Customer Reviews ({{ $viewData['totalReviews'] }})</h5>
                
                @auth
                    @if(!$viewData['userReview'])
                        <a href="{{ route('review.create', $viewData['product']->getId()) }}" 
                        class="btn btn-primary btn-sm">
                            Write a Review
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                        Login to write a review
                    </a>
                @endauth
            </div>
            
            <div class="card-body">
                @if($viewData['reviewsLimit']->isEmpty())
                    <p class="text-muted text-center py-3">No reviews yet. Be the first to review this product!</p>
                @else
                    @foreach($viewData['reviewsLimit'] as $review)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $review->user->getName() }}</strong>
                                    <div class="star-rating readonly small">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $review->getRating() ? 'filled' : '' }}">★</span>
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">{{ $review->getCreatedAt() }}</small>
                                    @if($review->getCreatedAt() != $review->getUpdatedAt())
                                        <small class="text-muted">(edited)</small>
                                    @endif
                                    <a href="{{ route('review.show', ['productId' => $viewData['product']->getId(), 'reviewId' => $review->getId()]) }}" 
                                    class="btn btn-sm btn-link p-0 mt-1">
                                        View Details
                                    </a>
                                </div>
                            </div>
                            <p class="mt-2 mb-2">{{ Str::limit($review->getComment(), 150) }}</p>
                            
                            <div class="d-flex gap-2">
                                @if(Auth::check() && Auth::id() === $review->getUserId())
                                    <a href="{{ route('review.edit', ['productId' => $viewData['product']->getId(), 'reviewId' => $review->getId()]) }}" 
                                    class="btn btn-sm btn-outline-secondary">
                                        Edit
                                    </a>
                                @endif
                                
                                @if(Auth::check() && (Auth::user()->getRole() === 'admin' || Auth::id() === $review->getUserId()))
                                    <form action="{{ route('review.delete', ['productId' => $viewData['product']->getId(), 'reviewId' => $review->getId()]) }}" 
                                        method="POST" 
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Are you sure you want to delete this review?')">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- View All Reviews Button -->
                    @if($viewData['totalReviews'] > 3)
                        <div class="text-center mt-3">
                            <a href="{{ route('review.index', $viewData['product']->getId()) }}" 
                            class="btn btn-outline-primary">
                                View All {{ $viewData['totalReviews'] }} Reviews
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>

    </div>
@endsection