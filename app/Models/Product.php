<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /**
     * PRODUCT ATTRIBUTES 
     * this->attribute['name']
     * this->attribute['description']
     * this->attribute['price']
     * this->attribute['stock']
     * this->attribute['image']
     * this->attribute['category']
     * this->attribute['created_at']
     * this->attribute['updated_at']
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category',
    ];

    // Getters

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

    public function getCategory(): string
    {
        return $this->attributes['category'];
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

    /**
     * Busca productos por nombre y/o categoría
     * Retorna un array con los productos y datos para la vista
     * 
     * @param string|null $name - Nombre del producto (búsqueda parcial)
     * @param string|null $category - Categoría del producto
     * @return array
     */
    public static function searchByNameAndCategory(?string $name = null, ?string $category = null): array
    {
        $showCleanButton = false;
        $message = 'Todos los productos';
        $searchTerm = null;
        $selectedCategory = null;

        if ($name || $category) {
            if (!empty($category) && !empty($name)) {
                $products = self::where('name', 'LIKE', '%' . $name . '%')
                    ->where('category', $category)
                    ->get();
                $message = 'Resultado de busqueda: ' . $name . ' que pertenecen a la categoria:' . $category;
                $searchTerm = $name;
                $selectedCategory = $category;
            } elseif (!empty($category)) {
                $products = self::where('category', $category)->get();
                $message = 'Resultados de búsqueda para la categoria: "' . $category . '"';
                $selectedCategory = $category;
            } elseif (!empty($name)) {
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

    //Relaciones de las clases Product

    // public function category(): BelongsTo
    // {
    //     return $this->belongsTo(Category::class);
    // }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
