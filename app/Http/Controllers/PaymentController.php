<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Utils\PaymentUtils;

class PaymentController extends Controller
{
    public function create(int $orderId): View
    {
        $order = Order::findOrFail($orderId);

        if ($order->getUserId() !== Auth::id()) {
            abort(403, __('payment.not_authorized_view'));
        }

        $user = Auth::user();
        $budget = $user->getBudget();
        $total = $order->getTotal();

        $viewData = [];
        $viewData['title'] = __('payment.title');
        $viewData['order'] = $order;
        $viewData['items'] = $order->getItems();
        $viewData['total'] = $order->getTotalFormatted();
        $viewData['budget'] = $user->getBudgetFormatted();
        $viewData['insufficient'] = $budget < $total;
        $viewData['remainingAfterPayment'] = $budget - $total;
        $viewData['needAmount'] = $total - $budget;

        return view('payment.create')->with('viewData', $viewData);
    }

    public function save(int $orderId): RedirectResponse
    {
        $order = Order::findOrFail($orderId);

        if ($order->getUserId() !== Auth::id()) {
            abort(403, __('payment.not_authorized'));
        }

        $error = PaymentUtils::validate($order, Auth::user());
        if ($error) {
            return redirect()->route('payment.create', $orderId)->with('error', $error);
        }

        $user = Auth::user();
        $total = $order->getTotal();

        $user->setBudget($user->getBudget() - $total);
        $user->save();

        foreach ($order->getItems() as $item) {
            $product = $item->getProduct();
            $product->setStock($product->getStock() - $item->getQuantity());
            $product->save();
        }

        $payment = new Payment;
        $payment->setOrderId($order->getId());
        $payment->setAmount($total);
        $payment->setMethod('budget');
        $payment->setStatus('completed');
        $payment->save();

        $order->setStatus('paid');
        $order->save();

        return redirect()->route('payment.success', $orderId)
            ->with('success', __('payment.payment_completed'));
    }

    public function success(int $orderId): View
    {
        $order = Order::findOrFail($orderId);

        if ($order->getUserId() !== Auth::id()) {
            abort(403, __('payment.not_authorized_view'));
        }

        $viewData = [];
        $viewData['title'] = __('payment.payment_success');
        $viewData['order'] = $order;
        $viewData['payment'] = Payment::findByOrderId($orderId);
        $viewData['newBudget'] = Auth::user()->getBudgetFormatted();
        $viewData['items'] = $order->getItems();

        return view('payment.success')->with('viewData', $viewData);
    }
}
