<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Str;

class ProfileController extends Controller
{
    public function userinfo($token) {
        return User::where('token',$token)->first();
    }

    public function edit(Request $request) {
        $request->validate([
            "firstname"  =>   "required",
            "lastname"   =>   "required",
            "bio"        =>   "required",
            "facebook"   =>   "required",
            "twitter"    =>   "required",
            "instagram"  =>   "required",
        ],[],[
            "firstname"  =>   "الإسم الشخصي",
            "lastname"   =>   "الإسم العائلي",
            "bio"        =>   "السيرة الذاتية",
            "facebook"   =>   "رابط فيسبوك",
            "twitter"    =>   "رابط تويتر",
            "instagram"  =>   "رابط انستغرام",
        ]);
        

        $userAuth = User::findOrFail($request->user()->id);


        $profileImg = $request->file('image');
        if ($profileImg) {
            $img_new__name = Str::random(30).'.'.$profileImg->getClientOriginalExtension();
            $profileImg->move('images/profile/',$img_new__name);
            $imgDir = $img_new__name;

            if ($userAuth->image != 'avatar.jpg') {
                unlink('images/profile/'.$userAuth->image);
            }
        } else {
            $imgDir = $userAuth->image;
        }

        $userAuth->first_name  =     $request->firstname;
        $userAuth->last_name   =     $request->lastname;
        $userAuth->bio         =     $request->bio;
        $userAuth->facebook    =     $request->facebook;
        $userAuth->twitter     =     $request->twitter;
        $userAuth->instagram   =     $request->instagram;
        $userAuth->image       =     $imgDir;
        $userAuth->save();

        return response()->json([
            'status'   =>    1,
            'result'   =>    "تم تحديث البيانات بنجاح."
        ]);
    }
}
