<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ProductCatalog
{
    public function getInStockProducts(): Collection;

    public function getAllProducts(): Collection;
}
