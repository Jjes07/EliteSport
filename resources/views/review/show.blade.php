@extends('layouts.app')

@section('title', 'Review Details')
@section('subtitle', 'Details of the review')

@section('content')

{{-- Go back button --}}
<button
    type="button"
    class="btn btn-secondary mx-auto"
    onclick="window.history.back()">
    <strong>←</strong> Go back
</button>
  

<div class="card mx-auto" style="max-width: 600px;">
  <div class="card-body text-center">

    {{-- Metadata --}}
    <div class="d-flex justify-content-between gap-4 text-muted small fst-italic mb-2">

        <span>
            <strong>ID:</strong>
            #{{ $viewData["review"]->getId() }}
        </span>

        <span>
            <strong>Created:</strong>
            {{ $viewData["review"]->getCreatedAt() }}
        </span>

    </div>
    
    {{-- Rating label --}}
    <h4 class="mb-2">
      {{ $viewData["review"]->getRatingLabel() }}
    </h4>

    {{-- Stars --}}
    <div class="star-rating readonly mb-3">
      @for ($i = 1; $i <= 5; $i++)
        <span class="{{ $i <= $viewData['review']->getRating() ? 'filled' : '' }}">
          ★
        </span>
      @endfor
    </div>

    {{-- Comment --}}
    <p class="mt-3">
      {{ $viewData["review"]->getComment() }}
    </p>

  </div>
</div>

{{-- Delete button --}}
<button
    type="button"
    class="btn btn-danger mt-4 mx-auto d-block"
    onclick="document.getElementById('delete-confirm').classList.remove('d-none')">
    Delete review
</button>

{{-- Delete confirmation --}}

<div id="delete-confirm" class="alert alert-danger mt-4 d-none text-center">

    <p class="mb-3 fw-semibold">
        Are you sure you want to delete this review?  
        This action cannot be undone.
    </p>

    <form action="{{ route('review.destroy', ['id' => $viewData['review']->getId()]) }}"
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

@endsection