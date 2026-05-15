<?php

namespace App\Utils;

use App\Interfaces\ProductCatalog;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class DatabaseProductCatalogProvider implements ProductCatalog
{
    public function getInStockProducts(): Collection
    {
        return Product::where('stock', '>', 0)->get();
    }

    public function getAllProducts(): Collection
    {
        return Product::all();
    }
}
