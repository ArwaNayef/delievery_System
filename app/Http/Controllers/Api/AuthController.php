<?php

namespace App\Http\Controllers\Api;
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
        $token = $user->createToken('auth_token');

        return response()-> json([
            'message'=> 'Registration successfully',
            'data'=> ['token' => $token->plainTextToken, 'user' => $user]
        ],200);
        event(new Registered($user));

    }

public function CustomerLogin(Request $request)
    {
        //تدخيل بيانات خاطئة
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'Hi '.$user->name.', welcome to home','access_token' => $token, 'token_type' => 'Bearer', 'id'=> $user->id]);


    }
    public function CustomerLogout(Request $request)
    {

        $request->user()->tokens()->delete();

        return response()->json(
            [
                'message' => 'Logged out'
            ]
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
                'errors'=>$validator->errors()
            ],422);
        }

        $driver=Driver::create([
                'name'=>$request->name,
                'phone_number'=>$request->phone_number,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]
        );
        event(new DriverRegistered($driver));
        //event(new Registered($user));
       // $token = $driver->createToken('auth_token');
        // User::create($request->getAttributes())->sendEmailVerificationNotification();
        return response()-> json([
            'message'=> 'Registration successfully',
            'data'=> ['user' => $driver]
        ],200);

    }

    public function DriverLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }
        if(auth('driver')->attempt($request->only('phone_number', 'password'))){

            config(['auth.guards.api.provider' => 'driver']);

            $driver = Driver::find(Auth::id());
            $success =  $driver;
            $success['token'] =  $driver->createToken('MyApp',['driver'])->accessToken;

            return response()->json($success."yes", 200);
        }else{
            return response()->json(['error' => ['Phone and Password are Wrong.']], 200);
        }
    }


}

