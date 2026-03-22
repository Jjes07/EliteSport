<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $total = 0;
        $productsInCart = [];
        $productsInSession = $request->session()->get("products");
        if (!empty($productsInSession)) {
            $productsInCart = Product::findMany(array_keys($productsInSession));
            $total = Product::sumPricesByQuantities($productsInCart, $productsInSession);
        }

        $viewData = [];
        $viewData["title"] = "Cart - Online Store";
        $viewData["subtitle"] = "Shopping Cart";
        $viewData["total"] = $total;
        $viewData["products"] = $productsInCart;

        return view('cart.index')->with("viewData", $viewData);
    }
    public function add(Request $request, int $id): RedirectResponse
    {
        $products = $request->session()->get('products', []);
        $quantity = (int) $request->input('quantity');

        if (isset($products[$id])) {
            $products[$id] += $quantity;
        } else {
            $products[$id] = $quantity;
        }

        $request->session()->put('products', $products);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Producto agregado al carrito correctamente.');
    }
    public function delete(Request $request): RedirectResponse
    {
        $request->session()->forget('products');

        return redirect()
            ->route('cart.index')
            ->with('success', 'Carrito vaciado correctamente');
    }
}