<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
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

        $product = new Product();
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

        $viewData['title'] = $product->getName() . ' - Detalle Producto';
        $viewData['product'] = $product;

        return view('product.show')->with('viewData', $viewData);
    }

    public function edit(int $id): View
    {
        $viewData = [];
        $product = Product::findOrFail($id);

        $viewData['title'] = $product->getName() . 'Editar Producto';
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

        $searchTerm = $request->input('name', '');
        $category = $request->input('category', '');
        $viewData['showCleanButton'] = false;
        // $viewData['categories'] = Category::all();
        $viewData['categories'] = Product::select('category')->distinct()->pluck('category');

        if ($searchTerm || $category) {

            if (!empty($category) && !empty($searchTerm)) {
                $viewData['products'] = Product::where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->where('category', $category)
                    ->get();
                $viewData['message'] = 'Resultado de busqueda: ' . $searchTerm . ' que pertenecen a la categoria:' . $category;
                $viewData['searchTerm'] = $searchTerm;
                $viewData['selectedCategory'] = $category;
            } elseif (!empty($category)) {
                $viewData['products'] = Product::where('category', $category)->get();
                $viewData['message'] = 'Resultados de búsqueda para la categoria: "' . $category . '"';
                $viewData['selectedCategory'] = $category;
            } elseif (!empty($searchTerm)) {
                $viewData['products'] = Product::where('name', 'LIKE', '%' . $searchTerm . '%')->get();
                $viewData['message'] = 'Resultados de búsqueda para: "' . $searchTerm . '"';
                $viewData['searchTerm'] = $searchTerm;
            }
            $viewData['showCleanButton'] = true;
        } else {
            $viewData['products'] = Product::all();
            $viewData['message'] = 'Todos los productos';
        }

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
