<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Utils\InvoiceUtils;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('order.my_orders');
        $viewData['orders'] = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('order.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $viewData = [];
        $order = Order::findOrFail($id);

        if ($order->getUserId() !== Auth::id() && Auth::user()->getRole() !== 'admin') {
            abort(403, __('order.not_authorized_view'));
        }

        $viewData['title'] = __('order.order') . ' #' . $order->getId();
        $viewData['order'] = $order;
        $viewData['items'] = $order->getItems();
        $viewData['payment'] = $order->getPayment();

        return view('order.show')->with('viewData', $viewData);
    }

    public function save(Request $request): RedirectResponse
    {
        $cartProducts = $request->session()->get('products', []);

        if (empty($cartProducts)) {
            return redirect()
                ->route('cart.index')
                ->with('error', __('cart.empty_cart_message'));
        }

        $order = Order::placeOrder(Auth::id(), $cartProducts);
        $request->session()->forget('products');

        return redirect()
            ->route('order.show', $order->getId())
            ->with('success', __('order.created_success'));
    }

    public function cancel(int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        if ($order->getUserId() !== Auth::id()) {
            abort(403, __('order.not_authorized_cancel'));
        }

        if ($order->getStatus() !== 'pending') {
            return redirect()
                ->route('order.show', $id)
                ->with('error', __('order.cannot_cancel'));
        }

        $order->setStatus('cancelled');
        $order->save();

        return redirect()
            ->route('order.show', $id)
            ->with('success', __('order.cancelled_success'));
    }

    public function downloadInvoice(int $id): Response
    {
        $order = Order::findOrFail($id);
        return InvoiceUtils::generate($order)->download('invoice-' . $order->getId() . '.pdf');
    }
}
