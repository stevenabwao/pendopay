    @extends('_web.layouts.authMaster')

    @section('title')

    Activate Account

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
                                <h3>Please Activate Your Account</h3>
                            </div>

                            {{-- <hr> --}}

                            <form action="{{ route('activate-account.store') }}" method="post" id="passResetForm">

                                {{ csrf_field() }}

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ old('phone', $phone) }}" name="phone" id="phone">
                                    <label for="phone">Phone</label>
                                    @if ($errors->has('phone'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" name="code" id="code" value="{{ old('code') }}">
                                    <label for="code">Activation Code</label>
                                    @if ($errors->has('code'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('code') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <hr>

                                <div class="inputs row">
                                    <button class="btn btn-xs btn-form" type="submit">Submit</button>
                                </div>

                                <hr>

                                <div class="inputs row">
                                    <div class="col-sm-12 text-center">
                                        <a href="{{ route('resend-activation-code') }}" class="btn-xs btn btn-danger">Resend Activation Code</a>
                                    </div>
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

        {{-- <script src="{{ asset('js/passwords.js') }}"></script> --}}

    @endsection

    @section('page_css')

        <link rel="stylesheet" href="{{ asset('css/login.css') }}">

        {{-- <style>
            .thebg {
                background: url('images/bg.jpg') center no-repeat !important;
                height:100%;width:100%;
            }
        </style> --}}

    @endsection

