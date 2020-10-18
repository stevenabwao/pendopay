@extends('_admin.layouts.master')


@section('title')

    Edit Company Branch- {{ $companybranch->name }}

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Edit Company Branch - {{ $companybranch->name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('companybranches.edit', $companybranch->id) !!}
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
                                        Edit Company Branch - {{ $companybranch->name }}
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
                                        action="{{ route('companybranches.update', $companybranch->id) }}">

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                          <label for="name" class="col-sm-3 control-label">
                                             Branch Name
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                name="name"
                                                value="{{ $companybranch->name }}"
                                                required
                                                autofocus>

                                             @if ($errors->has('name'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('name') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>


                                       @if (Auth::user()->hasRole('superadministrator'))

                                            <div  class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">

                                                <label for="company_id" class="col-sm-3 control-label">
                                                    Company
                                                    <span class="text-danger"> *</span>
                                                </label>
                                                <div class="col-sm-9">

                                                    <select class="selectpicker form-control"
                                                    name="company_id"
                                                    data-style="form-control btn-default btn-outline"
                                                    required>

                                                    @foreach ($companies as $company)
                                                    <li class="mb-10">
                                                    <option value="{{ $company->id }}"

                                                @if ($company->id == old('company_id', $companybranch->company->id))
                                                    selected="selected"
                                                @endif
                                                        >
                                                            {{ $company->name }}
                                                        </option>
                                                    </li>
                                                    @endforeach

                                                    </select>

                                                    @if ($errors->has('company_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('company_id') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>

                                            </div>


                                       @endif


                                       <div  class="form-group{{ $errors->has('manager_id') ? ' has-error' : '' }}">

                                            <label for="manager_id" class="col-sm-3 control-label">
                                                Branch Manager
                                            </label>
                                            <div class="col-sm-9">

                                                <select class="selectpicker form-control"
                                                name="manager_id"
                                                data-style="form-control btn-default btn-outline"
                                                >

                                                @foreach ($users as $user)
                                                <li class="mb-10">
                                                <option value="{{ $user->id }}"

                                            @if ($user->id == old('manager_id', $companybranch->manager_id))
                                                selected="selected"
                                            @endif
                                                    >
                                                        {{ $user->first_name }}
                                                        {{ $user->last_name }}
                                                    </option>
                                                </li>
                                                @endforeach

                                                </select>

                                                @if ($errors->has('manager_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('manager_id') }}</strong>
                                                    </span>
                                                @endif

                                            </div>

                                        </div>


                                        <div  class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">

                                            <div class="row">
                                                <label for="phone" class="col-sm-3 control-label">
                                                Branch Phone
                                                <span class="text-danger"> *</span>
                                                </label>
                                                <div class="col-sm-9">

                                                    <div class="col-sm-5 no-padding-right">
                                                        <select id="phone_country" name="phone_country" class="form-control selectpicker" required>

                                                            @foreach ($countries as $country)
                                                                <li class="mb-10">
                                                                    <option value="{{ $country->sortname }}"
                                                                @if ($country->sortname == old('phone_country', $companybranch->phone_country))
                                                                    selected="selected"
                                                                @endif
                                                                    >
                                                                    {{ $country->name }} (+{{ $country->phonecode }})
                                                                    </option>
                                                                </li>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    <div class="col-sm-7">
                                                        <input type="text"
                                                            class="form-control"
                                                            name="phone"
                                                            data-parsley-trigger="change"
                                                            value="{{ $companybranch->phone }}"
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
                                                value="{{ $companybranch->email }}">

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
                                                value="{{ $companybranch->physical_address }}">

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
                                                value="{{ $companybranch->box }}">

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
                                                class="btn btn-lg btn-primary btn-block mr-10"
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
