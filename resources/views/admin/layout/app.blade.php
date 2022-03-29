<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo-mini.png') }}"/>
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body class="c-app">
<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    @include('admin.layout.navbar')

    @include('admin.layout.header')

    <div class="c-body">
        <main class="c-main">
            @yield('content')
        </main>
    </div>
</div>
<!-- CoreUI and necessary plugins-->
<script>
    var _appUrl = '{!! url('/') !!}';
    var _token = '{!! csrf_token() !!}';
</script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/url.min.js') }}"></script>
<script src="{{ asset('js/laravel-sort.js') }}"></script>
<script src="{{ asset('js/modal-confirm.js') }}"></script>
<script src="{{ asset('js/coreui-pro.bundle.min.js') }}"></script>
<script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
<script src="{{ asset('js/coreui-utils.js') }}"></script>
<script src="{{ asset('js/tooltips.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/menu.js') }}"></script>
@yield('javascript')
@toastr_render
</body>

</html>
