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
        $token = $user->createToken('authtoken');
        // User::create($request->getAttributes())->sendEmailVerificationNotification();

        return response()-> json([
            'message'=> 'Registration successfully',
            'data'=> ['token' => $token->plainTextToken, 'user' => $user]
        ],200);

}

public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', ]);


    }
    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();

        return response()->json(
            [
                'message' => 'Logged out'
            ]
        );

    }

}

