@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <h1>{{ $viewData['title'] }}</h1>

    @forelse($viewData['phones'] as $phone)
        <div>
            <h2>{{ $phone['name'] }}</h2>
            <p>Marca: {{ $phone['brand'] }}</p>
            <p>Memoria: {{ $phone['memory'] }}</p>
            <p>RAM: {{ $phone['ram'] }}</p>
            <p>Batería: {{ $phone['battery'] }}</p>
            <p>Precio: ${{ number_format($phone['price'], 0, ',', '.') }}</p>
            <p>Stock: {{ $phone['quantity'] }}</p>
            <a href="{{ $phone['url'] }}">Ver detalle</a>
        </div>
    @empty
        <p>No hay teléfonos disponibles en este momento.</p>
    @endforelse
@endsection