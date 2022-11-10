<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="description" content="Hệ thống bán BM, Via & Clone VN uy tính">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="{{LOGO_TEXT}} - Hệ thống bán BM, Via & Clone VN uy tín - giá rẻ">
    <meta property="og:description" content="Hệ thống bán BM, Via & Clone VN uy tính">
    {{-- logo web --}}
    <meta property="og:image" content="{{ asset('/images/banner.png') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/fb.png')  }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
    <link rel="stylesheet" id="css-main" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
    <link rel="stylesheet" id="css-theme" href="{{ asset('/css/dashmix.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css" />
    {{-- <link rel="stylesheet" href="{{ asset('/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/context.bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/css/context.standalone.css') }}"/> --}}
    <link rel="stylesheet" href="/css/app.css"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    @yield('head')
</head>
<body>
    <div id="Ads69.net">
            @yield('content');
        </div>
    </div>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>
        <script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('/js/table.js') }}"></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js"></script>
                {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
        @include("Layout.US.script")
        @yield('script')
</body>
</html>