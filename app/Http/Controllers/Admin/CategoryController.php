<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\SaveCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = __('forms.create_category');

        return view('admin.category.create')->with('viewData', $viewData);
    }

    public function save(SaveCategoryRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $category = new Category;
        $category->setName($validatedData['name']);
        $category->setDescription($validatedData['description']);
        $category->save();

        return redirect()
            ->route('product.index')
            ->with('success', __('messages.category_created'));
    }
}
