@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0"><i class="bi bi-credit-card"></i> {{ __('payment.payment_details') }}</h4>
                </div>
                
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Order Summary -->
                    <div class="order-summary mb-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-receipt"></i> {{ __('payment.order_summary') }}</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                        <th>{{ __('payment.product') }}</th>
                                        <th class="text-center">{{ __('payment.quantity') }}</th>
                                        <th class="text-end">{{ __('payment.unit_price') }}</th>
                                        <th class="text-end">{{ __('payment.subtotal') }}</th>
                                    </thead>
                                <tbody>
                                    @foreach($viewData['items'] as $item)
                                            <td>{{ $item->getProduct()->getName() }}</td>
                                            <td class="text-center">x{{ $item->getQuantity() }}</td>
                                            <td class="text-end">{{ $item->getPriceFormatted() }}</td>
                                            <td class="text-end fw-semibold">{{ $item->getSubtotalFormatted() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="3" class="text-end fw-bold">{{ __('payment.total') }}</td>
                                        <td class="text-end fw-bold text-primary fs-5">{{ $viewData['order']->getTotalFormatted() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Budget Info -->
                    <div class="budget-info mb-4 p-3 bg-light rounded">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">{{ __('payment.your_balance') }}</small>
                                <h4 class="mb-0">{{ $viewData['budget'] }}</h4>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">{{ __('payment.total_to_pay') }}</small>
                                <h4 class="mb-0 text-danger">-{{ $viewData['total'] }}</h4>
                            </div>
                            <div class="col-12">
                                <hr class="my-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>{{ __('payment.remaining_balance') }}</strong>
                                    <h5 class="mb-0 {{ $viewData['insufficient'] ? 'text-danger' : 'text-success' }}">
                                        ${{ number_format($viewData['remainingAfterPayment'], 0, '.', ' ') }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Insufficient Balance Warning -->
                    @if($viewData['insufficient'])
                        <div class="alert alert-warning mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ __('payment.insufficient_balance_message', ['amount' => number_format($viewData['needAmount'], 0, ',', '.')]) }}
                        </div>
                    @endif
                    
                    <!-- Payment Method -->
                    <div class="payment-method mb-4 p-3 border rounded">
                        <h6 class="fw-bold mb-2"><i class="bi bi-wallet2"></i> {{ __('payment.payment_method') }}</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="budget" checked disabled>
                            <label class="form-check-label" for="budget">
                                <strong>{{ __('payment.payment_method_budget') }}</strong>
                                <p class="small text-muted mb-0">{{ __('payment.payment_method_budget_description') }}</p>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between gap-3">
                        <a href="{{ route('order.show', $viewData['order']->getId()) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> {{ __('payment.cancel') }}
                        </a>
                        
                        @if(!$viewData['insufficient'])
                            <form action="{{ route('payment.save', $viewData['order']->getId()) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg px-4">
                                    <i class="bi bi-check-lg"></i> {{ __('payment.confirm_payment') }}
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-lg px-4" disabled>
                                <i class="bi bi-x-lg"></i> {{ __('payment.insufficient_balance') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection