<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Order;

class Payment extends Model
{
    /**
     * PAYMENT ATTRIBUTES
     * $this->attributes['id'] - int - contains the payment primary key (id)
     * $this->attributes['order_id'] - int - contains the referenced order id
     * $this->attributes['amount'] - float - contains the payment amount
     * $this->attributes['method'] - string - contains the payment method
     * $this->attributes['status'] - string - contains the payment status
     * $this->attributes['created_at'] - timestamp - contains the payment creation timestamp
     * $this->attributes['updated_at'] - timestamp - contains the payment update timestamp
     */

    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'status',
    ];

    /* Getters */
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getOrderId(): int
    {
        return $this->attributes['order_id'];
    }

    public function getAmount(): float
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

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    /* Setters */
    public function setOrderId(int $orderId): void
    {
        $this->attributes['order_id'] = $orderId;
    }

    public function setAmount(float $amount): void
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

    /* Relationships */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /* Business Logic */
    public static function processPayment(Order $order, string $method = 'budget'): ?self
    {
        $user = $order->getUser();
        $total = $order->getTotal();

        // Check if user has enough budget
        if ($user->getBudget() < $total) {
            return null;
        }

        // Deduct from user budget
        $user->setBudget($user->getBudget() - $total);
        $user->save();

        // Reduce product stock
        foreach ($order->getItems() as $item) {
            $product = $item->getProduct();
            $product->setStock($product->getStock() - $item->getQuantity());
            $product->save();
        }

        // Create payment record
        $payment = new self();
        $payment->setOrderId($order->getId());
        $payment->setAmount($total);
        $payment->setMethod($method);
        $payment->setStatus('completed');
        $payment->save();

        // Update order status
        $order->setStatus('paid');
        $order->save();

        return $payment;
    }
}