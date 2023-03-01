<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Str;

class AuthController extends Controller
{

    public function user(Request $request) {
        return $request->user()->only('token','first_name','last_name','image','bio','facebook','twitter','instagram');
    }


    public function register(Request $request) {
        $request->validate([
            'firstname'  =>  "required",
            'lastname'   =>  "required",
            'email'      =>  "required|email|unique:users",
            'password'   =>  "required"
        ],[],[
            'firstname'  =>  "الإسم الشخصي",
            'lastname'   =>  "الإسم العائلي",
            'email'      =>  "البريد الإلكتروني",
            'password'   =>  "كلمة المرور"
        ]);

        User::create([
            "token"      =>   Str::random(5),
            "first_name" =>   $request->firstname,
            "last_name"  =>   $request->lastname,
            "bio"        =>   '',
            "facebook"   =>   '',
            "twitter"    =>   '',
            "instagram"  =>   '',
            "email"      =>   $request->email,
            "password"   =>   Hash::make($request->password),
            "image"      =>   'avatar.jpg',
        ]);

        return response()->json([
            'status'  =>   1,
            'result'  =>   'تم إنشاء الحساب بنجاح.'
        ]);
    }


    public function login(Request $request) {
        $request->validate([
            'email'     =>   "required",
            'password'  =>   "required"
        ],[],[
            'email'      =>  "البريد الإلكتروني",
            'password'   =>  "كلمة المرور"
        ]);

        $data = [
            'email'     =>  $request->email,
            'password'  =>  $request->password
        ];

        if (Auth::attempt($data)) {
            return response()->json([
                'status'   =>    1,
                'result'   =>    "تم تسجيل الدخول بنجاح.",
                'token'    =>    $request->user()->createToken('auth')->plainTextToken
            ]);
        }

        return response()->json([
            'status'   =>    0,
            'result'   =>    "البيانات المدخلة خاطئة."
        ]);
    }


    public function logout(Request $request) {
        auth()->user()->currentAccessToken()->delete();
        return response()->json([
            'status'    =>    1,
            'result'    =>    'تم تسجيل الخروج بنجاح.'
        ]);
    }
}
