<?php

namespace App\Providers;

use App\Interfaces\ProductCatalogProviderInterface;
use App\Services\DatabaseProductCatalogProvider;
use Illuminate\Support\ServiceProvider;
use App\Services\FakeProductCatalogProvider;

class ProductCatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductCatalogProviderInterface::class, function () {
            return new DatabaseProductCatalogProvider();
        });
    }
}
