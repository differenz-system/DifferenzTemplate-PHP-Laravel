<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class AdminUserController3 extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $data = User::query();
            $data = User::select([
                'ProfilePicture',
                'FirstName',
                'LastName',
                'Email',
                'DeviceType',
                'SocialType',
                'UserId'
            ])->get();

            return Datatables::of($data)
                ->editColumn('ProfilePicture', function ($data) {
                    if ($data->ProfilePicture == '' || $data->ProfilePicture == null) {
                        $image = url('storage/admin/images/profile/user-not-found.png');
                    } else {
                        if (file_exists(storage_path('web/images/profile/' . $data->ProfilePicture))) {
                            $image = url('storage/web/images/profile') . '/' . $data->ProfilePicture;
                        } else {
                            $image = url('storage/admin/images/profile/user-not-found.png');
                        }
                    }
                    return $image;
                })
                ->editColumn('Name', function ($data) {
                    return $data->FirstName . ' ' . $data->LastName;
                })
                ->editColumn('DeviceType', function ($data) {
                    if ($data->DeviceType == 1) return 'IOS';
                    if ($data->DeviceType == 2) return 'Android';
                    if ($data->DeviceType == 3) return 'Website';
                    if ($data->DeviceType == 4) return 'Admin';
                    return 'No User';
                })
                ->editColumn('SocialType', function ($data) {
                    if ($data->SocialType == 1) return 'Facebook';
                    if ($data->SocialType == 2) return 'Google';
                    return 'Normal';
                })
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:void(0)" onclick="DeleteUser(\'' . $data->UserId . '\')"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.user.list');
    }
}
