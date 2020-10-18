<!DOCTYPE html>
<html lang="en">

    <head>
        
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>
            @yield('title') :: {{ config('app.name') }} Admin - Get Your favorite drinks
        </title>

        <meta name="description" content="Barddy Admin Console" />
        <meta name="keywords" content="{{ config('app.name') }}, drinks, offer, beer, spirits, kenya" />

        <meta name="author" content="Nicholas Kute"/>
        
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <link rel="stylesheet" href="{{ asset('_admin/css/app.css?x=7688665') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

        @yield('page_css')

        <script>
            window.Laravel = { csrfToken: '{{ csrf_token() }}'}
        </script>
        
    </head>
    
    <body>
        
        <!-- Preloader -->
        <div class="preloader-it">
           <div class="la-anim-1"></div>
        </div>
        <!-- /Preloader -->


        @yield('css_header')


        @include('_admin.layouts.scriptsHeader')


        <div id="app">

            @yield('main_content')

        </div>
        

        @include('_admin.layouts.scriptsFooter')


        @yield('page_scripts')


        @include('_admin.layouts.partials.error_messages')
        

    </body>

</html>
