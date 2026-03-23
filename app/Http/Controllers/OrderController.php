<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Mis Ordenes';
        $viewData['orders'] = Order::where('user_id', Auth::id())->get();

        return view('order.index')->with('viewData', $viewData);
    }

    public function show(int $id): View
    {
        $viewData = [];
        $order = Order::findOrFail($id);

        $viewData['title'] = 'Orden #'.$order->getId();
        $viewData['order'] = $order;
        $viewData['items'] = $order->getItems();

        return view('order.show')->with('viewData', $viewData);
    }

    public function store(Request $request): RedirectResponse
    {
        $cartProducts = $request->session()->get('products', []);

        if (empty($cartProducts)) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'El carrito está vacío');
        }

        $order = Order::placeOrder(Auth::id(), $cartProducts);
        $request->session()->forget('products');

        return redirect()
            ->route('order.show', $order->getId())
            ->with('success', 'Orden creada correctamente');
    }

    public function confirm(int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);
        $success = $order->confirmOrder();

        if ($success) {
            return redirect()
                ->route('order.show', $id)
                ->with('success', 'Pago realizado correctamente');
        }

        return redirect()
            ->route('order.show', $id)
            ->with('error', 'Saldo insuficiente para completar la orden');
    }
}