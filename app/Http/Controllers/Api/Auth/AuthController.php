<?php

namespace App\Http\Controllers\Api\Auth;
use App\Events\DriverRegistered;
use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function CustomerRegister(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=> 'required|min:2||max:100',
            'phone_number' => 'required|numeric|digits:10',
            'email'=> 'required|email|| unique:users',
            'password'=> 'required|min:6||max:100',
        ]);

        if($validator -> fails()){
            return response()-> json([
                'message'=> $validator->errors(),
                'data'=> null,
                'status'=> false,
            ],200);
        }

        $user=User::create([
            'name'=>$request->name,
            'phone_number'=>$request->phone_number,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]
        );
        $token = $user->createToken('auth_token');

        return response()-> json([
            'message'=> 'Registration successfully',
            'data'=> ['token' => $token->plainTextToken, 'user' => $user],
            'status'=> true,
        ],200);
        event(new Registered($user));

    }

public function CustomerLogin(Request $request)
    {
        //تدخيل بيانات خاطئة
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()-> json([
                'message'=> 'Unauthorized',
                'data'=> null,
                'status'=> false,
            ],200);

        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'logged in',
            'data'=>['access_token' => $token, 'token_type' => 'Bearer', 'id'=> $user->id],
            'status'=>true,
        ]);

    }
    public function CustomerLogout(Request $request)
    {

          Auth::logout();
        return response()->json(
            [
                'message' => 'Logged out',
                'data'=>null,
                'status'=>true,
            ],200
        );

    }

    public function DriverRegister(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=> 'required|min:2||max:100',
            'phone_number' => 'required|numeric|digits:10',
            'email'=> 'required|email|| unique:users',
            'password'=> 'required|min:6||max:100',
        ]);

        if($validator -> fails()){
            return response()-> json([
                'message'=> 'validation fails',
                'data'=>$validator->errors(),
                'status'=>false,
            ],200);
        }

        $driver=Driver::create([
                'name'=>$request->name,
                'phone_number'=>$request->phone_number,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]
        );
        event(new DriverRegistered($driver));
        return response()-> json([
            'message'=> 'Registration successfully',
            'data'=> ['user' => $driver],
            'status'=>true
        ],200);

    }

    public function DriverLogin(Request $request)
    {
             $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message'=>[$validator->errors()->all()],
                'data'=>null,
                'status'=>false
            ],200
                );}

        if(auth('driver')->attempt($request->only('phone_number', 'password'))) {

            config(['auth.guards.api.provider' => 'driver']);
            $driver = Driver::where('phone_number', $request['phone_number'])->first();

            $token = $driver->createToken('auth_token')->accessToken;

            return response()->json([
                'message' => 'logged in',
                'data' => ['access_token' => $token, 'token_type' => 'Bearer', 'id' => $driver->id],
                'status' => true,
            ], 200);
        }
        else{
            return response()->json([
                'message'=>'Phone and Password are Wrong.',
                'data'=>null,
                'status'=>false
            ],200
            );
        }
    }


}

