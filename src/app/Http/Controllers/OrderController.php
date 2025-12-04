<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Get all orders
    public function index()
    {
        // Use 'latest()->get()' to see newest orders first
        return response()->json(['data' => Order::latest()->get()]);
    }

    // Create a new order
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|integer', // or 'exists:users,id'
            'product' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create($request->all());

        return response()->json([
            'message' => 'Order placed successfully',
            'data' => $order
        ], 201);
    }

    // Get a single order
    public function show($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['data' => $order]);
    }

    // Update an order
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $request->validate([
            'customer_id' => 'integer',
            'product' => 'string|max:255',
            'price' => 'numeric|min:0',
            'quantity' => 'integer|min:1',
        ]);

        $order->update($request->all());

        return response()->json([
            'message' => 'Order updated successfully',
            'data' => $order
        ]);
    }

    // Delete an order
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
    public function salesStats()
    {
        // 1. Calculate Total Revenue (Jersey vs Ticket)
        // Logic: Sum(price * quantity)
        $jerseyRevenue = Order::where('product', 'LIKE', '%Jersey%')
            ->sum(DB::raw('price * quantity'));

        $ticketRevenue = Order::where('product', 'LIKE', '%Ticket%')
            ->sum(DB::raw('price * quantity'));

        $totalRevenue = $jerseyRevenue + $ticketRevenue;

        // 2. Get recent orders for a "Recent Activity" list (Optional but good for dashboards)
        $recentOrders = Order::latest()->take(5)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'jersey_revenue' => $jerseyRevenue,
                'ticket_revenue' => $ticketRevenue,
                'total_revenue' => $totalRevenue,
                'recent_orders' => $recentOrders
            ]
        ]);
    }
}
