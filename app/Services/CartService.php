<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CartService
{
    /**
     * Add a product to the cart
     */
    public function addToCart(Request $request, int $productId, int $quantity): void
    {
        $products = $request->session()->get('products', []);
        $quantity = (int) $quantity;

        if (isset($products[$productId])) {
            $products[$productId] += $quantity;
        } else {
            $products[$productId] = $quantity;
        }

        $request->session()->put('products', $products);
    }

    /**
     * Remove a specific product from cart
     */
    public function removeFromCart(Request $request, int $productId): void
    {
        $products = $request->session()->get('products', []);

        if (isset($products[$productId])) {
            unset($products[$productId]);
            $request->session()->put('products', $products);
        }
    }

    /**
     * Clear entire cart
     */
    public function clearCart(Request $request): void
    {
        $request->session()->forget('products');
    }

    /**
     * Update product quantity in cart
     */
    public function updateQuantity(Request $request, int $productId, int $quantity): void
    {
        $products = $request->session()->get('products', []);
        $quantity = (int) $quantity;

        if ($quantity > 0) {
            $products[$productId] = $quantity;
        } else {
            unset($products[$productId]);
        }

        $request->session()->put('products', $products);
    }

    /**
     * Get all products in cart
     */
    public function getCartProducts(Request $request): Collection
    {
        $productsInSession = $request->session()->get('products', []);

        return Product::whereIn('id', array_keys($productsInSession))->get();
    }

    /**
     * Get cart total price
     */
    public function getCartTotal(Request $request): int
    {
        $productsInCart = $this->getCartProducts($request);
        $productsInSession = $request->session()->get('products', []);

        if (empty($productsInCart)) {
            return 0;
        }

        return Product::sumPricesByQuantities($productsInCart, $productsInSession);
    }

    /**
     * Get session products array
     */
    public function getSessionProducts(Request $request): array
    {
        return $request->session()->get('products', []);
    }

    /**
     * Check if cart is empty
     */
    public function isCartEmpty(Request $request): bool
    {
        $products = $request->session()->get('products', []);

        return empty($products);
    }
}
