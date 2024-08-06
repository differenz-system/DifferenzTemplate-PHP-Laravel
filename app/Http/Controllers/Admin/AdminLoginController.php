<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    public function login()
    {
        return view('/Admin/login');
    }

    public function dologin(Request $request)
    {
        $result = User::where('Role', 2)->where('DeviceType', 4)->where('IsDelete', 0)->first();
        if ($result) {
            if (strtolower($request->email) == strtolower($result->Email)) {
                if (Hash::check($request->password, $result->Password)) {
                    Session::put('AdminId', $result->UserId);
                    Session::put('AdminEmail', $result->Email);
                    Session::put('AdminName', $result->FirstName . ' ' . $result->LastName);

                    return redirect(route('dashboard'));
                } else {
                    $message = 'Invalid Password.';
                }
            } else {
                $message = 'Invalid Email.';
            }
        } else {
            $message = 'Invalid User.';
        }

        Session::flash('message', $message);
        return redirect()->back();
    }

    public function EditProfile()
    {
        $admin = User::where('UserId', Session::get('AdminId'))->first();
        return view('Admin.edit-profile', compact('admin'));
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

                return redirect('admin/profile')->with('change-message', 'Profile photo change successfully');
            } else {
                return back()->withErrors('Failed to upload image.');
            }
        } else {
            return back()->withErrors('No image uploaded.');
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
        User::where('UserId', Session::get('AdminId'))->update([
            'Password' => bcrypt($request->new_password),
            'updated_at'  => now()->format('Y-m-d H:i:s'),
        ]);

        return redirect('admin/profile')->with('change-message', 'Profile updated successfully');
    }

    public function Logout(Request $request)
    {
        Session::flush();
        Cache::flush();

        return redirect('/admin');
    }
}
