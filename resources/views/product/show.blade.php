@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">{{ __('products.detail_title') }}</h4>
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
                            <strong>{{ __('products.id') }}:</strong> {{ $viewData['product']->getId() }}
                        </p>

                        <p class="mb-2">
                            <strong>{{ __('products.description') }}:</strong> {{ $viewData['product']->getDescription() }}
                        </p>

                        <p class="mb-2">
                            <strong>{{ __('forms.category') }}:</strong>
                            {{ $viewData['product']->getCategory()?->getName() }}
                        </p>

                        <p class="mb-2 fs-4 fw-bold text-primary">
                            {{ $viewData['product']->getPriceFormatted() }}
                        </p>

                        <p class="mb-4">
                            <strong>{{ __('products.stock') }}:</strong>
                            @if($viewData['product']->getStock() > 0)
                                <span class="badge bg-success">
                                    {{ __('products.available') }} ({{ $viewData['product']->getStock() }})
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    {{ __('products.out_of_stock') }}
                                </span>
                            @endif
                        </p>

                        @if($viewData['product']->getStock() > 0)
                            <form method="POST" action="{{ route('cart.add', ['id' => $viewData['product']->getId()]) }}">
                                @csrf

                                <div class="d-flex flex-wrap align-items-end gap-3">
                                    <div>
                                        <label for="quantity"
                                            class="form-label fw-semibold">{{ __('products.quantity_label') }}</label>
                                        <input id="quantity" type="number" min="1" max="{{ $viewData['product']->getStock() }}"
                                            class="form-control" name="quantity" value="1" style="width: 120px;">
                                    </div>

                                    <div>
                                        <button class="btn btn-primary px-4" type="submit">
                                            {{ __('products.add_to_cart') }}
                                        </button>
                                    </div>

                                    <div>
                                        <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">
                                            {{ __('products.back_to_home') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-secondary" disabled>
                                    {{ __('products.product_out_of_stock') }}
                                </button>

                                <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">
                                    {{ __('products.back_to_home') }}
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
                <div>
                    <i class="bi bi-chat-dots"></i>
                    <span class="ms-2">{{ __('reviews.title') }} ({{ $viewData['totalReviews'] }})</span>
                </div>

                @auth
                    @if(!$viewData['userReview'])
                        <a href="{{ route('review.create', $viewData['product']->getId()) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pencil"></i> {{ __('reviews.write_review') }}
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-in-right"></i> {{ __('reviews.login_to_review') }}
                    </a>
                @endauth
            </div>

            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($viewData['reviewsLimit']->isEmpty())
                    <div class="empty-reviews text-center py-5">
                        <div class="empty-icon mb-3"><i class="bi bi-pencil-square"></i></div>
                        <h5>{{ __('reviews.no_reviews') }}</h5>
                        <p class="text-muted">{{ __('reviews.no_reviews') }}</p>
                        @auth
                            @if(!$viewData['userReview'])
                                <a href="{{ route('review.create', $viewData['product']->getId()) }}" class="btn btn-primary mt-2">
                                    <i class="bi bi-pencil"></i> {{ __('reviews.write_review') }}
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-box-arrow-in-right"></i> {{ __('reviews.login_to_review') }}
                            </a>
                        @endauth
                    </div>
                @else
                    <div class="reviews-list">
                        @foreach($viewData['reviewsLimit'] as $review)
                            <div class="review-card mb-4 p-4 border rounded">
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                    <div class="review-author-info">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <div class="author-avatar">
                                                <i class="bi bi-person-circle fs-3"></i>
                                            </div>
                                            <div>
                                                <strong class="fs-5">{{ $review->getUser()->getName() }}</strong>
                                                <div class="star-rating-readonly mt-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span
                                                            class="star {{ $i <= $review->getRating() ? 'filled' : 'empty' }}">★</span>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-meta text-end">
                                        <small class="text-muted d-block">
                                            <i class="bi bi-calendar"></i> {{ $review->getCreatedAt() }}
                                        </small>
                                        @if($review->getCreatedAt() != $review->getUpdatedAt())
                                            <small class="text-muted">(<i class="bi bi-pencil"></i> {{ __('reviews.edited') }})</small>
                                        @endif
                                        <div class="mt-1">
                                            <a href="{{ route('review.show', ['productId' => $viewData['product']->getId(), 'reviewId' => $review->getId()]) }}"
                                                class="btn btn-sm btn-link text-decoration-none">
                                                <i class="bi bi-eye"></i> {{ __('reviews.view_details') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="review-content mt-3">
                                    <p class="mb-0">{{ Str::limit($review->getComment(), 80) }}</p>
                                </div>

                                <div class="review-actions mt-3 pt-2 border-top d-flex gap-2">
                                    @if(Auth::check() && Auth::id() === $review->getUserId())
                                        <a href="{{ route('review.edit', ['productId' => $viewData['product']->getId(), 'reviewId' => $review->getId()]) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> {{ __('reviews.edit_review') }}
                                        </a>
                                    @endif

                                    @if(Auth::check() && (Auth::user()->getRole() === 'admin' || Auth::id() === $review->getUserId()))
                                        <form
                                            action="{{ route('review.delete', ['productId' => $viewData['product']->getId(), 'reviewId' => $review->getId()]) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                data-confirm="{{ __('reviews.confirm_delete') }}">
                                                <i class="bi bi-trash"></i> {{ __('reviews.delete_review') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- View All Reviews Button - Show when there is at least 1 review -->
                    @if($viewData['totalReviews'] > 0)
                        <div class="text-center mt-3">
                            <a href="{{ route('review.index', $viewData['product']->getId()) }}" class="btn btn-outline-primary">
                                <i class="bi bi-eye"></i> {{ __('reviews.view_all') }} ({{ $viewData['totalReviews'] }})
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection