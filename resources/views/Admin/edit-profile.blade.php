<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('PROJECT_NAME')}} | Profile</title>
    @include('Admin.template.headerlink')
    <link href="{{asset('adminAssets/css/cropImage/profile-croppie.css')}}" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
       {{-- Sidebar goes here --}}
       @include('Admin.template.sidebar')
        <div id="page-wrapper" class="gray-bg">
            {{-- Header goes here --}}
            @include('Admin.template.header')
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>Edit Profile</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                        <a href="{{route('dashboard')}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Profile</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Profile Detail</h5>
                            </div>
                            <div>
                                <form action="{{ route('updateprofileimage') }}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label class="cabinet center-block">
                                            <figure>
                                                @if($admin->ProfilePicture == '' || $admin->ProfilePicture == null)
                                                    @php $Image = asset('storage/admin/images/profile/user-not-found.png') @endphp
                                                @else
                                                    @if(file_exists(storage_path('admin/images/profile/'.$admin->ProfilePicture)))
                                                        @php $Image = asset('storage/admin/images/profile').'/'.$admin->ProfilePicture @endphp
                                                    @else
                                                        @php $Image = asset('storage/admin/images/profile/user-not-found.png') @endphp
                                                    @endif
                                                @endif  
                                                <img src="{{$Image}}"  class="gambar img-responsive img-thumbnail" id="item-img-output" name="item-img-output">
                                                 <input type="hidden" name="image1" id="image1">
                                            </figure>
                                            <input type="file" class="item-img file center-block" name="file_photo"  required=""/>
                                        </label>
                                        <div class="text-center profile-widget-social">
                                            <input type="submit" name="submit" value="Upload Image" class="btn btn-primary" id="uploadbtnImage" disabled>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                                <form id="admin-change-password" name="admin-change-password" action="{{ route('changepassword') }}" method="POST">
                                    @csrf
                                    <div class="profile-wall-textbox">
                                        @if(Session::has('change-message'))
                                            <p id="msgs" class="alert alert-success">{{ Session::get('change-message') }}</p>
                                        @endif 
                                    </div>
                                    <div class="form-group">
                                        <label>Old  password:</label>
                                        <input placeholder="Enter Password" type="password" class="form-control" id="old_password" name="old_password">
                                    </div>

                                    <div class="form-group">
                                        <label>New  password:</label>
                                        <input placeholder="Enter New Password" type="password" class="form-control" id="new_password" name="new_password">
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm  password:</label>
                                        <input placeholder="Enter Confirm Password" type="password" class="form-control" id="confirm_password" name="confirm_password">
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
            </div>
            {{-- Footer goes here --}}
            @include('Admin.template.footer')
        </div>
    </div>
    @include('Admin.template.footerlink')
    <script src="{{asset('adminAssets/js/cropImage/profile-croppie.js')}}"></script>
    <script>
    $(document).ready(function ()
    {
        // chnage password form validation
        $('#admin-change-password').validate({ // initialize the plugin
            rules: {
                old_password: {
                    required: true,
                    remote: {
                        url: "{{url('admin/checkoldpassword')}}",
                        type: 'post',
                        data: {
                            _token: '{{csrf_token()}}',
                        }
                    }
                },
                new_password: {
                    required: true,
                    minlength:6,
                    maxlength:20,
                    notEqual: "#old_password",
                    
                },
                confirm_password: {
                    required: true,
                    minlength:6,
                    maxlength:20,
                    equalTo: "#new_password",
                }
            },
            messages: {
                old_password: {
                    required: "Old password is required.",
                    remote: "Current password does not match."
                },
                new_password: {
                    required: "New password is required.",
                    minlength: "Password cannot less than 6 characters",
                    maxlength: "Password cannot greater than 20 characters",
                },
                confirm_password: {
                    required: "Confirm password is required.",
                    minlength: "Confim password cannot less than 6 characters",
                    maxlength: "Confim password cannot greater than 20 characters",
                    equalTo: "Confim password and new password should be same.",
                }
            }
        });
    });    
    </script>
</body>
</html>
