<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Events\Registered;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=> 'required|min:2||max:100',
            'phone_number' => 'required|numeric|digits:10',
            'email'=> 'required|email|| unique:users',
            'password'=> 'required|min:6||max:100',
        ]);

        if($validator -> fails()){
            return response()-> json([
                'message'=> 'validation fails',
                'errors'=>$validator->errors()
            ],422);   
        }

        $user=User::create([
            'name'=>$request->name,
            'phone_number'=>$request->phone_number,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]
        );
        event(new Registered($user));
       // User::create($request->getAttributes())->sendEmailVerificationNotification();
        
        return response()-> json([
            'message'=> 'Registration successfully',
            'data'=>$user
        ],200);  
    
}

public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
 
    }
}

