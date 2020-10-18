@extends('_admin.layouts.master')


@section('title')

    Edit Company - {{ $company->name }}

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Edit Company - {{ $company->name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('companies.edit', $company->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell vertical-align-middle auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                <div  class="col-sm-12 col-md-8 col-md-offset-2">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">

                        <div class="panel panel-default card-view">

                           <div class="panel-wrapper collapse in">

                              <div class="panel-body">

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">
                                        Edit Company - {{ $company->name }}
                                    </h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    @if (session('message'))
                                      <div class="alert alert-success text-center">
                                          {!! session('message') !!}
                                      </div>
                                    @endif

                                    @if (session('error'))
                                      <div class="alert alert-danger text-center">
                                          {!! session('error') !!}
                                      </div>
                                    @endif

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('companies.update', $company->id) }}">

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                          <label for="name" class="col-sm-3 control-label">
                                             Company Name
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                name="name"
                                                value="{{ $company->name }}"
                                                required
                                                autofocus>

                                             @if ($errors->has('first_name'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('first_name') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       @if (Auth::user()->hasRole('superadministrator'))
                                         <div  class="form-group{{ $errors->has('sms_user_name') ? ' has-error' : '' }}">

                                            <label for="sms_user_name" class="col-sm-3 control-label">
                                               Bulk SMS Name
                                            </label>
                                            <div class="col-sm-9">
                                               <div class="input-group">
                                                  <input
                                                      type="text"
                                                      class="form-control"
                                                      id="sms_user_name"
                                                      name="sms_user_name"
                                                      value="{{ $company->sms_user_name }}" required>
                                                  <div class="input-group-addon"><i class="icon-lock"></i></div>
                                               </div>
                                               @if ($errors->has('sms_user_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('sms_user_name') }}</strong>
                                                    </span>
                                               @endif
                                            </div>

                                         </div>
                                       @endif

                                       <div  class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                          <label for="phone_number" class="col-sm-3 control-label">
                                             Phone Number
                                          </label>
                                          <div class="col-sm-9">

                                            <input
                                                type="text"
                                                class="form-control"
                                                id="phone_number"
                                                name="phone_number"
                                                maxlength="13"
                                                value="{{ $company->phone_number }}">

                                             @if ($errors->has('phone_number'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('phone_number') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                          <label for="email" class="col-sm-3 control-label">
                                             Email Address
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="email"
                                                class="form-control"
                                                id="email"
                                                name="email"
                                                value="{{ $company->email }}">

                                             @if ($errors->has('email'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('email') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('physical_address') ? ' has-error' : '' }}">

                                          <label for="physical_address" class="col-sm-3 control-label">
                                             Physical Address
                                          </label>
                                          <div class="col-sm-9">

                                            <input
                                                type="text"
                                                class="form-control"
                                                id="physical_address"
                                                name="physical_address"
                                                value="{{ $company->physical_address }}">

                                             @if ($errors->has('physical_address'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('physical_address') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('box') ? ' has-error' : '' }}">

                                          <label for="box" class="col-sm-3 control-label">
                                             Box Number
                                          </label>
                                          <div class="col-sm-9">

                                            <input
                                                type="text"
                                                class="form-control"
                                                id="box"
                                                name="box"
                                                value="{{ $company->box }}">

                                             @if ($errors->has('box'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('box') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <br/>

                                       <div class="form-group">
                                          <div class="col-sm-3"></div>
                                          <div class="col-sm-9">
                                              <button
                                                type="submit"
                                                class="btn btn-primary btn-block mr-10"
                                                 id="submit-btn">
                                                 Submit
                                              </button>
                                          </div>
                                       </div>

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
