<?php

namespace App\Providers;

use App\Models\driver;
use App\Providers\Ordered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrdersToDrivers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\Ordered  $event
     * @return void
     */
    public function handle(Ordered $event)
    {
        $order=$event->order;
        $drivers=Driver::where('status', "free")->take(3)->get();
        foreach ($drivers as $driver){
            $details = [
                'title' => $order->id,
                'body' => "This order which contains ".$order->details ."should be driveler by ". $order->time_to_deliever.
                "to this place ".$order->to_address,
            ];

            \Mail::to($driver->email)->send(new \App\Mail\MyTestMail($details));

        }
    }
}
