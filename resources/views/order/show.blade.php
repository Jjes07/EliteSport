@extends('layouts.app')
@section('content')
<div class="container mt-4">
  <h1>{{ $viewData['title'] }}</h1>
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif
  <p>Estado: {{ $viewData['order']->getStatus() }}</p>
  <p>Total: {{ $viewData['order']->getTotal() }}</p>
  <table class="table">
    <tr>
      <th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th>
    </tr>
    @foreach($viewData['items'] as $item)
    <tr>
      <td>{{ $item->getProduct()->getName() }}</td>
      <td>{{ $item->getQuantity() }}</td>
      <td>{{ $item->getPrice() }}</td>
      <td>{{ $item->calculateSubtotal() }}</td>
    </tr>
    @endforeach
  </table>
  @if($viewData['order']->getStatus() == 'pending')
    <form method="POST" action="{{ route('order.confirm', $viewData['order']->getId()) }}">
      @csrf
      <button type="submit" class="btn btn-primary">Confirmar y Pagar</button>
    </form>
  @endif
  <a href="{{ route('order.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection