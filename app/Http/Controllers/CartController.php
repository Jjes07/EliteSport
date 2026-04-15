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

    /**
     * Display shopping cart with products
     */
    public function index(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = __('cart.cart_title');
        $viewData['subtitle'] = __('cart.checkout_products');
        $viewData['total'] = $this->cartService->getCartTotal($request);
        $viewData['products'] = $this->cartService->getCartProducts($request);

        return view('cart.index')->with('viewData', $viewData);
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, int $id): RedirectResponse
    {
        $quantity = (int) $request->input('quantity');

        $this->cartService->addToCart($request, $id, $quantity);

        return redirect()
            ->route('cart.index')
            ->with('success', __('cart.product_added'));
    }

    /**
     * Clear entire cart
     */
    public function delete(Request $request): RedirectResponse
    {
        $this->cartService->clearCart($request);

        return redirect()
            ->route('cart.index')
            ->with('success', __('cart.cart_cleared'));
    }

    /**
     * Remove specific product from cart
     */
    public function remove(Request $request, int $id): RedirectResponse
    {
        $this->cartService->removeFromCart($request, $id);

        return redirect()
            ->route('cart.index')
            ->with('success', __('cart.product_removed'));
    }

    /**
     * Update product quantity in cart
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $quantity = (int) $request->input('quantity');

        $this->cartService->updateQuantity($request, $id, $quantity);

        return redirect()
            ->route('cart.index')
            ->with('success', __('cart.cart_updated'));
    }

    /**
     * Proceed to checkout
     */
    public function checkout(Request $request): RedirectResponse
    {
        // TODO: Implement checkout logic

        return redirect()
            ->route('home.index')
            ->with('success', __('cart.checkout_successful'));
    }
}

