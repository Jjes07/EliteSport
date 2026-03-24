@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-receipt"></i> {{ $viewData['title'] }}</h4>
            <a href="{{ route('order.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left"></i> {{ __('order.back') }}
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>{{ __('order.id') }}:</strong> #{{ $viewData['order']->getId() }}</p>
                    <p><strong>{{ __('order.date') }}:</strong> {{ $viewData['order']->getDate() }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <p><strong>{{ __('order.status') }}:</strong> 
                        <span class="badge bg-{{ 
                            $viewData['order']->getStatus() === 'paid' ? 'success' : 
                            ($viewData['order']->getStatus() === 'cancelled' ? 'danger' : 'warning') 
                        }}">
                            {{ 
                                $viewData['order']->getStatus() === 'paid' ? __('order.status_paid') : 
                                ($viewData['order']->getStatus() === 'cancelled' ? __('order.status_cancelled') : __('order.status_pending'))
                            }}
                        </span>
                    </p>
                    <p><strong>{{ __('order.total') }}:</strong> {{ $viewData['order']->getTotalFormatted() }}</p>
                </div>
            </div>

            <h5>{{ __('order.products') }}</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                            <th>{{ __('order.product') }}</th>
                            <th>{{ __('order.quantity') }}</th>
                            <th>{{ __('order.unit_price') }}</th>
                            <th>{{ __('order.subtotal') }}</th>
                        </thead>
                    <tbody>
                        @foreach($viewData['items'] as $item)
                                <td>{{ $item->getProduct()->getName() }}
                                <td>{{ $item->getQuantity() }}
                                <td>{{ $item->getPriceFormatted() }}
                                <td>{{ $item->getSubtotalFormatted() }}
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="3" class="text-end fw-bold">{{ __('order.total') }}
                            <td class="fw-bold text-primary">{{ $viewData['order']->getTotalFormatted() }}
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Payment Details Section -->
            @if ($viewData['payment'])
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
            @endif

            @if($viewData['order']->getStatus() == 'pending')
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="{{ route('payment.create', $viewData['order']->getId()) }}" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-credit-card"></i> {{ __('order.continue_pay') }}
                    </a>
                    
                    <form action="{{ route('order.cancel', $viewData['order']->getId()) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger btn-lg px-4" 
                                onclick="return confirm('{{ __('order.cancel_confirm') }}')">
                            <i class="bi bi-x-circle"></i> {{ __('order.cancel_order') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection