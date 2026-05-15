<?php

namespace App\Utils;

use App\Interfaces\ProductCatalog;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class FakeProductCatalogProvider implements ProductCatalog
{
    public function getInStockProducts(): Collection
    {
        $fakeData = [
            [
                'id' => 1001,
                'name' => 'Balón de Fútbol Pro',
                'description' => 'Balón oficial de competencia, talla 5.',
                'price' => 85000,
                'stock' => 20,
                'image' => 'https://via.placeholder.com/400x300?text=Balon+Pro',
                'category_id' => 1,
            ],
            [
                'id' => 1002,
                'name' => 'Guantes de Portero Elite',
                'description' => 'Guantes profesionales con agarre superior.',
                'price' => 120000,
                'stock' => 15,
                'image' => 'https://via.placeholder.com/400x300?text=Guantes+Elite',
                'category_id' => 1,
            ],
            [
                'id' => 1003,
                'name' => 'Mancuernas 10 kg',
                'description' => 'Par de mancuernas de goma antideslizante.',
                'price' => 65000,
                'stock' => 30,
                'image' => 'https://via.placeholder.com/400x300?text=Mancuernas',
                'category_id' => 2,
            ],
        ];

        $products = new Collection;

        foreach ($fakeData as $data) {
            $product = new Product;
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setStock($data['stock']);
            $product->setImage($data['image']);
            $product->setCategory($data['category_id']);

            $product->setAttribute('id', $data['id']);

            $products->add($product);
        }

        return $products;
    }

    public function getAllProducts(): Collection
    {
        return $this->getInStockProducts();
    }
}
