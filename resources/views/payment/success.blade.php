@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white text-center">
                    <i class="bi bi-check-circle-fill fs-1"></i>
                    <h3 class="mb-0 mt-2">{{ __('payment.payment_success') }}</h3>
                </div>
                
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success text-center mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="text-center mb-4">
                        <p class="lead">{{ __('payment.payment_completed') }}</p>
                    </div>
                    
                    <!-- Payment Details -->
                    <div class="payment-details mb-4 p-3 bg-light rounded">
                        <h5 class="fw-bold mb-3"><i class="bi bi-credit-card"></i> {{ __('payment.payment_details') }}</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <small class="text-muted">{{ __('payment.payment_id') }}</small>
                                    <p class="fw-semibold mb-0">#{{ $viewData['payment']->getId() }}</p>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">{{ __('payment.payment_method_used') }}</small>
                                    <p class="fw-semibold mb-0">{{ __('payment.payment_method_budget') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <small class="text-muted">{{ __('payment.payment_amount') }}</small>
                                    <p class="fw-semibold text-success mb-0 fs-4">{{ $viewData['payment']->getAmountFormatted() }}</p>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">{{ __('payment.payment_date') }}</small>
                                    <p class="fw-semibold mb-0">{{ $viewData['payment']->getCreatedAt() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="order-summary mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-receipt"></i> {{ __('payment.order_confirmation') }}</h5>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                        <th>{{ __('payment.product') }}</th>
                                        <th class="text-center">{{ __('payment.quantity') }}</th>
                                        <th class="text-end">{{ __('payment.subtotal') }}</th>
                                    </thead>
                                <tbody>
                                    @foreach($viewData['items'] as $item)
                                            <td>{{ $item->getProduct()->getName() }}</td>
                                            <td class="text-center">x{{ $item->getQuantity() }}</td>
                                            <td class="text-end">{{ $item->getSubtotalFormatted() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end fw-bold">{{ __('payment.total') }}</td>
                                        <td class="text-end fw-bold text-primary">{{ $viewData['order']->getTotalFormatted() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <!-- New Balance -->
                    <div class="new-balance text-center p-3 bg-success bg-opacity-10 rounded mb-4">
                        <small class="text-white">{{ __('payment.new_balance') }}</small>
                        <h3 class="text-light mb-0">{{ $viewData['newBudget'] }}</h3>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('home.index') }}" class="btn btn-primary">
                            <i class="bi bi-shop"></i> {{ __('payment.continue_shopping') }}
                        </a>
                        <a href="{{ route('order.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-list-ul"></i> {{ __('payment.view_orders') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection