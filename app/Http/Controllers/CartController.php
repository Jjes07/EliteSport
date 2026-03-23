<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $total = 0;
        $productsInCart = [];
        $productsInSession = $request->session()->get('products');
        if (! empty($productsInSession)) {
            $productsInCart = Product::findMany(array_keys($productsInSession));
            $total = Product::sumPricesByQuantities($productsInCart, $productsInSession);
        }

        $viewData = [];
        $viewData['title'] = 'Cart - Online Store';
        $viewData['subtitle'] = 'Shopping Cart';
        $viewData['total'] = $total;
        $viewData['products'] = $productsInCart;

        return view('cart.index')->with('viewData', $viewData);
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

    /**
     * Remove a specific product from cart
     */
    public function remove(Request $request, int $id): RedirectResponse
    {
        $products = $request->session()->get('products', []);
        
        if (isset($products[$id])) {
            unset($products[$id]);
            $request->session()->put('products', $products);
        }
        
        return redirect()
            ->route('cart.index')
            ->with('success', 'Product removed from cart');
    }
    
    /**
     * Update quantity of a product in cart
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $products = $request->session()->get('products', []);
        $quantity = (int) $request->input('quantity');
    
        $products[$id] = $quantity;
        $request->session()->put('products', $products);
        
        $request->session()->put('products', $products);
        
        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart updated successfully');
    }
    
    /**
     * Checkout - create order and redirect to payment
     */
    public function checkout(Request $request): RedirectResponse
    {
        // Check if cart is empty
        $cartProducts = $request->session()->get('products', []);
        
        if (empty($cartProducts)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty. Add some products before checking out.');
        }
        
        // Delegate to OrderController to create the order
        return redirect()->route()->with();
    }
}
