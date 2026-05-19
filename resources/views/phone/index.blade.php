@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container my-4">
    <div class="text-center mb-4">
        <h1 class="fw-bold text-dark">{{ $viewData['title'] }}</h1>
        <p class="text-muted">{{ __('phone.subtitle') }}</p>
    </div>

    <!-- Phone Grid -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse($viewData['phones'] as $phone)
            <div class="col">
                <div class="card h-100 shadow-sm border">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-primary">{{ $phone['name'] }}</h5>
                        <h6 class="card-subtitle mb-3 text-muted">{{ __('phone.brand') }}: {{ $phone['brand'] ?? 'N/A' }}</h6>
                        
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>{{ __('phone.memory') }}:</span>
                                <strong>{{ $phone['memory'] ?? 'N/A' }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>{{ __('phone.ram') }}:</span>
                                <strong>{{ $phone['ram'] ?? 'N/A' }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>{{ __('phone.battery') }}:</span>
                                <strong>{{ $phone['battery'] ?? 'N/A' }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span>{{ __('phone.available') }}:</span>
                                <strong>{{ $phone['quantity'] ?? 0 }} {{ __('phone.units') }}</strong>
                            </li>
                        </ul>

                        <div class="mt-3 border-top pt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fs-5 fw-bold text-success">${{ number_format($phone['price'] ?? 0, 0, ',', '.') }}</span>
                                @if(isset($phone['url']))
                                    <a href="{{ $phone['url'] }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-box-arrow-up-right"></i> {{ __('phone.view_product') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">{{ __('phone.no_phones') }}</p>
            </div>
        @endforelse
    </div>
</div>
@endsection