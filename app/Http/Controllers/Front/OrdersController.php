<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use DB;

class OrdersController extends Controller
{
    public function show(Order $order)
    {
        $delivery = $order->delivery()->select([
            'id',
            'order_id',
            'status',
            DB::raw("ST_X(current_location) as lat"),
            DB::raw("ST_Y(current_location) as lng"),
        ])->first();

        return view('front.orders.show', compact('order', 'delivery'));
    }
}
