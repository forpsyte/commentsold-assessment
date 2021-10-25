<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class OrdersController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $filter = Request::only(['search', 'status']);
        return Inertia::render('Orders/Index', [
            'count' => Auth::user()->orders()->filter($filter)->count(),
            'filters' => Request::all(['search', 'status']),
            'orders' => Auth::user()->orders()
                ->filter($filter)
                ->sort(Request::only(['sortBy', 'direction']))
                ->paginate(10)
                ->withQueryString()
                ->through(function($order){
                    return [
                        'id' => $order->id,
                        'customer_name' => $order->name,
                        'email' => $order->email,
                        'product_name' => $order->product->product_name,
                        'color' => $order->inventory->color,
                        'size' => $order->inventory->size,
                        'status' => Str::ucfirst($order->order_status),
                        'total' => number_format(floatval($order->total_cents / 100), 2),
                        'transaction_id' => $order->transaction_id,
                        'carrier' => $order->shipper_name,
                        'tracking_number' => $order->tracking_number,
                        'state' => $order->state
                    ];
                }),
            'sales' => [
                'total' => Auth::user()->getTotalSales($filter),
                'average' => Auth::user()->getAvgSales($filter),
            ],
        ]);
    }
}
