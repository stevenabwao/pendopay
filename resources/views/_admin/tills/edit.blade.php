@extends('_admin.layouts.master')

@section('title')
    Edit Till - {{ $till->till_number }}
@endsection

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('admin.tills.edit', $till->id) !!}
@endsection

@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Edit Till - {{ $till->till_number }}</h5>
          </div>
          <!-- Breadcrumb -->
          @include('_admin.layouts.partials.breadcrumbs')
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
                                    <h3 class="text-center txt-dark mb-10">
                                        Edit Till - {{ $till->till_number }}
                                    </h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('admin.tills.update', $till->id) }}">

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">

                                          <label for="company_id" class="col-sm-3 control-label">
                                            Establishment Name
                                          </label>
                                          <div class="col-sm-9">

                                             <select class="selectpicker form-control"
                                                name="company_id" readonly
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($companies as $company)
                                                <li class="mb-10">
                                                <option value="{{ $company->id }}"

                                          @if ($company->id == old('company_id', $till->company->id))
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

                                       <div  class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                          <label for="phone_number" class="col-sm-3 control-label">
                                             Phone Number
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="phone_number"
                                                name="phone_number" readonly
                                                value="{{ old('phone_number', $till->phone_number)}}"
                                                >

                                             @if ($errors->has('phone_number'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('phone_number') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                        </div>

                                        <div class="follo-data">

                                            <div  class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">

                                            <label for="status_id" class="col-md-3 control-label">
                                                Status
                                            </label>
                                            <div class="col-md-9">

                                                <select class="selectpicker form-control"
                                                        name="status_id" disabled
                                                        data-style="form-control btn-default btn-outline"
                                                        required>

                                                        @foreach ($statuses as $status)
                                                        <li class="mb-10">
                                                        <option value="{{ $status->id }}"

                                                        @if ($status->id == old('status_id', $till->status_id))
                                                                selected="selected"
                                                        @endif
                                                        >
                                                        {{ $status->name }}

                                                        </option>
                                                        </li>
                                                        @endforeach

                                                </select>

                                                @if ($errors->has('status_id'))
                                                        <span class="help-block">
                                                        <strong>{{ $errors->first('status_id') }}</strong>
                                                        </span>
                                                @endif

                                                </div>

                                            </div>

                                            <div class="clearfix"></div>
                                        </div>

                                        <div  class="form-group{{ $errors->has('till_number') ? ' has-error' : '' }}">

                                            <label for="till_number" class="col-sm-3 control-label">
                                            Till No.
                                            </label>
                                            <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="till_number"
                                                name="till_number"
                                                value="{{ old('till_number', $till->till_number)}}"
                                                required>

                                            @if ($errors->has('till_number'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('till_number') }}</strong>
                                                    </span>
                                            @endif
                                            </div>

                                        </div>

                                        <div  class="form-group{{ $errors->has('till_name') ? ' has-error' : '' }}">

                                            <label for="till_name" class="col-sm-3 control-label">
                                            Till Name <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="till_name"
                                                name="till_name"
                                                value="{{ old('till_name', $till->till_name)}}"
                                                >

                                            @if ($errors->has('till_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('till_name') }}</strong>
                                                    </span>
                                            @endif
                                            </div>

                                        </div>

                                        <div  class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">

                                            <label for="active" class="col-sm-3 control-label">
                                                Is Till Active? <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                                <div class="radio no-margin">
                                                    <input {{ (old('active', $till->active) == '1') ? 'checked' : '' }}
                                                            class="form-check-input" type="radio" name="active" id="1"
                                                            v-model="active" value="1">
                                                    <label for="1">Active</label>
                                                </div>

                                                <div class="radio no-margin">
                                                    <input {{ (old('active', $till->active) == '99') ? 'checked' : '' }}
                                                            class="form-check-input" type="radio" name="active" id="99"
                                                            v-model="active" value="99">
                                                    <label for="99">Not Active</label>
                                                </div>

                                                @if ($errors->has('active'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('active') }}</strong>
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
