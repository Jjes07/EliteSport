<!-- Created by Juan Escobar -->

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Write a Review for: {{ $viewData['product']->getName() }}</h4>
                </div>
                
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if(isset($viewData['existingReview']))
                        <div class="alert alert-warning">
                            You have already reviewed this product. You can only write one review per product.
                        </div>
                        <div class="text-center">
                            <a href="{{ route('product.show', $viewData['product']->getId()) }}" 
                               class="btn btn-primary">
                                Back to Product
                            </a>
                        </div>
                    @else
                        <form method="POST" 
                              action="{{ route('review.save', $viewData['product']->getId()) }}">
                            @csrf
                            
                            <div class="text-center mb-4">
                                <h5>Rate this product</h5>
                                <div class="star-rating interactive mx-auto">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" 
                                               name="rating" 
                                               id="star{{ $i }}" 
                                               value="{{ $i }}"
                                               {{ old('rating') == $i ? 'checked' : '' }}>
                                        <label for="star{{ $i }}">★</label>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="mb-3">
                              <label for="comment" class="form-label">Your Review</label>
                              <textarea name="comment" 
                                        id="comment" 
                                        class="form-control" 
                                        rows="5" 
                                        maxlength="250"
                                        placeholder="Share your experience with this product...">{{ old('comment') }}</textarea>
                              <div class="d-flex justify-content-between mt-1">
                                  <small class="text-muted">
                                      <span id="charCount">0</span> /250
                                  </small>
                              </div>
                          </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('product.show', $viewData['product']->getId()) }}" 
                                   class="btn btn-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Submit Review
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection