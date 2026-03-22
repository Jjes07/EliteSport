@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Reviews for: {{ $viewData['product']->getName() }}</h4>
                    <a href="{{ route('product.show', $viewData['product']->getId()) }}" 
                       class="btn btn-outline-light btn-sm">
                        Back to Product
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
                    
                    @if($viewData['reviews']->isEmpty())
                        <div class="alert alert-info text-center">
                            <h5>No reviews yet</h5>
                            <p>Be the first to share your opinion about this product!</p>
                            @auth
                                <a href="{{ route('review.create', $viewData['product']->getId()) }}" 
                                   class="btn btn-primary">
                                    Write a Review
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    Login to Write a Review
                                </a>
                            @endauth
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
                                        <a href="{{ route('review.show', ['productId' => $viewData['product']->getId(), 'reviewId' => $review->getId()]) }}" 
                                           class="btn btn-sm btn-link">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                                <p class="mt-2 mb-0">{{ Str::limit($review->getComment(), 150) }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection