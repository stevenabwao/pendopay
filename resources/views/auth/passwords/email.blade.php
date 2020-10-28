@extends('_web.layouts.authMaster')

@section('title')

Forgot Password

@endsection


@section('content')

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-6" >
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <img  class="" src="{{ asset('images/login_icon.png') }}" />
                              <br>
                              <p class="card-text">
                        </div>
                        <div class="row justify-content-center form-title">
                            <h3>Forgot Password</h3>
                        </div>

                        {{-- <hr> --}}

                        <form action="{{ route('password.email') }}" method="post">

                            {{ csrf_field() }}

                            <div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ old('email') }}" name="email" class="form-control">
                                    <label for="example">Enter Email Address</label>
                                </div>
                                @if ($errors->has('email'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif

                            </div>

                            <hr>

                            <div class="inputs row">
                                <button class="btn btn-xs" type="submit">Submit</button>
                            </div>
                            <div class="col-sm-12z inputs row">
                                <div class="col-sm-6">
                                    <a href="{{ route('register') }}" class="reset">Register an Account</a>
                                </div>
                                <div class="col-sm-6 float-right">
                                    <a href="{{ route('login') }}" class="reset">Login</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('page_scripts')

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script>

@endsection

@section('page_css')

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

@endsection


