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
                            <input type="text" value="{{ old('first_name') }}" name="first_name" >
                            <label for="example">First Name</label>
                        </div>
                        @if ($errors->has('first_name'))
                            <div class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </div>
                        @endif

                        
                    <div class="md-form mat-2 mx-auto">
                        <input type="text" value="{{ old('last_name') }}" name="last_name" >
                        <label for="example">Last Name</label>
                    </div>
                    @if ($errors->has('last_name'))
                        <div class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </div>
                    @endif
        

                    <div class="md-form mat-2 mx-auto">
                        <input type="text" value="{{ old('id_number') }}" name="id_number" >
                        <label for="example">ID No/ Passport No</label>
                    </div>
                    @if ($errors->has('id_number'))
                        <div class="help-block">
                            <strong>{{ $errors->first('id_number') }}</strong>
                        </div>
                    @endif
                    <div class="md-form mat-2 mx-auto">
                        <input type="text" id="dob" value="{{ old('dob') }}" name="dob" onfocus = "(this.type = 'date')">
                        <label for="example">Date of Birth</label>
                    </div>
                    @if ($errors->has('dob'))
                        <div class="help-block">
                            <strong>{{ $errors->first('dob') }}</strong>
                        </div>
                    @endif

                    <div class="md-form mat-2 mx-auto">
                        <input type="text" id="email" value="{{ old('email') }}" name="email" >
                        <label for="example">Email adress</label>
                    </div>
                    @if ($errors->has('email'))
                        <div class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif

                    <div class="md-form mat-2 mx-auto">
                        <input type="text" id="phone" value="{{ old('phone') }}" name="phone">
                        <label for="example">Phone Number</label>
                    </div>
                    @if ($errors->has('phone'))
                        <div class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </div>
                    @endif

                    <div class="md-form mat-2 mx-auto">
                        <input type="text" id="password" value="{{ old('password') }}" name="password" >
                        <label for="example">Password</label>
                    </div>
                    @if ($errors->has('password'))
                        <div class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif

                    <div class="md-form mat-2 mx-auto">
                        <input type="text" id="password_confirmation" value="{{ old('password_confirmation') }}" name="password_confirmation" class="active" onfocus = "(this.type = 'date')">
                        <label for="example">Confirm Password</label>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <div class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </div>
                    @endif

                    <div class="inputs mt-2">
                        <div class="form-checkbox">

                            <input id="remember" type="checkbox" name="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                            <label for="check">I accept terms and coditions</label>
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

@endsection

@section('page_css')


<link rel="stylesheet" href="{{ asset('css/login.css') }}">

@endsection