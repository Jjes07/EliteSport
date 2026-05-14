<?php

namespace App\Utils;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDF;

class InvoiceUtils
{
    /**
     * Generate an invoice PDF for a given order
     */
    public static function generate(Order $order): DomPDF
    {
        $viewData = [];
        $viewData['title'] = 'Invoice #' . $order->getId();
        $viewData['order'] = $order;
        $viewData['items'] = $order->getItems();
        $viewData['user'] = $order->getUser();

        return Pdf::loadView('invoice.index', $viewData);
    }
}
