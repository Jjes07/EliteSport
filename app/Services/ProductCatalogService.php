<?php

namespace App\Services;

use App\Interfaces\ProductCatalog;
use Illuminate\Database\Eloquent\Collection;

class ProductCatalogService
{
    public function __construct(
        private readonly ProductCatalog $catalogProvider
    ) {}

    public function getInStock(): Collection
    {
        return $this->catalogProvider->getInStockProducts();
    }
}
