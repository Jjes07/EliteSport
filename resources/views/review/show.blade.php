<!-- Created by Juan Escobar -->

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-chat-quote"></i> {{ __('reviews.detail_title') }}</h4>
                    <a href="{{ route('review.index', $viewData['product']->getId()) }}" 
                       class="btn btn-outline-light btn-sm">
                        <i class="bi bi-arrow-left"></i> {{ __('reviews.back_to_reviews') }}
                    </a>
                </div>
                
                <div class="card-body">
                    <!-- Product and Review ID -->
                    <div class="d-flex justify-content-between align-items-start mb-4 pb-2 border-bottom">
                        <div class="product-info">
                            <span class="text-muted">{{ __('products.name') }}:</span>
                            <strong>
                                <a href="{{ route('product.show', $viewData['product']->getId()) }}" class="text-decoration-none">
                                    {{ $viewData['product']->getName() }}
                                </a>
                            </strong>
                        </div>
                        <div class="review-id">
                            <span class="text-muted">{{ __('reviews.title') }} {{ __('reviews.id') }}:</span>
                            <span class="badge bg-secondary">#{{ $viewData['review']->getId() }}</span>
                        </div>
                    </div>
                    
                    <!-- Author and Date -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="author-info d-flex align-items-center gap-2">
                            <div class="author-avatar">
                                <i class="bi bi-person-circle fs-1 text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $viewData['review']->user->getName() }}</h5>
                                <div class="review-stars mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $viewData['review']->getRating() ? 'filled' : 'empty' }}">★</span>
                                    @endfor
                                    <span class="badge {{ $viewData['review']->getRatingBadgeClass() }} ms-2">
                                        {{ $viewData['review']->getRatingLabel() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="date-info text-end">
                            <small class="text-muted d-block">
                                <i class="bi bi-calendar"></i> {{ __('reviews.created') }}: {{ $viewData['review']->getCreatedAt() }}
                            </small>
                            @if($viewData['review']->getCreatedAt() != $viewData['review']->getUpdatedAt())
                                <small class="text-muted">
                                    <i class="bi bi-pencil"></i> {{ __('reviews.updated') }}: {{ $viewData['review']->getUpdatedAt() }}
                                </small>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Comment Section -->
                    <div class="comment-section mt-4">
                        <div class="comment-header d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-chat-text-fill fs-4 text-primary"></i>
                            <h5 class="mb-0">{{ __('reviews.comment') }}</h5>
                        </div>
                        <div class="comment-content p-4 bg-light rounded-3 border-start border-primary border-4">
                            <p class="mb-0 fs-5">{{ $viewData['review']->getComment() }}</p>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a href="{{ route('product.show', $viewData['product']->getId()) }}" 
                           class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> {{ __('reviews.back_to_product') }}
                        </a>
                        
                        <div class="d-flex gap-2">
                            @if(Auth::check() && Auth::id() === $viewData['review']->getUserId())
                                <a href="{{ route('review.edit', ['productId' => $viewData['product']->getId(), 'reviewId' => $viewData['review']->getId()]) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i> {{ __('reviews.edit_review') }}
                                </a>
                            @endif
                            
                            @if(Auth::check() && (Auth::user()->getRole() === 'admin' || Auth::id() === $viewData['review']->getUserId()))
                                <button type="button" 
                                        class="btn btn-outline-danger"
                                        onclick="document.getElementById('delete-confirm').classList.remove('d-none')">
                                    <i class="bi bi-trash"></i> {{ __('reviews.delete_review') }}
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Delete Confirmation Modal -->
                    <div id="delete-confirm" class="alert alert-danger mt-4 d-none text-center">
                        <p class="mb-3 fw-semibold">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ __('reviews.confirm_delete') }}
                        </p>
                        
                        <form action="{{ route('review.delete', ['productId' => $viewData['product']->getId(), 'reviewId' => $viewData['review']->getId()]) }}" 
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger me-2">
                                <i class="bi bi-check-lg"></i> {{ __('reviews.yes_delete') }}
                            </button>
                        </form>
                        
                        <button class="btn btn-secondary"
                                onclick="document.getElementById('delete-confirm').classList.add('d-none')">
                            <i class="bi bi-x-lg"></i> {{ __('reviews.cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection