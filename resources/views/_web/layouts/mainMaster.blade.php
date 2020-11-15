<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>
            @yield('title') :: {{ config('app.name') }} - Pay Safely
        </title>

        <meta name="description" content="{{ config('app.name') }}" />
        <meta name="keywords" content="{{ config('app.name') }}, money, transactions, banks, buy cars, kenya" />

        <meta name="author" content="Nikk Kute"/>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ asset('css/bootstrap-grid.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/glide.css') }}">
        <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('css/content-box.css') }}">
        <link rel="stylesheet" href="{{ asset('css/contact-form.css') }}">
        <link rel="stylesheet" href="{{ asset('css/media-box.css') }}">
        <link rel="stylesheet" href="{{ asset('css/skin.css') }}">
        <link rel="stylesheet" href="{{ asset('mycss/jquery.toast.min.css') }}">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="{{ asset('icons/iconsmind/line-icons.min.css') }}">

        @yield('page_css')

        <script>
            window.Laravel = { csrfToken: '{{ csrf_token() }}'}
        </script>

    </head>

    <body>

        <div id="preloader"></div>

        @include('_web.layouts.partials.header')

        @yield('main_content')

        <i class="scroll-top-btn scroll-top show"></i>
        @include('_web.layouts.partials.footer')

        @include('_web.layouts.scriptsFooter')

        @yield('page_scripts')

        @include('_admin.layouts.partials.error_messages')

    </body>

</html>
