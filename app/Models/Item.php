<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    /**
     * ITEM ATTRIBUTES
     * $this->attributes['id'] - int - contains the item primary key (id)
     * $this->attributes['quantity'] - int - contains the item quantity
     * $this->attributes['price'] - int - contains the item price at purchase moment
     * $this->attributes['product_id'] - int - contains the referenced product id
     * $this->attributes['order_id'] - int - contains the referenced order id
     * $this->attributes['created_at'] - timestamp - contains the item creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the item update timestamp
     */
    protected $fillable = [
        'quantity',
        'price',
        'product_id',
        'order_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'integer',
        'product_id' => 'integer',
        'order_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /* Getters */
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getQuantity(): int
    {
        return $this->attributes['quantity'];
    }

    public function getPrice(): int
    {
        return $this->attributes['price'];
    }

    public function getProductId(): int
    {
        return $this->attributes['product_id'];
    }

    public function getOrderId(): ?int
    {
        return $this->attributes['order_id'] ?? null;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    /* Formatted Getters */
    public function getPriceFormatted(): string
    {
        return '$'.number_format($this->getPrice(), 0, ',', ' ');
    }

    public function getSubtotalFormatted(): string
    {
        return '$'.number_format($this->calculateSubtotal(), 0, ',', ' ');
    }

    /* Setters */
    public function setQuantity(int $quantity): void
    {
        $this->attributes['quantity'] = $quantity;
    }

    public function setPrice(int $price): void
    {
        $this->attributes['price'] = $price;
    }

    public function setProductId(int $productId): void
    {
        $this->attributes['product_id'] = $productId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->attributes['order_id'] = $orderId;
    }

    /* Relationships */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /* Business Logic */
    public function calculateSubtotal(): int
    {
        return $this->getQuantity() * $this->getPrice();
    }

    /**
     * Create items from cart session
     */
    public static function createFromCart(int $orderId, array $cartProducts): void
    {
        foreach ($cartProducts as $productId => $quantity) {
            $product = Product::findOrFail($productId);

            $item = new self;
            $item->setQuantity($quantity);
            $item->setPrice($product->getPrice());
            $item->setProductId($productId);
            $item->setOrderId($orderId);
            $item->save();
        }
    }
}
