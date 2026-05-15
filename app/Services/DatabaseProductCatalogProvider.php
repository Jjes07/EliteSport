<?php

namespace App\Services;

use App\Interfaces\ProductCatalogProviderInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class DatabaseProductCatalogProvider implements ProductCatalogProviderInterface
{
    public function getInStockProducts(): Collection
    {
        return Product::where('stock', '>', 0)->get();
    }
}
