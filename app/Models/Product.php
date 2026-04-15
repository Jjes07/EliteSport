<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /**
     * PRODUCT ATTRIBUTES
     * $this->attributes['id'] - int - contains the product primary key (id)
     * $this->attributes['name'] - string - contains the product name
     * $this->attributes['description'] - string - contains the product description
     * $this->attributes['price'] - integer - contains the product price
     * $this->attributes['stock'] - integer - contains the product stock quantity
     * $this->attributes['image'] - string - contains the product image URL
     * $this->attributes['category_id'] - integer - contains the referenced category id
     * $this->attributes['created_at'] - timestamp - contains the product creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the product update timestamp
     *
     * PRODUCT RELATIONSHIPS
     * $this->category - BelongsTo - contains the related Category
     * $this->items - HasMany - contains the related Items
     * $this->reviews - HasMany - contains the related Reviews
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category_id',
    ];

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /* Getters */

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function getDescription(): string
    {
        return $this->attributes['description'];
    }

    public function getPrice(): int
    {
        return $this->attributes['price'];
    }

    public function getStock(): int
    {
        return $this->attributes['stock'];
    }

    public function getImage(): string
    {
        return $this->attributes['image'];
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getCategoryId(): ?int
    {
        return $this->attributes['category_id'] ?? null;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    // Formatted Getters
    public function getPriceFormatted(): string
    {
        return '$' . number_format($this->getPrice(), 0, ',', ' ');
    }

    // Setters
    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function setDescription(string $description): void
    {
        $this->attributes['description'] = $description;
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function setStock(int $stock): void
    {
        $this->attributes['stock'] = $stock;
    }

    public function setImage(string $image): void
    {
        $this->attributes['image'] = $image;
    }

    public function setCategory(int $categoryId): void
    {
        $this->attributes['category_id'] = $categoryId;
    }

    // Auxiliary methods

    public static function sumPricesByQuantities($products, $productsInSession)
    {
        $total = 0;
        foreach ($products as $product) {
            $total = $total + ($product->getPrice() * $productsInSession[$product->getId()]);
        }

        return $total;
    }

    public static function searchByNameAndCategory(?string $name = null, ?string $categoryId = null): Collection
    {
        if ($name) {
            return self::where('name', 'LIKE', '%' . $name . '%')->get();
        } elseif ($categoryId) {
            return self::where('category_id', $categoryId)->get();
        }

        return self::all();
    }

    // Relationships

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
