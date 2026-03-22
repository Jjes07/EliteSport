@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Review Details</h4>
                </div>
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <strong>Product:</strong> 
                            <a href="{{ route('product.show', $viewData['product']->getId()) }}">
                                {{ $viewData['product']->getName() }}
                            </a>
                        </div>
                        <div>
                            <strong>Review ID:</strong> #{{ $viewData['review']->getId() }}
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <strong>By:</strong> {{ $viewData['review']->user->getName() }}
                        </div>
                        <div>
                            <small class="text-muted">
                                Created: {{ $viewData['review']->getCreatedAt() }}
                            </small>
                            @if($viewData['review']->getCreatedAt() != $viewData['review']->getUpdatedAt())
                                <br><small class="text-muted">Updated: {{ $viewData['review']->getUpdatedAt() }}</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="text-center mb-4">
                        <h5>Rating</h5>
                        <div class="star-rating readonly">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $viewData['review']->getRating() ? 'filled' : '' }}">★</span>
                            @endfor
                        </div>
                        <span class="badge {{ $viewData['review']->getRatingBadgeClass() }} mt-2">
                            {{ $viewData['review']->getRatingLabel() }}
                        </span>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Comment</h5>
                        <p class="lead">{{ $viewData['review']->getComment() }}</p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('product.show', $viewData['product']->getId()) }}" 
                           class="btn btn-secondary">
                            Back to Product
                        </a>
                        
                        <div class="d-flex gap-2">
                            @if(Auth::check() && Auth::id() === $viewData['review']->getUserId())
                                <a href="{{ route('review.edit', ['productId' => $viewData['product']->getId(), 'reviewId' => $viewData['review']->getId()]) }}" 
                                   class="btn btn-outline-primary">
                                    Edit
                                </a>
                            @endif
                            
                            @if(Auth::check() && (Auth::user()->getRole() === 'admin' || Auth::id() === $viewData['review']->getUserId()))
                                <button type="button" 
                                        class="btn btn-outline-danger"
                                        onclick="document.getElementById('delete-confirm').classList.remove('d-none')">
                                    Delete
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <div id="delete-confirm" class="alert alert-danger mt-4 d-none text-center">
                        <p class="mb-3 fw-semibold">
                            Are you sure you want to delete this review? This action cannot be undone.
                        </p>
                        
                        <form action="{{ route('review.destroy', ['productId' => $viewData['product']->getId(), 'reviewId' => $viewData['review']->getId()]) }}" 
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger me-2">
                                Yes, delete
                            </button>
                        </form>
                        
                        <button class="btn btn-secondary"
                                onclick="document.getElementById('delete-confirm').classList.add('d-none')">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection