<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function test_product_has_sufficient_stock(): void
    {
        $product = new Product();
        $product->setStock(10);

        $this->assertTrue($product->getStock() > 0);
        $this->assertFalse($product->getStock() < 0);
    }
}