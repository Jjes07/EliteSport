<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    /**
     * ORDER ATTRIBUTES
     * $this->attributes['id'] - int - contains the order primary key (id)
     * $this->attributes['date'] - date - contains the order date
     * $this->attributes['status'] - string - contains the order status
     * $this->attributes['total'] - float - contains the order total
     * $this->attributes['user_id'] - int - contains the referenced user id
     * $this->attributes['created_at'] - timestamp - contains the order creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the order update timestamp
     */
    protected $fillable = [
        'date',
        'status',
        'total',
        'user_id',
    ];

    /* Getters */
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getDate(): string
    {
        return $this->attributes['date'];
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function getTotal(): float
    {
        return $this->attributes['total'];
    }

    public function getUserId(): int
    {
        return $this->attributes['user_id'];
    }

    /* Formatted Getters */
    public function getTotalFormatted(): string
    {
        return '$' . number_format($this->getTotal(), 0, ',', ' ');
    }

    /* Setters */
    public function setDate(string $date): void
    {
        $this->attributes['date'] = $date;
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    public function setTotal(float $total): void
    {
        $this->attributes['total'] = $total;
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    /* Relationships */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getItems()
    {
        return $this->items;
    }

    /* Business Logic */
    public function calculateTotal(): float
    {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item->calculateSubtotal();
        }
        return $total;
    }

    public static function placeOrder(int $userId, array $cartProducts): self
    {
        $order = new self;
        $order->setUserId($userId);
        $order->setDate(now()->toDateString());
        $order->setStatus('pending');
        $order->setTotal(0);
        $order->save();

        Item::createFromCart($order->getId(), $cartProducts);

        $order->setTotal($order->calculateTotal());
        $order->save();

        return $order;
    }

    public function confirmOrder(): bool
    {
        $payment = Payment::processPayment($this);
        return $payment !== null;
    }
}