<?php

namespace App\Listeners;

use App\Events\DriverRegistered;
use App\Models\Driver;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class emailToDriver
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
     * @param  object  $event
     * @return void
     */
    public function handle(DriverRegistered $event)
    {
        $driver = $event->driver;
        $drivers = Driver::where('id', $driver->id)->take(3)->get();
        foreach ($drivers as $driver) {
            $details = [
                'title' => "Welcome To quicky",
                'body' => "Here is your information to login. Phone Number: " . $driver->phone_number . " and your password is " . $driver->password,
            ];
            \Mail::to($driver->email)->send(new \App\Mail\MyTestMail($details));

        }
    }}
