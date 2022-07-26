<?php
namespace App\Http\Controllers\Api\ResetPassword;
use App\Http\Controllers\Controller;
use App\Models\ResetCodePassword;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:reset_code_passwords',
            'password' => 'required|min:6',
        ]);

        // find the code
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        /* check if it does not expired: the time is one hour */
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return response(['message' => trans('passwords.code_is_expire')], 200);
        }

        // find user's email
        $user = User::firstWhere('email', $passwordReset->email);

        // update user password
        $user->update(['password'=>Hash::make($request->password)]);

        // delete current code
        $passwordReset->delete();

        return response([
            'message' =>'password has been successfully reset',
            'data'=>null,
            'status'=>true], 200);
    }
}
