<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /**
     * ATTRIBUTES PRODUCT
     * this->attribute['name']
     * this->attribute['description']
     * this->attribute['price']
     * this->attribute['stock']
     * this->attribute['image']
     * this->attribute['category']
     */

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category',
    ];

    // Getters & Setters

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function getDescription(): string
    {
        return $this->attributes['description'];
    }

    public function setDescription(string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function getPrice(): int
    {
        return $this->attributes['price'];
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function getStock(): int
    {
        return $this->attributes['stock'];
    }

    public function setStock(int $stock): void
    {
        $this->attributes['stock'] = $stock;
    }

    public function getImage(): string
    {
        return $this->attributes['image'];
    }

    public function setImage(string $image): void
    {
        $this->attributes['image'] = $image;
    }

    public function getCategory(): string
    {
        return $this->attributes['category'];
    }

    public function setCategory(string $category): void
    {
        $this->attributes['category'] = $category;
    }

    // Auxiliar methods

    public static function sumPricesByQuantities($products, $productsInSession)
    {
        $total = 0;
        foreach ($products as $product) {
            $total = $total + ($product->getPrice() * $productsInSession[$product->getId()]);
        }
        return $total;
    }

    // Relationships

    // public function category(): BelongsTo
    // {
    //     return $this->belongsTo(Category::class);
    // }

    // public function items(): HasMany
    // {
    //     return $this->hasMany(Item::class);
    // }

    public function reviews(): HasMany
    {
         return $this->hasMany(Review::class);
    }
}
