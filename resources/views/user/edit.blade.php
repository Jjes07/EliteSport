@extends('layouts.app')
@section('title', $viewData['title'])
@section('content')
    <div class="content-box form-section mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Editar Usuario</h1>

            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </div>

        <form action="{{ route('user.update', $viewData['user']->getId()) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-6">
                    <label for="name" class="form-label custom-label">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control custom-input"
                        value="{{ old('name', $viewData['user']->getName()) }}">

                    @error('name')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label custom-label">Correo</label>
                    <input type="email" name="email" id="email" class="form-control custom-input"
                        value="{{ old('email', $viewData['user']->getEmail()) }}">

                    @error('email')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label custom-label">Nueva contraseña</label>
                    <input type="password" name="password" id="password" class="form-control custom-input">

                    @error('password')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label custom-label">Número de celular</label>
                    <input type="text" name="phone" id="phone" class="form-control custom-input"
                        value="{{ old('phone', $viewData['user']->getPhone()) }}">

                    @error('phone')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="address" class="form-label custom-label">Dirección</label>
                    <input type="text" name="address" id="address" class="form-control custom-input"
                        value="{{ old('address', $viewData['user']->getAddress()) }}">

                    @error('address')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="role" class="form-label custom-label">Rol</label>
                    <select name="role" id="role" class="form-select custom-input" disabled>
                        <option value="">Seleccione un rol</option>
                        <option value="customer" {{ old('role', $viewData['user']->getRole()) == 'customer' ? 'selected' : '' }}>
                            Cliente
                        </option>
                        <option value="admin" {{ old('role', $viewData['user']->getRole()) == 'admin' ? 'selected' : '' }}>
                            Administrador
                        </option>
                    </select>

                    @error('role')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>

                <button type="submit" class="btn btn-custom-primary">
                    Actualizar usuario
                </button>
            </div>
        </form>
    </div>
@endsection