@extends('layouts.admin')

@section('title', $viewData['title'])

@section('content')
    <div class="admin-content">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="admin-card">
                    <div class="admin-card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-info-circle"></i> {{ $viewData['product']->getName() }}
                        </div>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-arrow-left"></i> {{ __('forms.back') }}
                        </a>
                    </div>

                    <div class="admin-card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{ $viewData['product']->getImage() }}" class="img-fluid rounded shadow-sm mb-3" alt="{{ $viewData['product']->getName() }}">
                            </div>
                            <div class="col-md-7">
                                <h3>{{ $viewData['product']->getName() }}</h3>
                                <p class="text-muted"><i class="bi bi-tag"></i> {{ $viewData['product']->getCategory()?->getName() }}</p>
                                
                                <div class="mb-4">
                                    <h4 class="text-primary">{{ $viewData['product']->getPriceFormatted() }}</h4>
                                </div>
                                
                                <div class="mb-4">
                                    <h5>{{ __('forms.description') }}:</h5>
                                    <p>{{ $viewData['product']->getDescription() }}</p>
                                </div>
                                
                                <ul class="list-group list-group-flush mb-4">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>ID:</strong>
                                        <span>{{ $viewData['product']->getId() }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>{{ __('forms.stock') }}:</strong>
                                        <span class="badge bg-{{ $viewData['product']->getStock() > 0 ? 'success' : 'danger' }} rounded-pill">
                                            {{ $viewData['product']->getStock() }}
                                        </span>
                                    </li>
                                </ul>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.product.edit', ['id' => $viewData['product']->getId()]) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i> {{ __('products.edit') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
