    @extends('_web.layouts.authMaster')

    @section('title')

    Login

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
                                <h3>Please Login</h3>
                            </div>

                            {{-- <hr> --}}

                            <form action="{{ route('login.store') }}" method="post" id="loginForm">

                                {{ csrf_field() }}

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ old('username', 'antiv_boy@yahoo.com') }}"
                                        name="username" id="username">
                                    <label for="username">Phone/ Email</label>
                                    @if ($errors->has('username'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="password" name="password" id="password"
                                        value="{{ old('password', '123456#aB') }}">
                                    <label for="password">Password</label>

                                    <span toggle="#password-field" class="fa fa-fw fa-eye"
                                        title="Show/ Hide Password" data-toggle="tooltip" id="togglePassword">
                                    </span>

                                    @if ($errors->has('password'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="inputs mt-2">
                                    <div class="form-checkbox">

                                        <input id="remember" type="checkbox" name="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                        <label for="check">Remember Me</label>
                                    </div>

                                </div>

                                <hr>

                                <div class="inputs row">
                                    <button class="btn btn-xs" type="submit">Login</button>
                                </div>

                                <hr>

                                <div class="inputs row">
                                    <div class="col-sm-4">
                                        <a href="{{ route('register') }}" class="reset">Register an Account</a>
                                    </div>
                                    <div class="col-sm-4">
                                        <a href="{{ route('password.request') }}" class="reset">Forgot Your Password?</a>
                                    </div>
                                    <div class="col-sm-4 float-right">
                                        <a href="{{ route('activate-account') }}" class="reset">Activate Account</a>
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

