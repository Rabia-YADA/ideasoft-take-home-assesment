<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('items')->get();
        return response()->json($orders);
    }

    public function store(StoreOrderRequest $request)
    {
        // Check stock
        foreach ($request->items as $item) {
            $product = Product::find($item['productId']);
            if ($product->stock < $item['quantity']) {
                return response()->json([
                    'error' => 'Insufficient stock for product ID: ' . $item['productId'],
                    'available' => $product->stock
                ], 400);
            }
        }

        // Create an order
        $order = Order::create([
            'customer_id' => $request->customerId,
            'total' => 0,
        ]);

        $total = 0;

        // Create order items and update product stock
        foreach ($request->items as $item) {
            $product = Product::find($item['productId']);

            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['productId'],
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'total' => $item['quantity'] * $product->price,
            ]);

            $total += $orderItem->total;

            // Update stock
            $product->stock -= $item['quantity'];
            $product->save();
        }

        // Update total
        $order->total = $total;
        $order->save();

        return response()->json($order->load('items'), 201);
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return response()->json($order);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Restore stock
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            $product->stock += $item->quantity;
            $product->save();
        }

        $order->delete();
        return response()->json(null, 204);
    }
}
