@extends('admin.layouts.login_before')
@section('title', 'Login')
@section('content')
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <img alt="image" src="{{ asset('storage/admin/images/logo/logo.png') }}" style="width: 100%;">
            </div>

            @if (!empty(Session::get('message')))
                <div id ="msgs" class="alert alert-danger">{{ Session::get('message') }}</div>
            @endif
            <form class="m-t" role="form" action="{{ route('do_login') }}" method="POST" id="admin-login-form"
                name="admin-login-form">
                @csrf
                <div class="form-group">
                    <input name="email" id="email" type="email" class="form-control" placeholder="Email Address"
                        required="">
                </div>
                <div class="form-group">
                    <input name="password" id="password" type="password" class="form-control" placeholder="Password"
                        required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            </form>
            <p class="m-t"> <small>{{ env('PROJECT_NAME') }} &copy; 2024</small> </p>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('adminAssets/js/custom/login.js') }}"></script>
@endsection
