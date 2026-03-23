@extends('layouts.app')
@section('content')
<div class="container mt-4">
  <h1>{{ $viewData['title'] }}</h1>
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  <table class="table">
    <tr>
      <th>ID</th><th>Fecha</th><th>Estado</th><th>Total</th><th>Acciones</th>
    </tr>
    @foreach($viewData['orders'] as $order)
    <tr>
      <td>{{ $order->getId() }}</td>
      <td>{{ $order->getDate() }}</td>
      <td>{{ $order->getStatus() }}</td>
      <td>{{ $order->getTotal() }}</td>
      <td><a href="{{ route('order.show', $order->getId()) }}">Ver</a></td>
    </tr>
    @endforeach
  </table>
</div>
@endsection