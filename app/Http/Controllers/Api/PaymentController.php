<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MetaResource;
use App\Models\Order;
use App\Models\Payment;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public $order_service;

    public function __construct(OrderService $order_service)
    {
        $this->order_service = $order_service;
    }

    public function index()
    {
        $payments = Payment::latest()->get();

        return new MetaResource($payments);
    }

    public function show($id)
    {
        $payment = Payment::with(['order'])->find($id);

        if (is_null($payment)) {
            return response()->json([
                'status' => false,
                'message' => 'order not found'
            ]);
        }

        return new MetaResource($payment);
    }

    // Controller
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount_paid' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $order_id = $request->order_id;
        $order = null;

        // Jika order_id tidak ada, buat pesanan baru
        if (is_null($order_id)) {
            $order = $this->order_service->create_order($request);

            // Return error json
            if ($order instanceof \Illuminate\Http\JsonResponse) {
                return $order;
            }

            // Mengambil order_id dari pesanan yang baru dibuat
            $order_id = $order->id;
        }

        // Update status pesanan menjadi "paid"
        $updating_order = Order::find($order_id);
        if ($updating_order) {
            $updating_order->status = 'paid';
            $updating_order->save();
        } else {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $new_payment = Payment::create([
            ...$request->all(),
            'change_due' => $updating_order->total_price - $request->amount_paid,
            'order_id' => $order_id,
        ]);

        $response = [
            ...$new_payment->toArray(),
            'order' => $updating_order
        ];

        // Return MetaResource untuk respons sukses
        return new MetaResource($response, 'Berhasil tambahkan data');
    }
}
