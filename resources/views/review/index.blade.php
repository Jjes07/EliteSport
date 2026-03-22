<!-- Created by Juan Escobar -->

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">{{ __('reviews.filters') }}</h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold mb-3">{{ __('reviews.rating') }}</h6>
                    
                    <form id="filter-form" method="GET" action="{{ route('review.index', $viewData['product']->getId()) }}">
                        @foreach([5, 4, 3, 2, 1] as $rating)
                            <div class="form-check mb-2">
                                <input class="form-check-input rating-filter" 
                                       type="checkbox" 
                                       name="ratings[]" 
                                       value="{{ $rating }}"
                                       id="rating-{{ $rating }}"
                                       {{ in_array($rating, $viewData['selectedRatings']) ? 'checked' : '' }}>
                                <label class="form-check-label d-flex align-items-center" for="rating-{{ $rating }}">
                                    <div class="star-rating readonly small me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="{{ $i <= $rating ? 'filled' : '' }}">★</span>
                                        @endfor
                                    </div>
                                    <span class="badge bg-secondary ms-2">{{ $viewData['ratingCounts'][$rating] }} {{ __('reviews.title') }}</span>
                                </label>
                            </div>
                        @endforeach
                    </form>
                    
                    @if(!empty($viewData['selectedRatings']))
                        <hr>
                        <a href="{{ route('review.index', $viewData['product']->getId()) }}" 
                           class="btn btn-outline-secondary btn-sm w-100">
                            {{ __('reviews.clear_filters') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Reviews List -->
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('reviews.title') }}: {{ $viewData['product']->getName() }}</h4>
                    <a href="{{ route('product.show', $viewData['product']->getId()) }}" 
                       class="btn btn-outline-light btn-sm">
                        {{ __('reviews.back_to_product') }}
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <!-- Active Filters Display -->
                    @if(!empty($viewData['selectedRatings']))
                        <div class="alert alert-info mb-3">
                            <strong>{{ __('reviews.active_filters') }}:</strong>
                            @foreach($viewData['selectedRatings'] as $rating)
                                <span class="badge bg-warning text-dark me-1">
                                    {{ $rating }} ★
                                </span>
                            @endforeach
                            <span class="ms-2">({{ $viewData['reviews']->count() }} {{ __('reviews.reviews_found') }})</span>
                        </div>
                    @endif
                    
                    @if($viewData['reviews']->isEmpty())
                        <div class="alert alert-info text-center">
                            @if(!empty($viewData['selectedRatings']))
                                <p>{{ __('reviews.no_reviews_with_filters') }}</p>
                                <a href="{{ route('review.index', $viewData['product']->getId()) }}" 
                                   class="btn btn-primary">
                                    {{ __('reviews.clear_filters') }}
                                </a>
                            @else
                                <p>{{ __('reviews.no_reviews') }}</p>
                                @auth
                                    <a href="{{ route('review.create', $viewData['product']->getId()) }}" 
                                       class="btn btn-primary">
                                        {{ __('reviews.write_review') }}
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        {{ __('reviews.login_to_review') }}
                                    </a>
                                @endauth
                            @endif
                        </div>
                    @else
                        @foreach($viewData['reviews'] as $review)
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
                                            <small class="text-muted">({{ __('reviews.edited') }})</small>
                                        @endif
                                        <a href="{{ route('review.show', ['productId' => $viewData['product']->getId(), 'reviewId' => $review->getId()]) }}" 
                                           class="btn btn-sm btn-link p-0 mt-1">
                                            {{ __('reviews.view_details') }}
                                        </a>
                                    </div>
                                </div>
                                <p class="mt-2 mb-2">{{ $review->getComment() }}</p>
                                
                                <div class="d-flex gap-2">
                                    @if(Auth::check() && Auth::id() === $review->getUserId())
                                        <a href="{{ route('review.edit', ['productId' => $viewData['product']->getId(), 'reviewId' => $review->getId()]) }}" 
                                           class="btn btn-sm btn-outline-secondary">
                                            {{ __('reviews.edit_review') }}
                                        </a>
                                    @endif
                                    
                                    @if(Auth::check() && (Auth::user()->getRole() === 'admin' || Auth::id() === $review->getUserId()))
                                        <form action="{{ route('review.delete', ['productId' => $viewData['product']->getId(), 'reviewId' => $review->getId()]) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('{{ __('reviews.confirm_delete') }}')">
                                                {{ __('reviews.delete_review') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection