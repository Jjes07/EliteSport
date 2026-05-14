<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ProductCatalogProviderInterface
{
    public function getInStockProducts(): Collection;
}
