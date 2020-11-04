@extends('_web.layouts.master')

@section('title')

Register

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
                        <h3>Please Enter Registration Details</h3>
                    </div>

                    <form action="{{ route('register.storeUser') }}" class="form-box" method="post">

                        {{ csrf_field() }}
                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('first_name', 'Shapiro') }}" name="first_name" >
                            <label for="first_name">First Name</label>
                        </div>
                        @if ($errors->has('first_name'))
                            <div class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </div>
                        @endif


                    <div class="md-form mat-2 mx-auto">
                        <input type="text" value="{{ old('last_name', 'King') }}" name="last_name" >
                        <label for="last_name">Last Name</label>
                    </div>
                    @if ($errors->has('last_name'))
                        <div class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </div>
                    @endif


                    <div class="md-form mat-2 mx-auto">
                        <input type="text" value="{{ old('id_number', '23894567') }}" name="id_number" >
                        <label for="id_number">ID No/ Passport No</label>
                    </div>
                    @if ($errors->has('id_number'))
                        <div class="help-block">
                            <strong>{{ $errors->first('id_number') }}</strong>
                        </div>
                    @endif
                    <div class="md-form mat-2 mx-auto">
                        <input type="text" value="{{ old('dob', '08-02-1988') }}"
                            class="form-control datepicker" name="dob">
                        <label class="date" for="dob">Date of Birth</label>
                        <div>
                            @if ($errors->has('dob'))
                                <div class="help-block">
                                    <strong>{{ $errors->first('dob') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="md-form mat-2 mx-auto">
                        <input type="text" id="email" value="{{ old('email', 'antiv_boy_22@yahoo.com') }}" name="email" >
                        <label for="email">Email adress</label>
                    </div>
                    @if ($errors->has('email'))
                        <div class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif

                    <div class="md-form mat-2 mx-auto">
                        <input type="text" id="phone" value="{{ old('phone', '254720743211') }}" name="phone">
                        <label for="phone">Phone Number</label>
                    </div>
                    @if ($errors->has('phone'))
                        <div class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </div>
                    @endif

                    <div class="md-form mat-2 mx-auto">
                        <input type="password" id="password" value="{{ old('password', '123456') }}" name="password" >
                        <label for="password">Password</label>
                    </div>
                    @if ($errors->has('password'))
                        <div class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif

                    <div class="md-form mat-2 mx-auto">
                        <input type="password" id="password_confirmation" value="{{ old('password_confirmation', '123456') }}" name="password_confirmation" class="active" >
                        <label for="password_confirmation">Confirm Password</label>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <div class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </div>
                    @endif

                    <div class="inputs mt-2">
                        <div class="form-checkbox">

                            <input id="terms" type="checkbox" name="terms"
                                    {{ old('terms', 'checked') ? 'checked' : '' }}>

                            <label for="terms">I accept terms and coditions</label>
                        </div>

                    </div>

                    <hr>

                    <div class="inputs row">
                        <button class="btn btn-xs" type="submit">Register</button>
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

@endsection

@section('page_css')

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    {{-- datepicker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">

    <style>

        .datepicker {
            background-color: #fff;
            border: none
        }

        .datepicker-dropdown {
            top: 0;
            left: 0
        }

        .datepicker table tr td.today,
        span.focused {
            border-radius: 50% !important
        }

        thead tr:nth-child(2) {
            background-color: #325B92 !important;
        }

        thead tr:nth-child(3) th {
            color: #325B92 !important;
            padding-top: 20px;
            padding-bottom: 10px
        }

        .dow,
        .old-day,
        .day,
        .new-day {
            width: 40px !important;
            height: 40px !important;
            border-radius: 0px !important
        }

        .old-day:hover,
        .day:hover,
        .new-day:hover,
        .month:hover,
        .year:hover,
        .decade:hover,
        .century:hover {
            border-radius: 50% !important;
            background-color: #eee
        }

        .prev,
        .next,
        .datepicker-switch {
            border-radius: 0 !important;
            padding: 20px 10px !important;
            text-transform: uppercase;
            font-size: 20px;
            color: #fff;
            opacity: 0.8
        }

        .prev:hover,
        .next:hover,
        .datepicker-switch:hover {
            background-color: inherit !important;
            opacity: 1
        }

    </style>

@endsection
