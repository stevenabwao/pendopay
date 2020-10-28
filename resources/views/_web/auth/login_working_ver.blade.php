    @extends('_web.layouts.master')

        @section('title')

        Login

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
                                <div class="row justify-content-center">
                                    <h3>Login</h3>
                                </div>

                            <form action="{{ route('login.store') }}" method="post">

                                {{ csrf_field() }}

                                <div class="col-md-12 inputs">
                                    <input id="username" name="username" placeholder="Username" type="text"
                                    class="fadein first" required value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-12 inputs">
                                    <input id="password" name="password" placeholder="Password" type="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-12 inputs">
                                <div class="form-checkbox">

                                    <input id="remember" type="checkbox" name="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                    <label for="check">Remember Me</label>
                                </div>

                            </div>

                                <div class="col-md-12 inputs">
                                  <button class="btn btn-xs" type="submit">Login</button>
                                </div>
                                <div class="col-md-12 inputs">
                                   <a href="#" class="reset">
                                      Forgot Your Password?
                                   </a>
                                </div>
                            </form>

                        </p>
                    </div>
                </div>
                </div>
                </div>

            </div>

        @endsection

