@extends('_admin.layouts.master')

@section('title')

    Create USSD Event

@endsection


@section('css_header')

    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create USSD Event</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('ussd-events.create') !!}
          </div>
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
                                    <h3 class="text-center txt-dark mb-10">Create USSD Event</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('ussd-events.store') }}">

                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">

                                          <label for="company_id" class="col-sm-3 control-label">
                                             Company Name
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
                                          @if ($company->id == old('company_id', $company->id))
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


                                       <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                          <label for="name" class="col-sm-3 control-label">
                                             Event Name
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

                                       <div  class="form-group{{ $errors->has('ussd_event_type_id') ? ' has-error' : '' }}">

                                            <label for="ussd_event_type_id" class="col-sm-3 control-label">
                                            Ussd Event Type
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                            <select class="selectpicker form-control"
                                                name="ussd_event_type_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($ussd_event_types as $ussd_event_type)
                                                <li class="mb-10">
                                                <option value="{{ $ussd_event_type->id }}"
                                            @if ($ussd_event_type->id == old('ussd_event_type_id', $ussd_event_type->id))
                                                selected="selected"
                                            @endif
                                                    >
                                                        {{ $ussd_event_type->name }}
                                                    </option>
                                                </li>
                                                @endforeach

                                            </select>

                                            @if ($errors->has('ussd_event_type_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('ussd_event_type_id') }}</strong>
                                                    </span>
                                            @endif

                                            </div>

                                        </div>

                                       <div  class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">

                                          <label for="amount" class="col-sm-3 control-label">
                                             Event Cost
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="amount"
                                                name="amount"
                                                value="{{ old('amount') }}" required>

                                             @if ($errors->has('amount'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('amount') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                          <label for="description" class="col-sm-3 control-label">
                                             Event Description
                                          </label>

                                          <div class="col-sm-9">

                                            <textarea
                                                class="form-control"
                                                rows="5"
                                                id="description"
                                                name="description">{{ old('description') }}</textarea>

                                             @if ($errors->has('description'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('description') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">

                                          <label for="start_date" class="col-sm-3 control-label">
                                              Start Date
                                          </label>

                                          <div class="col-sm-9">

                                            <div class='input-group date' id='start_date_group'>
                                                <input
                                                    type='text'
                                                    class="form-control"
                                                    id='start_date'
                                                    name="start_at"

                                                    @if (app('request')->input('start_at'))
                                                        value="{{ app('request')->input('start_at') }}"
                                                    @endif

                                                />
                                                <span class="input-group-addon">
                                                   <span class="fa fa-calendar"></span>
                                                </span>
                                             </div>

                                             @if ($errors->has('start_at'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('start_at') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div>


                                       <div  class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">

                                          <label for="end_date" class="col-sm-3 control-label">
                                              Start Date
                                          </label>

                                          <div class="col-sm-9">

                                            <div class='input-group date' id='end_date_group'>
                                                <input
                                                    type='text'
                                                    class="form-control"
                                                    id='end_date'
                                                    name="end_at"

                                                    @if (app('request')->input('end_at'))
                                                        value="{{ app('request')->input('end_at') }}"
                                                    @endif

                                                />
                                                <span class="input-group-addon">
                                                   <span class="fa fa-calendar"></span>
                                                </span>
                                             </div>

                                             @if ($errors->has('end_at'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('end_at') }}</strong>
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

  <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  <!-- search scripts -->
  @include('_admin.layouts.searchScripts')
  <!-- /search scripts -->

@endsection
