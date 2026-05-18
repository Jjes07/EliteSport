<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

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
        $viewData['title'] = __('cart.cart_title');
        $viewData['subtitle'] = __('cart.checkout_products');
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
            ->with('success', __('cart.product_added'));
    }

    public function delete(Request $request): RedirectResponse
    {
        $this->cartService->clearCart($request);

        return redirect()
            ->route('cart.index')
            ->with('success', __('cart.cart_cleared'));
    }

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

    public function checkout(Request $request): RedirectResponse
    {
        if ($this->cartService->isCartEmpty($request)) {
            return redirect()->route('cart.index')
                ->with('error', __('cart.cart_empty'));
        }

        $cartProducts = $this->cartService->getSessionProducts($request);

        $order = new Order;
        $order->setUserId(Auth::id());
        $order->setDate(now()->toDateString());
        $order->setStatus('pending');
        $order->setTotal(0);
        $order->save();

        foreach ($cartProducts as $productId => $quantity) {
            $product = Product::findOrFail($productId);

            $item = new Item;
            $item->setQuantity($quantity);
            $item->setPrice($product->getPrice());
            $item->setProductId($productId);
            $item->setOrderId($order->getId());
            $item->save();
        }

        $order->setTotal($order->calculateTotal());
        $order->save();

        $this->cartService->clearCart($request);

        return redirect()->route('payment.create', $order->getId())
            ->with('success', __('cart.checkout_successful'));
    }
}
