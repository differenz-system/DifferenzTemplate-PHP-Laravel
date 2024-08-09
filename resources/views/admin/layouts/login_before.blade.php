<!doctype html>
<html lang="en">

<head>
    <title>{{ env('PROJECT_NAME') }} | @yield('title')</title>
    @include('admin.layouts.include.css')

    <style>
        .error {
            display: flex !important;
        }
    </style>

    <script type="text/javascript">
        var base_url = "{{ url('/') }}";
    </script>

    @yield('style')
</head>

<body class="gray-bg">
    @yield('content')
    @include('admin.layouts.include.script')
    @yield('script')
</body>

</html>
