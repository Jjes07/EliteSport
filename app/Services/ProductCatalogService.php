<?php

namespace App\Services;

use App\Interfaces\ProductCatalogProviderInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductCatalogService
{
    public function __construct(
        private readonly ProductCatalogProviderInterface $catalogProvider
    ) {}

   
    public function getInStock(): Collection
    {
        return $this->catalogProvider->getInStockProducts();
    }
}
