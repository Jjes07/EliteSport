<!-- Created by Juan Escobar -->

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ __('reviews.detail_title') }}</h4>
                    <a href="{{ route('review.index', $viewData['product']->getId()) }}" 
                       class="btn btn-outline-light btn-sm">
                        {{ __('reviews.back_to_reviews') }}
                    </a>
                </div>
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <strong>{{ __('products.name') }}:</strong> 
                            <a href="{{ route('product.show', $viewData['product']->getId()) }}">
                                {{ $viewData['product']->getName() }}
                            </a>
                        </div>
                        <div>
                            <strong>{{ __('reviews.title') }} {{ __('reviews.id') }}:</strong> #{{ $viewData['review']->getId() }}
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <strong>{{ __('reviews.by') }}:</strong> {{ $viewData['review']->user->getName() }}
                        </div>
                        <div>
                            <small class="text-muted">
                                {{ __('reviews.created') }}: {{ $viewData['review']->getCreatedAt() }}
                            </small>
                            @if($viewData['review']->getCreatedAt() != $viewData['review']->getUpdatedAt())
                                <br><small class="text-muted">{{ __('reviews.updated') }}: {{ $viewData['review']->getUpdatedAt() }}</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="text-center mb-4">
                        <h5>{{ __('reviews.rating') }}</h5>
                        <div class="review-stars-large">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $viewData['review']->getRating() ? 'filled' : 'empty' }}">★</span>
                            @endfor
                        </div>
                        <span class="badge {{ $viewData['review']->getRatingBadgeClass() }} mt-2">
                            {{ $viewData['review']->getRatingLabel() }}
                        </span>
                    </div>
                    
                    <div class="mb-4">
                        <h5>{{ __('reviews.comment') }}</h5>
                        <p class="lead">{{ $viewData['review']->getComment() }}</p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('product.show', $viewData['product']->getId()) }}" 
                           class="btn btn-secondary">
                            {{ __('reviews.back_to_product') }}
                        </a>
                        
                        <div class="d-flex gap-2">
                            @if(Auth::check() && Auth::id() === $viewData['review']->getUserId())
                                <a href="{{ route('review.edit', ['productId' => $viewData['product']->getId(), 'reviewId' => $viewData['review']->getId()]) }}" 
                                   class="btn btn-outline-primary">
                                    {{ __('reviews.edit_review') }}
                                </a>
                            @endif
                            
                            @if(Auth::check() && (Auth::user()->getRole() === 'admin' || Auth::id() === $viewData['review']->getUserId()))
                                <button type="button" 
                                        class="btn btn-outline-danger"
                                        onclick="document.getElementById('delete-confirm').classList.remove('d-none')">
                                    {{ __('reviews.delete_review') }}
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <div id="delete-confirm" class="alert alert-danger mt-4 d-none text-center">
                        <p class="mb-3 fw-semibold">
                            {{ __('reviews.confirm_delete') }}
                        </p>
                        
                        <form action="{{ route('review.delete', ['productId' => $viewData['product']->getId(), 'reviewId' => $viewData['review']->getId()]) }}" 
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger me-2">
                                {{ __('reviews.yes_delete') }}
                            </button>
                        </form>
                        
                        <button class="btn btn-secondary"
                                onclick="document.getElementById('delete-confirm').classList.add('d-none')">
                            {{ __('reviews.cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection