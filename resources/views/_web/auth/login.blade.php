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
                                            <input type="password" name="password" class="form-control">
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

                                    <div class="col-md-12z inputs">
                                    <button class="btn btn-xs" type="submit">Login</button>
                                    </div>
                                    <div class="col-md-12z inputs">
                                    <a href="#" class="reset">
                                        Forgot Your Password?
                                    </a>
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

            <style>
                /* @import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css); */
                @import url(https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.3/css/mdb.min.css);

                /* .hm-gradient {
                    background-color: #eee;
                }
                .darken-grey-text {
                    color: #2E2E2E;
                } */


                .md-form.mat-2 input[type=text], .md-form.mat-2 input[type=password] {
                border-width: 1px !important;
                border-style: solid;
                border-color: #ced4da;
                border-radius: 5px;
                /* padding-top: .5rem; */
                /* padding-left: 8px;
                padding-right: 8px; */
                padding-bottom: .1rem;
                font-size: .875rem;
                line-height: 1.5;
                }

                .md-form.mat-2 input[type=text]:focus {
                /* border-color: #4285f4;
                box-shadow: inset 0px 0px 0px 1px #4285f4; */
                }

                .md-form.mat-2 label {
                top: .3rem;
                left: 8px;
                font-size: .875rem;
                }

                .md-form.mat-2 label.active {
                background: #fff;
                font-weight: 500;
                padding-right: 5px;
                padding-left: 5px;
                font-size: 11px;
                top: 1.9rem;
                left: 8px;
                }

                input[type=text], input[type=password] { height: 1.5rem; line-height: 0; width:86%; }
                .mx-auto{ margin-left: 0 !important; margin-right: 0 !important; }

                .md-form, .md-form .btn {
                    margin-bottom: 0;
                    margin-top: 1rem;
                }

                .form-title{background: #ededed; padding-top:8px; margin-top:8px; margin-bottom:2rem;}

                hr{margin: 20px 0 !important;}

            </style>
        @endsection

