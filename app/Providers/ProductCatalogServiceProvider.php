<?php

namespace App\Providers;

use App\Interfaces\ProductCatalog;
use App\Utils\DatabaseProductCatalog;
use App\Utils\FakeProductCatalog;
use Illuminate\Support\ServiceProvider;

class ProductCatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductCatalog::class, function () {
            return new FakeProductCatalog;
        });
    }
}
