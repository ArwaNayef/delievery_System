<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\driver;
use App\Models\order;
use App\Providers\Ordered;
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
        event(new Ordered($order));
    }
/*
    public function Send($link)
    {
        $details = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp'
        ];

        \Mail::to($link)->send(new \App\Mail\MyTestMail($details));

        dd("Email is Sent.");

    }
//Send this order to at least three drivers
    public function SendOrder()
    {
        $drivers=Driver::where('status', "free")->take(3)->get();
        foreach ($drivers as $driver){
            $this->Send($driver->email);
        }

    }
*/

}
