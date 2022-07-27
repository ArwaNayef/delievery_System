<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function ordersByClient()
    {
        $id = Auth::id();
        return Order::where('user_id', $id)
            ->select(
                [
                    'details',
                    'from_address',
                    'to_address',
                    'time_to_deliver',
                    'status',
                ]
            )->get();
    }
//Add Order
    public function store(Request $request)
    {
        if (Auth::check()) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'details' => $request->details,
                'from_address' => $request->from_address,
                'to_address' => $request->to_address,
                'time_to_deliver' => $request->time_to_deliver]);

        }
    }

//Send this order to at least three drivers
    public function SendOrder()
    {

    }

}
