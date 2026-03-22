@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Crear Usuario</h4>
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

                        <form method="POST" action="{{ route('user.save') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nombre</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    placeholder="Ej: Juan Esteban López">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    placeholder="Ej: correo@ejemplo.com">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Contraseña</label>
                                <input id="password" type="password" class="form-control" name="password"
                                    placeholder="Ingresa una contraseña">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label fw-semibold">Dirección</label>
                                <input id="address" type="text" class="form-control" name="address"
                                    value="{{ old('address') }}" placeholder="Ej: Calle 10 # 20 - 30">
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label fw-semibold">Número de celular</label>
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}"
                                    placeholder="Ej: 3001234567">
                            </div>

                            <div class="mb-4">
                                <label for="role" class="form-label fw-semibold">Rol</label>
                                <select name="role" id="role" class="form-select">
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                        Administrador
                                    </option>
                                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>
                                        Cliente
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                                    Volver
                                </a>

                                <button type="submit" class="btn btn-primary px-4">
                                    Guardar usuario
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection