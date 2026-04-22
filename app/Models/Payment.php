<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /**
     * PAYMENT ATTRIBUTES
     * $this->attributes['id'] - int - contains the payment primary key
     * $this->attributes['amount'] - int - contains the payment amount
     * $this->attributes['method'] - string - contains the payment method
     * $this->attributes['status'] - string - contains the payment status
     * $this->attributes['order_id'] - int - contains the foreign key for order
     * $this->attributes['created_at'] - timestamp - creation timestamp
     * $this->attributes['updated_at'] - timestamp - last update timestamp
     *
     * PAYMENT RELATIONSHIPS
     * $this->order - Order - the order associated with this payment
     */

    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'status',
    ];

    protected $casts = [
        'amount' => 'integer',
        'order_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /* Getters */
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

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    /* Formatted Getters */
    public function getAmountFormatted(): string
    {
        return '$'.number_format($this->getAmount(), 0, ',', ' ');
    }

    /* Setters */
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

    public function setOrder(Order $order): void
    {
        $this->order()->associate($order);
    }

    /* Relationships */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /* Helper methods */
    public static function isInsufficient(int $budget, int $total): bool
    {
        return $budget < $total;
    }

    public static function getRemainingAfterPayment(int $budget, int $total): int
    {
        return $budget - $total;
    }

    public static function getNeededAmount(int $budget, int $total): int
    {
        return $total - $budget;
    }

    /* Business Logic */
    public static function processPayment(Order $order): array
    {
        if ($order->getStatus() === 'paid') {
            return ['success' => false, 'message' => __('payment.order_already_paid')];
        }

        $user = $order->getUser();

        if (! self::hasSufficientBudget($user, $order->getTotal())) {
            return ['success' => false, 'message' => __('payment.insufficient_balance')];
        }

        $stockCheck = self::checkStock($order);
        if (! $stockCheck['success']) {
            return $stockCheck;
        }

        return self::executePayment($order, $user);
    }

    private static function hasSufficientBudget(User $user, int $total): bool
    {
        return $user->getBudget() >= $total;
    }

    private static function checkStock(Order $order): array
    {
        foreach ($order->getItems() as $item) {
            if ($item->getProduct()->getStock() < $item->getQuantity()) {
                return [
                    'success' => false,
                    'message' => __('payment.insufficient_stock', ['product' => $item->getProduct()->getName()]),
                ];
            }
        }
        return ['success' => true];
    }

    private static function executePayment(Order $order, User $user): array
    {
        $total = $order->getTotal();

        $user->setBudget($user->getBudget() - $total);
        $user->save();

        foreach ($order->getItems() as $item) {
            $product = $item->getProduct();
            $product->setStock($product->getStock() - $item->getQuantity());
            $product->save();
        }

        $payment = new self;
        $payment->setOrderId($order->getId());
        $payment->setAmount($total);
        $payment->setMethod('budget');
        $payment->setStatus('completed');
        $payment->save();

        $order->setStatus('paid');
        $order->save();

        return ['success' => true, 'payment' => $payment, 'message' => __('payment.payment_completed')];
    }
}
