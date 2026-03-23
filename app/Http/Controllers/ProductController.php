<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Home - Products';
        $viewData['products'] = Product::all();
        $viewData['showCleanButton'] = false;
        $viewData['categories'] = Product::select('category')->distinct()->pluck('category');

        return view('product.index')->with('viewData', $viewData);
    }

    public function create(): View
    {
        $viewData = [];
        $viewData['title'] = 'Crear Producto';
        // $viewData['categories'] = Category::all();

        return view('product.create')->with('viewData', $viewData);
    }

    public function save(SaveProductRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $product = new Product;
        $product->setName($validatedData['name']);
        $product->setDescription($validatedData['description']);
        $product->setPrice($validatedData['price']);
        $product->setStock($validatedData['stock']);
        $product->setImage($validatedData['image']);
        $product->setCategory($validatedData['category']);
        $product->save();

        return redirect()
            ->route('product.index')
            ->with('success', 'Elemento creado satisfactoriamente');
    }

    public function show(int $id): View
    {
        $viewData = [];
        $product = Product::findOrFail($id);

        $viewData['title'] = $product->getName().' - Product Details';
        $viewData['product'] = $product;
        $viewData['reviews'] = $product->reviews()->with('user')->latest()->get();
        $viewData['reviewsLimit'] = $product->reviews()->with('user')->latest()->take(3)->get();
        $viewData['userReview'] = Auth::check()
            ? $product->reviews()->where('user_id', Auth::id())->first()
            : null;
        $viewData['totalReviews'] = $product->reviews()->count();

        return view('product.show')->with('viewData', $viewData);
    }

    public function edit(int $id): View
    {
        $viewData = [];
        $product = Product::findOrFail($id);

        $viewData['title'] = $product->getName().'Editar Producto';
        $viewData['product'] = $product;
        // $viewData['categories'] = Category::all();

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
        $product->setCategory($validatedData['category']);
        $product->save();

        return redirect()
            ->route('product.show', $product->getId())
            ->with('success', 'Elemento actualizado correctamente');

    }

    public function search(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = 'Buscar Productos';
        $viewData['categories'] = Product::select('category')->distinct()->pluck('category');

        $searchTerm = $request->input('name', '');
        $category = $request->input('category', '');

        $searchResult = Product::searchByNameAndCategory($searchTerm, $category);

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
