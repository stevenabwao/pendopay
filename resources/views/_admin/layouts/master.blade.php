@extends('_admin.layouts.mainMaster')

@section('main_content') 
        
    <div class="wrapper theme-1-active pimary-color-red">
            
        @include('_admin.layouts.partials.header')

        @include('_admin.layouts.partials.sidebarLeft')

        @include('_admin.layouts.partials.sidebarRight')

        @include('_admin.layouts.partials.settingsRight')

        @include('_admin.layouts.partials.sidebarBackdropRight')

        <div class="page-wrapper">

            @yield('content')

            <!-- Footer -->
            @include('_admin.layouts.partials.footer')
            <!-- /Footer -->

        </div>

    </div>

@endsection
