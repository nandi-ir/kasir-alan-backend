<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_items' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Membuat pesanan baru
        $order = Order::create();

        $requested_products = collect();

        foreach ($request->order_items as $order_item) {
            $product = Product::find($order_item['product_id']);
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            $new_order_item = [
                'product_id' => $order_item['product_id'],
                'quantity' => $order_item['quantity'],
                'order_id' => $order->id,
                'price' => $product->price,
                'subtotal' => $product->price * $order_item['quantity'],
            ];

            $new_order_item = OrderItem::create($new_order_item);
            $requested_products->push($new_order_item);
        }

        $total_price = $requested_products->reduce(fn($carry, $item) => $carry + $item->subtotal, 0);

        // dd(json_encode($total_price, JSON_PRETTY_PRINT));

        $order->total_price = $total_price;
        $order->save();

        // Return pesanan yang berhasil dibuat
        return $order;
    }
}
