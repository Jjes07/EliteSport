<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductCatalog;
use Illuminate\Http\JsonResponse;

class ProductApiController extends Controller
{
    public function inStock(): JsonResponse
    {
        $products = app(ProductCatalog::class)->getInStockProducts();

        $data = $products->map(function ($product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'stock' => $product->getStock(),
                'url' => route('product.show', $product->getId()),
            ];
        });

        return response()->json([
            'status' => 'success',
            'total' => $products->count(),
            'data' => $data,
        ]);
    }
}
