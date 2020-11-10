@extends('_web.layouts.master')

@section('title')
    Page Not Found
@endsection

@section('page_title')
    Page Not Found
@endsection

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" >

                <hr class="space-sm" />
                <div class="cnt-box cnt-call">
                    <div class="captionz">

                        <div class="row justify-content-center form-title">
                            <h2 class="text-danger" style="padding-bottom: 10px;">Page Not Found</h2>
                        </div>

                        <hr>

                        <div class="row justify-content-center">
                            <a href="{{ route('home') }}" class="btn btn-sm btn-border full-width-sm">Click here to proceed</a>
                        </div>

                    </div>
                </div>
                <hr class="space-sm" />

            </div>
        </div>
    </div>

@endsection
