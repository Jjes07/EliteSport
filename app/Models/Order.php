<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    /**
     * ORDER ATTRIBUTES
     * $this->attributes['id'] - integer - contains the order primary key (id)
     * $this->attributes['date'] - date - contains the order date
     * $this->attributes['status'] - string - contains the order status (pending, paid, cancelled)
     * $this->attributes['total'] - float - contains the order total amount
     * $this->attributes['user_id'] - integer - contains the user who placed the order
     * $this->attributes['created_at'] - timestamp - contains the order creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the order update timestamp
     *
     * ORDER RELATIONSHIPS
     * $this->user - BelongsTo - the user who placed the order
     * $this->items - HasMany - the items included in the order
     * $this->payment - HasOne - the payment associated with the order
     */
    protected $fillable = [
        'date',
        'status',
        'total',
        'user_id',
    ];

    /* Getters - Attributes */

    protected function casts(): array
    {
        return [
            'total' => 'float',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

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

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    /* Formatted getters */

    public function getTotalFormatted(): string
    {
        return '$' . number_format($this->getTotal(), 0, ',', ' ');
    }

    /* Setters - Attributes */

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

    /* Getters - Relationships */

    public function getUser(): User
    {
        return $this->user;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    /* Setters - Relationships */

    public function setUser(User $user): void
    {
        $this->user()->associate($user);
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

    /* Business logic */

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
        $order = new self();
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
}

