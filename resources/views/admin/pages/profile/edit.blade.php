@extends('admin.layouts.login_after')
@section('title', 'Profile')

@section('style')
    <link href="{{ asset('adminAssets/css/cropImage/profile-croppie.css') }}" rel="stylesheet">
@endsection

@section('profile_content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Edit Profile</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Profile</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Profile Detail</h5>
                </div>
                <div>
                    <form action="{{ route('updateprofileimage') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label class="cabinet center-block">
                                <figure>
                                    @php
                                        $defaultImage = 'storage/admin/images/profile_pic/user-not-found.png';
                                        $profileImagePath =
                                            'storage/admin/images/profile_pic/' . $admin->ProfilePicture;
                                        $Image = file_exists(public_path($profileImagePath))
                                            ? asset($profileImagePath)
                                            : asset($defaultImage);
                                    @endphp
                                    <img src="{{ $Image }}" class="gambar img-responsive img-thumbnail"
                                        id="item-img-output" name="item-img-output">
                                    <input type="hidden" name="image1" id="image1">
                                </figure>
                                <input type="file" class="item-img file center-block" name="file_photo" required="" />
                            </label>
                            <div class="text-center profile-widget-social">
                                <input type="submit" name="submit" value="Upload Image" class="btn btn-primary"
                                    id="uploadbtnImage" disabled>
                            </div>
                        </div>
                        <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="upload-demo" class="center-block"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Change Password</h5>
                </div>
                <div class="ibox-content">
                    <form id="admin-change-password" name="admin-change-password" action="{{ route('changepassword') }}"
                        method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Old password:</label>
                            <input placeholder="Enter Password" type="password" class="form-control" id="old_password"
                                name="old_password">
                        </div>

                        <div class="form-group">
                            <label>New password:</label>
                            <input placeholder="Enter New Password" type="password" class="form-control" id="new_password"
                                name="new_password">
                        </div>

                        <div class="form-group">
                            <label>Confirm password:</label>
                            <input placeholder="Enter Confirm Password" type="password" class="form-control"
                                id="confirm_password" name="confirm_password">
                        </div>
                        <div class="profile-wall-action">
                            <div class="wall-action-right">
                                <button type="submit" class="btn btn-primary" id="chnge-submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var notificationMessage = "{{ session('message') }}";
        var notificationStatus = "{{ session('status') }}";
    </script>

    <script src="{{ asset('adminAssets/js/cropImage/profile-croppie.js') }}"></script>
    <script src="{{ asset('adminAssets/js/custom/profile.js') }}"></script>
@endsection
