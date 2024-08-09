<!doctype html>
<html lang="en">

<head>
    <title>{{ env('PROJECT_NAME') }} | @yield('title')</title>
    @include('admin.layouts.include.css')
    <script type="text/javascript">
        var base_url = "{{ url('/') }}";
    </script>
    @yield('style')
</head>

<body>

    <div id="wrapper">
        @include('admin.layouts.include.sidebar')

        <div class="loader" style="display: none;">
            <span>Loading..</span>
        </div>
        
        <div id="page-wrapper" class="gray-bg">
            @include('admin.layouts.include.header')

            @yield('profile_content')

            <div class="wrapper wrapper-content animated fadeInRight">
                @yield('content')
            </div>

            <div class="footer">
                <div>
                    <strong>Copyright</strong> {{ env('PROJECT_NAME') }} &copy;2024
                </div>
            </div>
        </div>


    </div>

    @include('admin.layouts.include.script')
    @yield('script')

</body>


</html>
