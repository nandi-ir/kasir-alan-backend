<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MetaResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $order_service;

    public function __construct(OrderService $order_service)
    {
        $this->order_service = $order_service;
    }

    public function index()
    {
        $payments = Order::latest()->get();

        return new MetaResource($payments);
    }

    public function show($id)
    {
        $payment = Order::with(['payment', 'order_items'])->find($id);

        return new MetaResource($payment);
    }

    public function store(Request $request)
    {
        $order = $this->order_service->create_order($request);

        return new MetaResource($order, 'Berhasil membuat pesanan');
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        $payment = Payment::find($id);
        $order_items = OrderItem::where('order_id', $id)->get();

        foreach ($order_items as $order_item) {
            $order_item->delete();
        }

        $payment->delete();
        $order->delete();

        return new MetaResource(null, null, 204);
    }
}
