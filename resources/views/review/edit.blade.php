@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Edit Your Review for: {{ $viewData['product']->getName() }}</h4>
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
                    
                    <form method="POST" 
                          action="{{ route('review.update', ['productId' => $viewData['product']->getId(), 'reviewId' => $viewData['review']->getId()]) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="text-center mb-4">
                            <h5>Update your rating</h5>
                            <div class="star-rating interactive mx-auto">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" 
                                           name="rating" 
                                           id="star{{ $i }}" 
                                           value="{{ $i }}"
                                           {{ $viewData['review']->getRating() == $i ? 'checked' : '' }}>
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
                                      placeholder="Update your experience...">{{ old('comment', $viewData['review']->getComment()) }}</textarea>
                            <small class="text-muted">Maximum 250 characters</small>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('product.show', $viewData['product']->getId()) }}" 
                               class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Update Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection