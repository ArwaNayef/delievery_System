<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function ShowProfile()
    {
        $id = Auth::id();
        return User::where('id', $id)
            ->select(
                [
                    'name',
                    'email',
                    'Phone_number',
                ]
            )->get();
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
}
