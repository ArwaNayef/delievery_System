<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


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
        return response()->json(['success'=>'Send email successfully.']);

    }

    public function ShowProfile()
    {

        return response()->json(['user'=>Auth::user()]);

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
        return Address::create( [
            'user_id'=>$id,
        'address'=>$request->address,
                ]
        );
    }


}
