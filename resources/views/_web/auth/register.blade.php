@extends('_web.layouts.master')

@section('title')

Register

@endsection


@section('content')

    <div class="container">

        <div class="card">

            <div class="card-body">
                <h5 class="card-title">Register</h5>
                <p class="card-text">

                    <form action="{{ route('register.storeUser') }}" class="form-box" method="post">

                        {{ csrf_field() }}

                        <div class="row">
                            <input id="first_name" name="first_name" placeholder="first_name" type="text"
                            class="input-text" required value="{{ old('first_name', 'Test') }}" required autofocus>
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <input id="last_name" name="last_name" placeholder="last_name" type="text"
                            class="input-text" required value="{{ old('last_name', 'User') }}" required>
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="row">
                            <input id="id_number" name="id_number" placeholder="ID No/ Passport No" type="text"
                            class="input-text" required value="{{ old('id_number', '123456778') }}" required>
                            @if ($errors->has('id_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('id_number') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <input id="dob" name="dob" placeholder="Date of birth" onfocus = "(this.type = 'date')"
                            class="input-text" required value="{{ old('dob', '15/7/1999') }}" required>
                            @if ($errors->has('dob'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dob') }}</strong>
                                </span>
                            @endif
                        </div>







                        <div class="row">
                            <input id="email" name="email" placeholder="Email" type="text"
                            class="input-text"  value="{{ old('email', 'test@test.com') }}" required>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <input id="phone" name="phone" placeholder="Phone Number" type="text"
                            class="input-text"  value="{{ old('phone', '254720111222') }}" required>
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <input id="password" name="password" placeholder="Password"
                             type="password" class="input-text"  value="{{ old('password', '123456') }}" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="row">
                            <input id="password_confirmation" name="password_confirmation"
                            placeholder="Confirm Password"  value="{{ old('password_confirmation', '123456') }}"
                            type="password" class="input-text" required>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-checkbox">

                            <input id="terms" type="checkbox" name="terms"
                                    {{ old('terms') ? 'checked' : 'checked' }}>

                            <label for="check">I accept terms and coditions</label>
                        </div>

                        <button class="btn btn-xs" type="submit">Submit</button>

                    </form>

                </p>
            </div>
        </div>

    </div>

@endsection

