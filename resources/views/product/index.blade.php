@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Lista de Productos</h4>

                <a href="{{ route('product.create') }}" class="btn btn-primary">
                    Crear Producto
                </a>
            </div>

            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Imagen</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($viewData['products'] as $product)
                                <tr>
                                    <td class="fw-semibold">{{ $product->getId() }}</td>
                                    <td>{{ $product->getName() }}</td>
                                    <td>
                                        <img src="{{ $product->getImage() }}" alt="{{ $product->getName() }}"
                                            class="img-fluid rounded"
                                            style="max-width: 95px; max-height: 70px; object-fit: contain;">
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center flex-wrap gap-2">
                                            <a href="{{ route('product.show', ['id' => $product->getId()]) }}"
                                                class="btn btn-primary btn-sm">
                                                Detalles
                                            </a>

                                            <a href="{{ route('product.edit', ['id' => $product->getId()]) }}"
                                                class="btn btn-secondary btn-sm">
                                                Editar
                                            </a>

                                            <form action="{{ route('product.delete', ['id' => $product->getId()]) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-muted py-4">
                                        No hay productos registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection