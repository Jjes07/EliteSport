<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\SaveProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Home - Products';
        $viewData['products'] = Product::all();
        $viewData['showCleanButton'] = false;
        $viewData['categories'] = Category::all();

        return view('product.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = 'Crear Producto';
        $viewData['categories'] = Category::all();

        return view('product.create')->with('viewData', $viewData);
    }

    public function save(SaveProductRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $product = new Product();
        $product->setName($validatedData['name']);
        $product->setDescription($validatedData['description']);
        $product->setPrice($validatedData['price']);
        $product->setStock($validatedData['stock']);
        $product->setImage($validatedData['image']);
        $product->setCategory($validatedData['category_id']);
        $product->save();

        return redirect()
            ->route('product.index')
            ->with('success', 'Elemento creado satisfactoriamente');
    }

    public function show(int $id): View
    {
        $viewData = [];
        $product = Product::findOrFail($id);

        $viewData['title'] = $product->getName() . ' - Detalle Producto';
        $viewData['product'] = $product;

        return view('product.show')->with('viewData', $viewData);
    }

    public function edit(int $id): View
    {
        $viewData = [];
        $product = Product::findOrFail($id);

        $viewData['title'] = $product->getName() . ' - Editar Producto';
        $viewData['product'] = $product;
        $viewData['categories'] = Category::all();

        return view('product.edit')->with('viewData', $viewData);
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $product = Product::findOrFail($id);

        $product->setName($validatedData['name']);
        $product->setDescription($validatedData['description']);
        $product->setPrice($validatedData['price']);
        $product->setStock($validatedData['stock']);
        $product->setImage($validatedData['image']);
        $product->setCategory($validatedData['category_id']);
        $product->save();

        return redirect()
            ->route('product.show', $product->getId())
            ->with('success', 'Elemento actualizado correctamente');

    }
    public function search(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = 'Buscar Productos';
        $viewData['categories'] = Category::all();

        $searchTerm = $request->input('name', '');
        $categoryId = $request->input('category', null);

        $searchResult = Product::searchByNameAndCategory($searchTerm, $categoryId ? (int) $categoryId : null);

        $viewData = array_merge($viewData, $searchResult);

        return view('product.index')->with('viewData', $viewData);
    }

    public function delete(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('product.index')
            ->with('success', 'Elemento eliminado correctamente');
    }
}
