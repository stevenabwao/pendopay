@extends('admin.layouts.mainMaster')

@section('main_content')
        
    <div class="page-wrapper wrapper pa-0 ma-0 auth-page">

        @include('admin.layouts.partials.errorHeader')

        @yield('content')
           
    </div>

@endsection
