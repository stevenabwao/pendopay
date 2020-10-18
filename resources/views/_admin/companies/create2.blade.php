@extends('_admin.layouts.master')


@section('title')

    Create New Establishment

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Create New Establishment</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

              {!! Breadcrumbs::render('establishments.create') !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->




       <div class="container-fluid">


         <!-- Row -->
          <div class="table-struct full-width full-height">
             <div class="table-cell auth-form-wrap-inner">
                <div class="ml-auto mr-auto no-float">

                   <div  class="col-sm-12">

                     <div class="row">
                        <div class="col-sm-12 col-xs-12">

                           <div class="panel panel-default card-view">

                              <div class="panel-wrapper collapse in">

                                 <div class="panel-body">

                                    <div class="form-wrap">

                                         <br/>

                                         <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                                             action="{{ route('establishments.store') }}" id="form" data-select2-id="form">

                                             {{ csrf_field() }}

                                             <div class="form-group">

                                                 <label for="name" class="col-sm-3 control-label">
                                                 Establishment Name
                                                 </label>
                                                 <div class="col-sm-9">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="name"
                                                        value="{{  old('name') }}">

                                                 </div>

                                             </div>

                                             <div  class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                                 <label for="category_id" class="col-sm-3 control-label">Category</label>
                                                 <div class="col-sm-9">

                                                     <select class="form-control" name="category_id">

                                                         @foreach ($categories as $category)
                                                             <li class="mb-10">
                                                                 <option value="{{ $category->id }}"

                                                                         @if ($category->id == old('category_id', $category->id))
                                                                         selected="selected"
                                                                         @endif
                                                                 >
                                                                     {{ $category->name }}
                                                                 </option>
                                                             </li>
                                                         @endforeach

                                                     </select>

                                                     @if ($errors->has('category_id'))
                                                         <span class="help-block">
                                                             <strong>{{ $errors->first('category_id') }}</strong>
                                                         </span>
                                                     @endif

                                                 </div>

                                             </div>

                                             <div  class="form-group{{ ($errors->has('county') || $errors->has('county_condition_id')) ? ' has-error' : '' }}">
                                                <label for="county_id" class="col-sm-3 control-label">County</label>
                                                <div class="col-sm-3">
                                                    <select class="form-control" name="county_id">

                                                            <li class="mb-10">
                                                                <option value="">None</option>
                                                            </li>

                                                            @foreach ($counties as $county)
                                                                <li class="mb-10">
                                                                    <option value="{{ $county->id }}"

                                                                    @if ($county->id == old('county'))
                                                                        selected="selected"
                                                                    @endif

                                                                    >
                                                                        {{ $county->name }}
                                                                    </option>
                                                                </li>
                                                            @endforeach

                                                    </select>

                                                    @if ($errors->has('county_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('county_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <label for="town" class="col-sm-3 control-label">Town</label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="town" class="form-control"
                                                    value="{{ old('town')}}">
                                                    @if ($errors->has('town'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('town') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>

                                            <hr>

                                             <div  class="form-group{{ ($errors->has('contact_person') || $errors->has('paybill_no')) ? ' has-error' : '' }}">
                                                <label for="contact_person" class="col-sm-3 control-label">Contact Person</label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="contact_person" class="form-control"
                                                    value="{{ old('contact_person')}}">
                                                    @if ($errors->has('contact_person'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('contact_person') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <label for="paybill_no" class="col-sm-3 control-label">Lipa Na Mpesa Number</label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="paybill_no" class="form-control"
                                                    value="{{ old('paybill_no')}}">
                                                    @if ($errors->has('paybill_no'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('paybill_no') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                             </div>

                                             <div  class="form-group{{ ($errors->has('email') || $errors->has('personal_email')) ? ' has-error' : '' }}">
                                                <label for="email" class="col-sm-3 control-label">Establishment Email</label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="email" class="form-control"
                                                    value="{{ old('email')}}">
                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <label for="personal_email" class="col-sm-3 control-label">Personal Email</label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="personal_email" class="form-control"
                                                    value="{{ old('personal_email')}}">
                                                    @if ($errors->has('personal_email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('personal_email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                             </div>

                                             <div class="form-group">

                                                <label for="name" class="col-sm-3 control-label">
                                                Establishment Phone
                                                </label>
                                                <div class="col-sm-9">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="name"
                                                        value="{{  old('name') }}">

                                                </div>

                                            </div>

                                             <div  class="form-group{{ ($errors->has('phone') || $errors->has('phone_country')) ? ' has-error' : '' }}">
                                                <label for="phone_country" class="col-sm-3 control-label">Personal Mobile</label>
                                                <div class="col-sm-3">
                                                    <select id="phone_country" name="phone_country" class="form-control selectpicker" required>

                                                        @foreach ($countries as $country)
                                                        <li class="mb-10">
                                                            <option value="{{ $country->sortname }}"
                                                        @if ($country->sortname == old('phone_country', 'KE'))
                                                            selected="selected"
                                                        @endif
                                                            >
                                                            {{ $country->name }} (+{{ $country->phonecode }})
                                                            </option>
                                                        </li>
                                                        @endforeach

                                                    </select>
                                                </div>

                                                {{-- <label for="phone" class="col-sm-3 control-label">Phone</label> --}}
                                                <div class="col-sm-6">
                                                    <input type="text"
                                                            class="form-control"
                                                            name="phone"
                                                            data-parsley-trigger="change"
                                                            value="{{ old('phone') }}"
                                                            placeholder="e.g. 720000000" required>
                                                    @if ($errors->has('phone'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('phone') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>












                                             <hr>

                                             <div class="box-footer">
                                                 <button type="submit" class="btn btn-primary pull-right"><i class="zmdi zmdi-save"></i> &nbsp;&nbsp; Submit</button>
                                             </div><!-- /.box-footer -->

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
                                    <h3 class="text-center txt-dark mb-10">Create Establishment</h3>
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
                                        action="{{ route('establishments.store') }}">

                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                          <label for="name" class="col-sm-3 control-label">
                                             Establishment Name
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                name="name"
                                                value="{{ old('name') }}" required autofocus>

                                             @if ($errors->has('name'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('name') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('company_no') ? ' has-error' : '' }}">

                                          <label for="company_no" class="col-sm-3 control-label">
                                             Company No.
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="company_no"
                                                name="company_no"
                                                value="{{ old('company_no') }}">

                                             @if ($errors->has('company_no'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('company_no') }}</strong>
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
                                                    maxlength="13"
                                                    value="{{ old('sms_user_name') }}">
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

                                       <div  class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">

                                            <div class="row">
                                                <label for="phone" class="col-sm-3 control-label">
                                                Phone
                                                <span class="text-danger"> *</span>
                                                </label>
                                                <div class="col-sm-9">

                                                    <div class="col-sm-6 no-padding-right">
                                                        <select id="phone_country" name="phone_country" class="form-control selectpicker" required>

                                                            @foreach ($countries as $country)
                                                            <li class="mb-10">
                                                                <option value="{{ $country->sortname }}"
                                                            @if ($country->sortname == old('phone_country', 'KE'))
                                                                selected="selected"
                                                            @endif
                                                                >
                                                                {{ $country->name }} (+{{ $country->phonecode }})
                                                                </option>
                                                            </li>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <input type="text"
                                                            class="form-control"
                                                            name="phone"
                                                            data-parsley-trigger="change"
                                                            value="{{ old('phone') }}"
                                                            placeholder="e.g. 720000000" required>
                                                    </div>

                                                    @if ($errors->has('phone'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('phone') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>
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
                                                  value="{{ old('email') }}">

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
                                                value="{{ old('physical_address') }}">

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
                                                value="{{ old('box') }}">

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
