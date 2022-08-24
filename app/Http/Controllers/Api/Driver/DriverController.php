<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function accept(Request $request){
    $id= $request->OrderId;
    $id2 = Auth::guard('driver')->id();
        return Order::where('id', $id)
            ->update(
                [
                    'status'=>'in_progress',
                    'driver_id'=>$id2,
                ]
            );
    }
    public function ignore(){
    }

    public function sendAddresses(Request $request)
    {
        $id= $request->DriverId;
        $orders= Order::select('from_address', 'to_address')->where('driver_id', $id)->get();

        return response()->json([
            'message'=>"Those are the driver addresses",
            'data'=>$orders,
            'status'=>true,
        ], 200
        );

    }
}
