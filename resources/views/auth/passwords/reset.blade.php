@extends('_web.layouts.authMaster')

@section('title')

Recover Password

@endsection


@section('content')

    <div class="container">

        <div class="row justify-content-center thebg">

            <div class="col-md-7" >

                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <img  class="" src="{{ asset('images/login_icon.png') }}" />
                                <br>
                                <p class="card-text">
                        </div>
                        <div class="row justify-content-center form-title">
                            <h3>Recover Password</h3>
                        </div>

                        {{-- <hr> --}}

                        @if ($error_msg)

                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="alert alert-danger text-center">
                                        {!! $error_msg !!}<br><br>
                                        <a href="{{ route('password.request') }}" class="btn btn-lg btn-danger btn-block">Create New Password Reset Link</a>
                                    </div>
                                </div>
                            </div>

                        @else

                            <form action="{{ route('password.request') }}" method="post" id="passResetForm">

                                {{ csrf_field() }}

                                <p>Please enter your new password below:</p>

                                <input type="hidden" name="token" id="token" value="{{ old('token', $token) }}" class="form-control">

                                <div class="md-form mat-2 mx-auto">
                                    <input type="password" value="{{ old('new_password') }}" name="new_password" id="password">
                                    <label for="new_password">New Password</label>

                                    <span toggle="#password-field" class="fa fa-fw fa-eye"
                                        title="Show/ Hide Password"  id="togglePassword">
                                    </span>

                                    <p id="passwordHelpBlock" class="form-text text-muted text-sm">
                                        <i>{{ getSiteTextPasswordInstructions() }}</i>
                                    </p>

                                    @if ($errors->has('new_password'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('new_password') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="password" name="new_password_confirmation" value="{{ old('new_password_confirmation') }}">
                                    <label for="example">Confirm New New Password</label>
                                    @if ($errors->has('new_password_confirmation'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <hr>

                                <div class="inputs row">
                                    <button class="btn btn-xs" type="submit">Submit</button>
                                </div>

                                <hr>

                                <div class="inputs row">
                                    <div class="col-sm-6">
                                        <a href="{{ route('register') }}" class="reset">Register an Account</a>
                                    </div>
                                    <div class="col-sm-6 float-right">
                                        <a href="{{ route('activate-account') }}" class="reset">Login</a>
                                    </div>
                                </div>
                            </form>

                        @endif

                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

@section('page_scripts')

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script>

    <script src="{{ asset('js/passwords.js') }}"></script>

@endsection

@section('page_css')

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <style>
        .thebg {
            background: url('images/bg.jpg') center no-repeat !important;
            height:100%;width:100%;
        }
    </style>

@endsection

