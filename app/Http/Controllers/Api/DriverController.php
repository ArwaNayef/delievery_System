<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}
