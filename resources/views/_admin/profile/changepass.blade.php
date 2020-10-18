@extends('_admin.layouts.master')


@section('title')

    Change Password

@endsection

@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Change Password</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

              {!! Breadcrumbs::render('user.changepass') !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                <div  class="col-sm-12 col-md-8 col-md-offset-2">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">

                        <div class="panel panel-default card-view">

                           <div class="panel-wrapper collapse in">

                              <div class="panel-body">

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Change My Password</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST" action="{{ route('user.changepass.store') }}">

                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">

                                          <label for="current_password" class="col-sm-4 control-label">
                                             Current Pasword
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-8">
                                             <div class="input-group">
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    id="current_password"
                                                    name="current_password"
                                                    value="{{ old('current_password') }}" required autofocus>
                                                <div class="input-group-addon"><i class="icon-lock"></i></div>
                                             </div>
                                             @if ($errors->has('current_password'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('current_password') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>


                                       <hr/>


                                       <div  class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">

                                          <label for="new_password" class="col-sm-4 control-label">
                                             New Password
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-8">
                                             <div class="input-group">
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    id="new_password"
                                                    name="new_password"
                                                    value="{{ old('new_password') }}" required>
                                                <div class="input-group-addon"><i class="icon-lock"></i></div>
                                             </div>
                                             @if ($errors->has('new_password'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('new_password') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>


                                       <div  class="form-group{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">

                                          <label for="new_password_confirmation" class="col-sm-4 control-label">
                                             New Password Confirm
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-8">
                                             <div class="input-group">
                                                <input
                                                    type="password"
                                                    class="form-control"
                                                    id="new_password_confirmation"
                                                    name="new_password_confirmation"
                                                    value="{{ old('new_password_confirmation') }}" required>
                                                <div class="input-group-addon"><i class="icon-lock"></i></div>
                                             </div>
                                             @if ($errors->has('new_password_confirmation'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>


                                       <hr/>

                                       <div class="form-group">
                                          <div class="col-sm-4"></div>
                                          <div class="col-sm-8">
                                              <button
                                                type="submit"
                                                class="btn btn-primary btn-block mr-10 btn-lg"
                                                 id="submit-btn">
                                                 Submit
                                              </button>
                                          </div>
                                       </div>

                                       <br/>

                                    </form>

                                 </div>

                              </div>

                           </div>

                        </div>
                     </div>
                  </div>

                </div>

             </div>
          </div>
       </div>
       <!-- /Row -->


    </div>


@endsection


@section('page_scripts')

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  @include('_admin.layouts.partials.error_messages')

@endsection

