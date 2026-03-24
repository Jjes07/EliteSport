<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /**
     * ATTRIBUTES CATEGORY
     * this->attribute['name']
     * this->attribute['description']
     * this->attribute['created_at']
     * this->attribute['updated_at']
     */
    protected $fillable = [
        'name',
        'description',
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

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    /* Setters */

    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    public function setDescription(string $description): void
    {
        $this->attributes['description'] = $description;
    }

    /* Relationship: One category has many products */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
