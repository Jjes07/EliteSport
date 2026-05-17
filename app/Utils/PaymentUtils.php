<?php

namespace App\Utils;

use App\Models\Order;
use App\Models\User;

class PaymentUtils
{
    /**
     * Validate if the payment can be processed for the given order and user
     */
    public static function validate(Order $order, User $user): ?string
    {
        if ($order->getStatus() === 'paid') {
            return __('payment.order_already_paid');
        }

        if ($user->getBudget() < $order->getTotal()) {
            return __('payment.insufficient_balance');
        }

        foreach ($order->getItems() as $item) {
            if ($item->getProduct()->getStock() < $item->getQuantity()) {
                return __('payment.insufficient_stock', ['product' => $item->getProduct()->getName()]);
            }
        }

        return null;
    }
}