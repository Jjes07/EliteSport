<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SaveUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('forms.users_list');
        $viewData['users'] = User::all();

        return view('admin.user.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('forms.create_user');

        return view('admin.user.create')->with('viewData', $viewData);
    }

    public function save(SaveUserRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $user = new User;
        $user->setName($validatedData['name']);
        $user->setEmail($validatedData['email']);
        $user->setPassword($validatedData['password']);
        $user->setAddress($validatedData['address']);
        $user->setPhone($validatedData['phone']);

        if (isset($validatedData['role'])) {
            $user->setRole($validatedData['role']);
        }
        $user->save();

        return redirect()
            ->route('user.index')
            ->with('success', __('messages.user_created'));
    }

    public function show(int $id): View
    {
        $viewData = [];
        $user = User::findOrFail($id);
        $viewData['user'] = $user;

        $viewData['title'] = $user->getName() . ' - ' . __('forms.details');
        $viewData['users'] = User::all();

        return view('user.show')->with('viewData', $viewData);
    }

    public function edit(int $id): View
    {
        $viewData = [];
        $user = User::findOrFail($id);
        $viewData['user'] = $user;

        $viewData['title'] = __('forms.edit_user');
        $viewData['users'] = User::all();

        return view('admin.user.edit')->with('viewData', $viewData);
    }

    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $user = User::findOrFail($id);

        $user->setName($validatedData['name']);
        $user->setEmail($validatedData['email']);
        $user->setAddress($validatedData['address']);
        $user->setPhone($validatedData['phone']);

        if (!empty($validatedData['password'])) {
            $user->setPassword($validatedData['password']);
        }

        if (isset($validatedData['role'])) {
            $user->setRole($validatedData['role']);
        }
        $user->save();

        return redirect()
            ->route('user.index')
            ->with('success', __('messages.user_updated'));
    }

    public function delete(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success', __('messages.user_deleted'));
    }
}
