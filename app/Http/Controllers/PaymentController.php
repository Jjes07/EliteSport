<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        $viewData['insufficient'] = Payment::isInsufficient($budget, $total);
        $viewData['remainingAfterPayment'] = Payment::getRemainingAfterPayment($budget, $total);
        $viewData['needAmount'] = Payment::getNeededAmount($budget, $total);

        return view('payment.create')->with('viewData', $viewData);
    }

    public function save(int $orderId): RedirectResponse
    {
        $order = Order::findOrFail($orderId);

        if ($order->getUserId() !== Auth::id()) {
            abort(403, __('payment.not_authorized'));
        }

        $result = Payment::processPayment($order);

        if (!$result['success']) {
            return redirect()
                ->route('payment.create', $orderId)
                ->with('error', $result['message']);
        }

        return redirect()
            ->route('payment.success', $orderId)
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
        $viewData['payment'] = Payment::where('order_id', $orderId)->first();
        $viewData['newBudget'] = Auth::user()->getBudgetFormatted();
        $viewData['items'] = $order->getItems();

        return view('payment.success')->with('viewData', $viewData);
    }
}
