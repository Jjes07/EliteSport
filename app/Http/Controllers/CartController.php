<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = 'Cart - Online Store';
        $viewData['subtitle'] = 'Shopping Cart';
        $viewData['total'] = $this->cartService->getCartTotal($request);
        $viewData['products'] = $this->cartService->getCartProducts($request);

        return view('cart.index')->with('viewData', $viewData);
    }

    public function add(Request $request, int $id): RedirectResponse
    {
        $quantity = (int) $request->input('quantity');

        $this->cartService->addToCart($request, $id, $quantity);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Producto agregado al carrito correctamente.');
    }

    public function delete(Request $request): RedirectResponse
    {
        $this->cartService->clearCart($request);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Carrito vaciado correctamente');
    }

    public function remove(Request $request, int $id): RedirectResponse
    {
        $this->cartService->removeFromCart($request, $id);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Producto removido del carrito correctamente');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $quantity = (int) $request->input('quantity');

        $this->cartService->updateQuantity($request, $id, $quantity);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Carrito actualizado');
    }
}
