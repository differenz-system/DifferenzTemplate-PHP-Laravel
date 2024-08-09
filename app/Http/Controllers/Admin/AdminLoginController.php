<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function login()
    {
        return view('admin.pages.auth.login');
    }

    public function dologin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'code' => 202, 'message' => implode("<br>", $validator->errors()->all())], 202);
        }
        
        $user = User::where('email', $request->email)
            ->where('Role', 2)
            ->where('DeviceType', 4)
            ->where('IsDelete', 0)
            ->first();

        if ($user && Hash::check($request->password, $user->Password)) {
            // dd($user);
            Auth::guard('web')->login($user);

            Session::put('AdminId', $user->UserId);
            Session::put('AdminEmail', $user->Email);
            Session::put('AdminName', $user->FirstName . ' ' . $user->LastName);

            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Logged in successfully.',
                'data' => [],
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 202,
                'message' => 'Invalid credentials',
                'data' => [],
            ], 202);
        }
    }

    public function EditProfile()
    {
        $admin = User::where('UserId', Session::get('AdminId'))->first();
        
        return view('admin.pages.profile.edit', compact('admin'));
    }

    public function UpdateProfileImage(Request $request)
    {
        if ($request->file('file_photo')) {
            $image = $request->file('file_photo');
            $imageName = time() . '.' . $image->extension();
            $upload = $image->storeAs('admin/images/profile_pic', $imageName, 'public');

            if ($upload) {
                $Update = User::where('UserId', Session::get('AdminId'))->update([
                    'ProfilePicture' => $imageName,
                    'updated_at'  => now(),
                ]);

                return redirect(route('profile_page'))->with('status', 'success')->with('message', 'Profile photo changed successfully.');
            } else {
                return redirect(route('profile_page'))->with('status', 'error')->with('message', 'Failed to upload image.');
            }
        } else {
            return redirect(route('profile_page'))->with('status', 'error')->with('message', 'No image uploaded.');
        }
    }

    public function CheckOldPassword(Request $request)
    {
        $user = User::find(Session::get('AdminId'));
        if ($user && Hash::check($request->old_password, $user->Password)) {
            return "true";
        }
        return "false";
    }

    public function ChangePassword(Request $request)
    {
        $user = User::where('UserId', Session::get('AdminId'))->update([
            'Password' => bcrypt($request->new_password),
            'updated_at'  => now()->format('Y-m-d H:i:s'),
        ]);

        if($user){
            return redirect(route('profile_page'))->with('status', 'success')->with('message', 'Password changed successfully.');
        }else{
            return redirect(route('profile_page'))->with('status', 'error')->with('message', 'Failed to change password.');
        }
    }

    public function Logout(Request $request)
    {
        Session::flush();
        Cache::flush();

        return redirect('/admin');
    }
}
