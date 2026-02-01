<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        // List COD orders with pending status
        $orders = Order::where('payment_method', 'cod')
            ->where('payment_status', 'pending')
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'payment_status' => 'required|in:approved,rejected',
        ]);

        $order = Order::with('orderItems')->findOrFail($orderId);

        if ($order->payment_method !== 'cod') {
            return redirect()->back()->with('error', 'Only COD orders can be updated here.');
        }

        if ($request->payment_status === 'approved') {
            // Deduct quantity/stock and update product status
            foreach ($order->orderItems as $orderItem) {
                $item = $orderItem->item; // polymorphic relation

                if ($item) {
                    // Determine quantity field name and status update logic based on model type
                    if ($orderItem->item_type === 'App\Models\Pet') {
                        $item->quantity -= $orderItem->quantity;
                        if ($item->quantity <= 0) {
                            $item->quantity = 0;
                            $item->status = 'Sold Out';
                        }
                    } elseif ($orderItem->item_type === 'App\Models\Accessories') {
                        $item->stock -= $orderItem->quantity;
                        if ($item->stock <= 0) {
                            $item->stock = 0;
                            $item->status = 'Sold Out';
                        }
                    } elseif ($orderItem->item_type === 'App\Models\Food') {
                        $item->stock -= $orderItem->quantity;
                        if ($item->stock <= 0) {
                            $item->stock = 0;
                            $item->status = 'unavailable';
                        }
                    }
                    $item->save();
                }
            }
            $order->payment_status = 'paid';
        } else {
            $order->payment_status = 'rejected';
        }

        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully.');
    }
}
