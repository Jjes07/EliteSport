@extends('layouts.app')

@section('title', "Reviews")
@section('subtitle', "Reviews of our products")

@section('content')
<div class="row justify-content-center" style="min-height: 58.5vh;">

  @if (!$viewData["reviews"]->count())
    <div class="col-12">
      <div class="alert alert-info text-center">
        <h5>No reviews yet</h5>
        Be the first to share your opinion about our products!
      </div>
    </div>
  @endif

  @foreach ($viewData["reviews"] as $review)
    <div class="col-md-6 col-lg-4 mb-4">
      <div class="card h-100 shadow-sm">

        <div class="card-body text-center">

          <div>
            <h5 class="card-title mb-1 fw-bold">
              Id. {{ $review->getId() }}
            </h5>
          </div>

          {{-- stars (readonly) --}}
          <div class="star-rating readonly mb-2">
            @for ($i = 1; $i <= 5; $i++)
              <span class="{{ $i <= $review->getRating() ? 'filled' : '' }}">★</span>
            @endfor
          </div>

          {{-- rating label --}}
          <span class="badge {{ $review->getRatingBadgeClass() }}">
              {{ $review->getRatingLabel() }}
          </span>

          {{-- comment preview --}}
          <p class="card-text mt-3">
            {{ Str::limit($review->getComment(), 50) }}
          </p>

        </div>

        {{-- card footer action --}}
        <div class="card-footer text-center bg-white">
          <a href="{{ route('review.show', ['id' => $review->getId()]) }}" class="btn btn-outline-secondary btn-sm">
            View details
          </a>
        </div>

      </div>
    </div>
  @endforeach

</div>
@endsection