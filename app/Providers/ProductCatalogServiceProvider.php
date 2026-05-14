<?php

namespace App\Providers;

use App\Contracts\ProductCatalogProviderInterface;
use App\Services\DatabaseProductCatalogProvider;
use Illuminate\Support\ServiceProvider;

class ProductCatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductCatalogProviderInterface::class, function () {
            return new DatabaseProductCatalogProvider();
        });
    }
}
