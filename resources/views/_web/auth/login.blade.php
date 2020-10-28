    @extends('_web.layouts.authMaster')

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
                                <div class="row justify-content-center form-title">
                                    <h3>Please Login</h3>
                                </div>

                                {{-- <hr> --}}

                                <form action="{{ route('login.store') }}" method="post">

                                    {{ csrf_field() }}

                                    <div>

                                        <div class="md-form mat-2 mx-auto">
                                            <input type="text" value="{{ old('username') }}" name="username" class="form-control">
                                            <label for="example">Phone/ Email</label>
                                        </div>
                                        @if ($errors->has('username'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </div>
                                        @endif

                                    </div>
                                    <div>

                                        <div class="md-form mat-2 mx-auto">
                                            <input type="password" name="password" value="{{ old('password') }}" class="form-control">
                                            <label for="example">Password</label>
                                        </div>
                                        @if ($errors->has('password'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="col-md-12z inputs mt-2">
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
                                    <div class="col-sm-12z inputs row">
                                        <div class="col-sm-6">
                                            <a href="{{ route('register') }}" class="reset">Register an Account</a>
                                        </div>
                                        <div class="col-sm-6 float-right">
                                            <a href="{{ route('password.request') }}" class="reset">Forgot Your Password?</a>
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

