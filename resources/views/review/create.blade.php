@extends('layouts.app')
@section("title", "Create Review")
@section('subtitle', "Share your opinion about our products")
@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header text-center text-white bg-secondary">Create Review</div>
          <div class="card-body">
            @if($errors->any())
            <ul id="errors" class="alert alert-danger list-unstyled">
              @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
            @endif

            <form method="POST" action="{{ route('review.save') }}">
              @csrf
              
              <div class="review-form text-center">

                <h4 class="form-title mt-3 mb-3">
                    What do you think about the product?
                </h4>

                {{-- Stars --}}
                <div class="star-rating interactive mx-auto mb-4">
                    @for ($i = 5; $i >= 1; $i--)
                        <input
                            type="radio"
                            name="rating"
                            id="star{{ $i }}"
                            value="{{ $i }}"
                            {{ old('rating') == $i ? 'checked' : '' }}
                        >
                        <label for="star{{ $i }}">★</label>
                    @endfor
                </div>

                <br>

                <h5 class="form-title mb-4">
                    Leave your comment
                </h5>

                {{-- Textarea --}}
                <div class="comment-wrapper mx-auto">
                    <textarea
                        name="comment"
                        id="comment"
                        maxlength="250"
                        rows="5"
                        placeholder="Write your opinion here..."
                    >{{ old('comment') }}</textarea>

                    <div class="char-counter">
                        <span id="charCount">0</span>/250
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">
                    Send
                </button>

            </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
