@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0"><i class="bi bi-receipt"></i> {{ $viewData['title'] }}</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($viewData['orders']->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="mt-2">{{ __('order.no_orders') }}</p>
                    <a href="{{ route('home.index') }}" class="btn btn-primary mt-2">
                        {{ __('cart.go_shopping') }}
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>

                                <th>{{ __('order.id') }}</th>
                                <th>{{ __('order.date') }}</th>
                                <th>{{ __('order.status') }}</th>
                                <th>{{ __('order.total') }}</th>
                                <th>{{ __('order.actions') }}</th>
                            </thead>
                        <tbody>
                            @foreach($viewData['orders'] as $order)
                                <tr>
                                    <td>#{{ $order->getId() }}</td>
                                    <td>{{ $order->getDate() }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $order->getStatus() === 'paid' ? 'success' : 
                                            ($order->getStatus() === 'cancelled' ? 'danger' : 'warning') 
                                        }}">
                                            {{ 
                                                $order->getStatus() === 'paid' ? __('order.status_paid') : 
                                                ($order->getStatus() === 'cancelled' ? __('order.status_cancelled') : __('order.status_pending'))
                                            }}
                                        </span>
                                    </td>
                                    <td>{{ $order->getTotalFormatted() }}</td>
                                    <td>
                                        <a href="{{ route('order.show', $order->getId()) }}" class="btn btn-sm btn-primary">
                                            {{ __('order.view') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection