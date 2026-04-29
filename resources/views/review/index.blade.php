<!-- Created by Juan Escobar -->

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <!-- Filters Sidebar -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 sticky-top" style="top: 90px;">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="bi bi-funnel"></i> {{ __('reviews.filters') }}</h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold mb-3">{{ __('reviews.rating') }}</h6>
                    
                    <form id="filter-form" method="GET" action="{{ route('review.index', $viewData['product']->getId()) }}">
                        @foreach([5, 4, 3, 2, 1] as $rating)
                            <div class="filter-item mb-2">
                                <label class="filter-label d-flex align-items-center" for="rating-{{ $rating }}">
                                    <input class="form-check-input rating-filter me-2" 
                                           type="checkbox" 
                                           name="ratings[]" 
                                           value="{{ $rating }}"
                                           id="rating-{{ $rating }}"
                                           {{ in_array($rating, $viewData['selectedRatings']) ? 'checked' : '' }}>
                                    <div class="filter-stars d-flex align-items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= $rating ? 'filled' : 'empty' }}">★</span>
                                        @endfor
                                    </div>
                                    <span class="filter-count ms-2">({{ $viewData['ratingCounts'][$rating] }}) {{ __('reviews.comments') }}</span>
                                </label>
                            </div>
                        @endforeach
                    </form>
                    
                    @if(!empty($viewData['selectedRatings']))
                        <hr class="my-3">
                        <a href="{{ route('review.index', $viewData['product']->getId()) }}" 
                           class="btn btn-outline-secondary btn-sm w-100">
                            <i class="bi bi-x-circle"></i> {{ __('reviews.clear_filters') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Reviews List -->
        <div class="col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-chat-dots"></i>
                        <span class="ms-2">{{ __('reviews.title') }}: {{ $viewData['product']->getName() }}</span>
                        <span class="badge bg-light text-dark ms-2">{{ $viewData['reviews']->count() }}</span>
                    </div>
                    <a href="{{ route('product.show', $viewData['product']->getId()) }}" 
                       class="btn btn-outline-light btn-sm">
                        <i class="bi bi-arrow-left"></i> {{ __('reviews.back_to_product') }}
                    </a>
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
                    
                    <!-- Active Filters Display -->
                    @if(!empty($viewData['selectedRatings']))
                        <div class="active-filters mb-4 p-3 bg-light rounded">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <strong><i class="bi bi-funnel"></i> {{ __('reviews.active_filters') }}:</strong>
                                @foreach($viewData['selectedRatings'] as $rating)
                                    <span class="filter-badge">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star small {{ $i <= $rating ? 'filled' : 'empty' }}">★</span>
                                        @endfor
                                        <span class="ms-1">{{ $rating }}★</span>
                                    </span>
                                @endforeach
                                <span class="text-muted ms-2">({{ $viewData['reviews']->count() }} {{ __('reviews.reviews_found') }})</span>
                            </div>
                        </div>
                    @endif
                    
                    @if($viewData['reviews']->isEmpty())
                        <div class="empty-reviews text-center py-5">
                            <div class="empty-icon mb-3"><i class="bi bi-pencil-square"></i></div>
                            @if(!empty($viewData['selectedRatings']))
                                <h5>{{ __('reviews.no_reviews_with_filters') }}</h5>
                                <a href="{{ route('review.index', $viewData['product']->getId()) }}" 
                                   class="btn btn-primary mt-3">
                                    <i class="bi bi-funnel"></i> {{ __('reviews.clear_filters') }}
                                </a>
                            @else
                                <h5>{{ __('reviews.no_reviews') }}</h5>
                                <p class="text-muted">{{ __('reviews.no_reviews') }}</p>
                                @auth
                                    <a href="{{ route('review.create', $viewData['product']->getId()) }}" 
                                       class="btn btn-primary mt-2">
                                        <i class="bi bi-pencil"></i> {{ __('reviews.write_review') }}
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary mt-2">
                                        <i class="bi bi-box-arrow-in-right"></i> {{ __('reviews.login_to_review') }}
                                    </a>
                                @endauth
                            @endif
                        </div>
                    @else
                        <div class="reviews-list">
                            @foreach($viewData['reviews'] as $review)
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
                                                            <span class="star {{ $i <= $review->getRating() ? 'filled' : 'empty' }}">★</span>
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
                                        <p class="mb-0">{{ Str::limit($review->getComment(), 100) }}</p>
                                    </div>
                                    
                                    <div class="review-actions mt-3 pt-2 border-top d-flex gap-2">
                                        @if(Auth::check() && Auth::id() === $review->getUserId())
                                            <a href="{{ route('review.edit', ['productId' => $viewData['product']->getId(), 'reviewId' => $review->getId()]) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> {{ __('reviews.edit_review') }}
                                            </a>
                                        @endif
                                        
                                        @if(Auth::check() && (Auth::user()->getRole() === 'admin' || Auth::id() === $review->getUserId()))
                                            <form action="{{ route('review.delete', ['productId' => $viewData['product']->getId(), 'reviewId' => $review->getId()]) }}" 
                                                  method="POST" 
                                                  class="d-inline">
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection