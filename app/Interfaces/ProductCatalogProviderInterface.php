<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ProductCatalogProviderInterface
{
    public function getInStockProducts(): Collection;
    // public function getAllProducts(): Collection;
}
