<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\Mail;
use App\Http\Controllers\Api\UserEmail;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::select("*")
            ->paginate(10);

        return view('users', compact('users'));
    }

    /**
     * Write code on Method
     *
     * @return \Illuminate\Http\JsonResponse()
     */
    public function sendEmail(Request $request)
    {
        $users = User::whereIn("id", $request->ids)->get();

        Mail::to($users)->send(new UserEmail());
        return response()->json([
            'message'=>'Send email successfully.',
            'data'=>null,
            'status'=>true],
            200);
    }

    public function ShowProfile()
    {
        return response()->json([
            'message'=>'profile',
            'data'=>Auth::user(),
            'status'=> true]);

    }
    public function EditProfile(Request $request)
    {
        $id = Auth::id();
        return User::where('id', $id)
            ->update(
                [
                    'name'=>$request->name,
                    'phone_number'=>$request->phone_number,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password)
                ]
            );
    }
    public function AddAddress(Request $request)
    {
        $id = Auth::id();

        return response()->json([
            'message'=>'New Address',
            'data'=>['user_id'=>$id,
                'address'=>$request->address],
            'status'=>true],
            200);
    }


}
