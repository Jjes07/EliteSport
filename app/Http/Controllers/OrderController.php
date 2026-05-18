<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
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
        $viewData['orders'] = Order::getOrdersByUser(Auth::id());

        return view('order.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $viewData = [];
        $order = Order::findOrFail($id);

        if ($order->getUserId() !== Auth::id() && Auth::user()->getRole() !== 'admin') {
            abort(403, __('order.not_authorized_view'));
        }

        $viewData['title'] = __('order.order').' #'.$order->getId();
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

        $order = new Order;
        $order->setUserId(Auth::id());
        $order->setDate(now()->toDateString());
        $order->setStatus('pending');
        $order->setTotal(0);
        $order->save();

        foreach ($cartProducts as $productId => $quantity) {
            $product = Product::findOrFail($productId);

            $item = new Item;
            $item->setQuantity($quantity);
            $item->setPrice($product->getPrice());
            $item->setProductId($productId);
            $item->setOrderId($order->getId());
            $item->save();
        }

        $order->setTotal($order->calculateTotal());
        $order->save();

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

        return InvoiceUtils::generate($order)->download('invoice-'.$order->getId().'.pdf');
    }
}