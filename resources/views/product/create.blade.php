@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Crear Producto</h4>
                    </div>

                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <h6 class="fw-bold mb-2">Se encontraron errores:</h6>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('product.save') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nombre</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    placeholder="Ej: Balón Nike Premier">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">Descripción</label>
                                <textarea id="description" class="form-control" name="description" rows="4"
                                    placeholder="Describe el producto...">{{ old('description') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label fw-semibold">Precio</label>
                                    <input id="price" type="number" class="form-control" name="price"
                                        value="{{ old('price') }}" min="0" placeholder="Ej: 120000">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="stock" class="form-label fw-semibold">Stock</label>
                                    <input id="stock" type="number" class="form-control" name="stock"
                                        value="{{ old('stock') }}" min="0" placeholder="Ej: 10">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label fw-semibold">Imagen (URL)</label>
                                <input id="image" type="text" class="form-control" name="image" value="{{ old('image') }}"
                                    placeholder="https://...">
                            </div>

                            <div class="mb-4">
                                <label for="category" class="form-label fw-semibold">Categoría</label>
                                <input id="category" type="text" class="form-control" name="category"
                                    value="{{ old('category') }}" placeholder="Ej: Fútbol">
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                                    Volver
                                </a>

                                <button type="submit" class="btn btn-primary px-4">
                                    Guardar producto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection