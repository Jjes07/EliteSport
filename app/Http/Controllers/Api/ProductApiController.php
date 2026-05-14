<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductCatalogService;
use Illuminate\Http\JsonResponse;

class ProductApiController extends Controller
{
    public function __construct(
        private readonly ProductCatalogService $productCatalogService
    ) {
    }

    public function inStock(): JsonResponse
    {
        $products = $this->productCatalogService->getInStock();

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
            'total'  => $products->count(),
            'data'   => $data,
        ]);
    }
}
