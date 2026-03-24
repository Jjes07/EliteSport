<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\SaveCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Mostrar formulario para crear nueva categoría
     *
     * @return View
     */
    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = 'Crear Categoría';

        return view('category.create')->with('viewData', $viewData);
    }


    /**
     * Guardar nueva categoría en la base de datos
     *
     * @param SaveCategoryRequest $request
     * @return RedirectResponse
     */
    public function save(SaveCategoryRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $category = new Category();
        $category->setName($validatedData['name']);
        $category->setDescription($validatedData['description']);
        $category->save();

        return redirect()
            ->route('product.index')
            ->with('success', 'Categoría creada satisfactoriamente');
    }
}
