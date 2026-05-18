<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /**
     * PAYMENT ATTRIBUTES
     * $this->attributes['id'] - integer - contains the payment primary key (id)
     * $this->attributes['amount'] - integer - contains the payment amount
     * $this->attributes['method'] - string - contains the payment method
     * $this->attributes['status'] - string - contains the payment status
     * $this->attributes['order_id'] - integer - contains the referenced order id
     * $this->attributes['created_at'] - timestamp - contains the payment creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the payment update timestamp
     *
     * PAYMENT RELATIONSHIPS
     * $this->order - BelongsTo - the order associated with this payment
     */
    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'status',
    ];

    /* Getters - Attributes */

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'order_id' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getAmount(): int
    {
        return $this->attributes['amount'];
    }

    public function getMethod(): string
    {
        return $this->attributes['method'];
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function getOrderId(): int
    {
        return $this->attributes['order_id'];
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    /* Getters - Relationships */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /* Formatted Getters */
    public function getAmountFormatted(): string
    {
        return '$'.number_format($this->getAmount(), 0, ',', ' ');
    }

    /* Setters - Attributes */
    public function setOrderId(int $orderId): void
    {
        $this->attributes['order_id'] = $orderId;
    }

    public function setAmount(int $amount): void
    {
        $this->attributes['amount'] = $amount;
    }

    public function setMethod(string $method): void
    {
        $this->attributes['method'] = $method;
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    /* Setters - Relationships */
    public function setOrder(Order $order): void
    {
        $this->order()->associate($order);
    }

    /* Relationships */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /* Query Methods */
    public static function findByOrderId(int $orderId): ?self
    {
        return self::where('order_id', $orderId)->first();
    }
}
