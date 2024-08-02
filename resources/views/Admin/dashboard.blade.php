<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('PROJECT_NAME')}} | Dashboard</title>
    @include('Admin.template.headerlink')
</head>

<body>
    <div id="wrapper">
       {{-- Sidebar goes here --}}
       @include('Admin.template.sidebar')
        <div id="page-wrapper" class="gray-bg">
            {{-- Header goes here --}}
            @include('Admin.template.header')
            <div class="wrapper wrapper-content">
                
                
            </div>
            {{-- Footer goes here --}}
            @include('Admin.template.footer')
        </div>
    </div>
    @include('Admin.template.footerlink')
</body>
</html>
