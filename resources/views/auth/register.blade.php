@extends('_web.layouts.master')

@section('title')

Register

@endsection


@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7" >

                <div class="card">

                    <div class="card-body">

                        <div class="row justify-content-center">

                            <img  class="" src="{{ asset('images/login_icon.png') }}" />
                            <br>

                            <p class="card-text">
                            </div>
                            <div class="row justify-content-center form-title">
                                <h3>Please Enter Registration Details</h3>
                            </div>

                            <form action="{{ route('register.storeUser') }}" class="form-box" method="post" id="regForm">

                                {{ csrf_field() }}

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ old('first_name', 'Sean') }}" name="first_name" >
                                    <label for="first_name">First Name</label>
                                    @if ($errors->has('first_name'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ old('last_name', 'Paul') }}" name="last_name" >
                                    <label for="last_name">Last Name</label>
                                    @if ($errors->has('last_name'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ old('id_no', '23894568') }}" name="id_no" >
                                    <label for="id_no">ID No/ Passport No</label>
                                    @if ($errors->has('id_no'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('id_no') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" value="{{ old('dob', '08-02-1998') }}"
                                        class="form-control datepicker" name="dob">
                                    <label class="date" for="dob">Date of Birth</label>
                                    @if ($errors->has('dob'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('dob') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" id="email" value="{{ old('email', 'antiv_boy@yahoo.com') }}" name="email" >
                                    <label for="email">Email adress</label>
                                    @if ($errors->has('email'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="text" id="phone" value="{{ old('phone', '254720743211') }}" name="phone">
                                    <label for="phone">Phone Number</label>
                                    @if ($errors->has('phone'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="password" id="password" value="{{ old('password', '123456#aB') }}" name="password" >
                                    <label for="password">Password</label>

                                    <span toggle="#password-field" class="fa fa-fw fa-eye"
                                        title="Show/ Hide Password" data-toggle="tooltip" id="togglePassword">
                                    </span>

                                    <p id="passwordHelpBlock" class="form-text text-muted text-sm">
                                        <i>{{ getSiteTextPasswordInstructions() }}</i>
                                    </p>

                                    @if ($errors->has('password'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="md-form mat-2 mx-auto">
                                    <input type="password" id="password_confirmation" value="{{ old('password_confirmation', '123456#aB') }}" name="password_confirmation" class="active" >
                                    <label for="password_confirmation">Confirm Password</label>
                                    @if ($errors->has('password_confirmation'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="inputsz mt-2">
                                    <div class="form-checkbox">

                                        <input id="terms" type="checkbox" name="terms"
                                                {{ old('terms') ? 'checked' : '' }}>

                                        <label for="terms">
                                            I accept
                                            <a id="scroll-box-trigger" href="#scroll-box" title="Click to view terms and conditions"
                                                class="lightbox full-width" data-lightbox-anima="fade-in">
                                                terms and conditions
                                            </a>
                                        </label>
                                    </div>

                                    {{-- scrollbox --}}
                                    <div id="scroll-box" class="box-lightbox">
                                        <div class="scroll-box" data-height="400" data-rail-color="#c3dff7" data-bar-color="#379cf4">

                                            <h5 class="modal-title" id="exampleModalLongTitle">
                                                <img  class="" src="{{ asset('images/login_icon.png') }}" height="30"/> &nbsp;&nbsp;
                                                Terms and Conditions
                                            </h5>
                                            <hr>

                                            <p>
                                                {!! $terms_and_conditions !!}
                                            </p>

                                        </div>
                                    </div>
                                    {{-- scrollbox --}}

                                    @if ($errors->has('terms'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('terms') }}</strong>
                                        </div>
                                    @endif

                                </div>

                                <hr>

                                <div class="inputs row">
                                    <button class="btn btn-xs" type="submit">Register</button>
                                </div>

                                <hr>

                                <div class="inputs row">
                                    <div class="col-sm-12 text-center">
                                        <a href="{{ route('login') }}" class="reset">Login</a>
                                    </div>

                                </div>

                            </form>

                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection

@section('page_scripts')

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>

    <script>
        $(document).ready(function(){

            $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true,
            toggleActive: true
            });

        });
    </script>

    <script src="{{ asset('js/passwords.js') }}"></script>
    <script src="{{ asset('js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/slimscroll.min.js') }}"></script>

@endsection

@section('page_css')

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    {{-- datepicker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="{{ asset('css/datepicker_custom.css') }}">

@endsection
