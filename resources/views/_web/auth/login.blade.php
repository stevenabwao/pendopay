@extends('_web.layouts.master')

@section('title')

Login

@endsection


@section('content')

    <div class="container">

        <div class="card">

            <div class="card-body">
                <h5 class="card-title">Login</h5>
                <p class="card-text">

                    <form action="{{ route('login.store') }}" class="form-box" method="post">

                        {{ csrf_field() }}

                        <div class="row">
                            <input id="username" name="username" placeholder="Username" type="text"
                            class="input-text" required value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('username'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('username') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <input id="password" name="password" placeholder="Password" type="password" class="input-text" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-checkbox">

                            <input id="remember" type="checkbox" name="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                            <label for="check">Remember Me</label>
                        </div>
                        <button class="btn btn-xs" type="submit">Submit</button>

                    </form>

                </p>
            </div>
        </div>

    </div>

@endsection

