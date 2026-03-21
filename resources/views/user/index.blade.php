@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
    <div class="container my-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Lista de Usuarios</h4>

                <a href="{{ route('user.create') }}" class="btn btn-primary">
                    Crear Usuario
                </a>
            </div>

            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($viewData['users']->isEmpty())
                    <div class="alert alert-info mb-0">
                        No hay usuarios registrados.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 80px;">Id</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Dirección</th>
                                    <th scope="col">Número de teléfono</th>
                                    <th scope="col" style="width: 120px;">Rol</th>
                                    <th scope="col" style="width: 260px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($viewData['users'] as $user)
                                    <tr>
                                        <td class="fw-semibold">
                                            {{ $user->getId() }}
                                        </td>

                                        <td class="fw-medium">
                                            {{ $user->getName() }}
                                        </td>

                                        <td>
                                            {{ $user->getEmail() }}
                                        </td>

                                        <td>
                                            {{ $user->getAddress() }}
                                        </td>

                                        <td>
                                            {{ $user->getPhone() }}
                                        </td>

                                        <td>
                                            <span class="badge {{ $user->getRole() === 'admin' ? 'bg-dark' : 'bg-secondary' }}">
                                                {{ $user->getRole() }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center flex-wrap gap-2">
                                                <a href="{{ route('user.show', $user->getId()) }}" class="btn btn-sm btn-primary">
                                                    Detalles
                                                </a>

                                                <a href="{{ route('user.edit', $user->getId()) }}" class="btn btn-sm btn-secondary">
                                                    Editar
                                                </a>

                                                <form action="{{ route('user.delete', $user->getId()) }}" method="POST"
                                                    onsubmit="return confirm('Esta acción eliminará el usuario permanentemente. ¿Deseas continuar?');"
                                                    class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
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