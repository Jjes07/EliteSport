@extends('layouts.admin')

@section('title', $viewData['title'])

@section('content')
    <div class="admin-content">
        <div class="admin-card">
            <div class="admin-card-header d-flex justify-content-between align-items-center">
                <h5>{{ __('forms.users_list') }}</h5>

                <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-person-plus"></i> {{ __('forms.create_user') }}
                </a>
            </div>

            <div class="admin-card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($viewData['users']->isEmpty())
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> {{ __('forms.no_users_registered') }}
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 60px;">ID</th>
                                    <th scope="col">{{ __('forms.name') }}</th>
                                    <th scope="col">{{ __('forms.email') }}</th>
                                    <th scope="col">{{ __('forms.address') }}</th>
                                    <th scope="col">{{ __('forms.phone') }}</th>
                                    <th scope="col" style="width: 100px;">{{ __('forms.role') }}</th>
                                    <th scope="col" style="width: 200px;">{{ __('forms.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($viewData['users'] as $user)
                                    <tr>
                                        <td class="fw-semibold">{{ $user->getId() }}</td>
                                        <td class="fw-medium">{{ $user->getName() }}</td>
                                        <td><small>{{ $user->getEmail() }}</small></td>
                                        <td><small>{{ $user->getAddress() }}</small></td>
                                        <td><small>{{ $user->getPhone() }}</small></td>
                                        <td>
                                            <span class="badge {{ $user->getRole() === 'admin' ? 'bg-danger' : 'bg-info' }}">
                                                {{ $user->getRole() }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start flex-wrap gap-2">
                                                <a href="{{ route('user.edit', $user->getId()) }}" class="btn btn-warning btn-sm"
                                                    title="Editar">
                                                    <i class="bi bi-pencil"></i> {{ __('forms.edit') }}
                                                </a>

                                                <form action="{{ route('user.delete', $user->getId()) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('{{ __('forms.confirm_delete_user') }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                        <i class="bi bi-trash"></i> {{ __('forms.delete') }}
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