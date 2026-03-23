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
     * this->attribute['category_id']
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category_id',
    ];

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

    public function getCategory(): ?string
    {
        return $this->category?->getName();
    }

    public function getCategoryId(): ?int
    {
        return $this->attributes['category_id'] ?? null;
    }

    public function setCategory(int $categoryId): void
    {
        $this->attributes['category_id'] = $categoryId;
    }
    public static function sumPricesByQuantities($products, $productsInSession)
    {
        $total = 0;
        foreach ($products as $product) {
            $total = $total + ($product->getPrice() * $productsInSession[$product->getId()]);
        }
        return $total;
    }
    public static function searchByNameAndCategory(?string $name = null, ?string $categoryId = null): array
    {
        $showCleanButton = false;
        $message = 'Todos los productos';
        $searchTerm = null;
        $selectedCategory = null;

        if ($name || $categoryId) {
            $query = self::query();

            if (!empty($name)) {
                $query->where('name', 'LIKE', '%' . $name . '%');
                $searchTerm = $name;
            } elseif (!empty($categoryId)) {
                $query->where('category_id', $categoryId);
                $selectedCategory = $categoryId;
            }

            $products = $query->get();
            $message = 'Resultado de búsqueda';
            $selectedCategory = $categoryId;
            if (!empty($name)) {
                $products = self::where('name', 'LIKE', '%' . $name . '%')->get();
                $message = 'Resultados de búsqueda para: "' . $name . '"';
                $searchTerm = $name;
            }
            $showCleanButton = true;
        } else {
            $products = self::all();
        }

        return [
            'products' => $products,
            'message' => $message,
            'searchTerm' => $searchTerm,
            'selectedCategory' => $selectedCategory,
            'showCleanButton' => $showCleanButton
        ];
    }

    //Relations

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // public function items(): HasMany
    // {
    //     return $this->hasMany(Item::class);
    // }

    // public function review(): HasMany
    // {
    //     return $this->hasMany(Review::class);
    // }
}
