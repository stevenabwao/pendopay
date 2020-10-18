@extends('_admin.layouts.master')

@section('title')

    Create GL Account

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
            <h5 class="txt-dark">Create GL Account</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('glaccounts.create') !!}
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
                                    <h3 class="text-center txt-dark mb-10">Create GL Account</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('glaccounts.store') }}">

                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                          <label for="description" class="col-sm-3 control-label">
                                             Name
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="description"
                                                name="description"
                                                value="{{ old('description') }}">

                                             @if ($errors->has('description'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('description') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('gl_account_type_id') ? ' has-error' : '' }}">

                                            <label for="gl_account_type_id" class="col-sm-3 control-label">
                                            GL Account Type
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                            <select class="selectpicker form-control"
                                                name="gl_account_type_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($glaccounttypes as $glaccounttype)
                                                <li class="mb-10">
                                                <option value="{{ $glaccounttype->id }}"

                                            @if ($glaccounttype->id == old('gl_account_type_id'))
                                                selected="selected"
                                            @endif
                                                    >
                                                        {{ $glaccounttype->description }}
                                                    </option>
                                                </li>
                                                @endforeach

                                            </select>

                                            @if ($errors->has('gl_account_type_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('gl_account_type_id') }}</strong>
                                                    </span>
                                            @endif

                                            </div>

                                        </div>

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

                                                   @if ($errors->has('company_name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('company_name') }}</strong>
                                                        </span>
                                                   @endif

                                                </div>

                                             </div>


                                            <div  class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">

                                          <label for="status_id" class="col-sm-3 control-label">
                                             Status
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">

                                             <select class="selectpicker form-control"
                                                name="status_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($statuses as $status)
                                                <li class="mb-10">
                                                <option value="{{ $status->id }}"

                                          @if ($status->id == old('status_id', '1'))
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

                                       <hr/>

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

  <script type="text/javascript">
      /* Start Datetimepicker Init*/
      $('#start_at_group').datetimepicker({
          useCurrent: false,
          format: 'DD-MM-YYYY',
          icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
        }).on('dp.show', function() {
        if($(this).data("DateTimePicker").date() === null)
          $(this).data("DateTimePicker").date(moment());
      });

      /* End Datetimepicker Init*/
      $('#end_at_group').datetimepicker({
          useCurrent: false,
          format: 'DD-MM-YYYY',
          icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
        }).on('dp.show', function() {
        if($(this).data("DateTimePicker").date() === null)
          $(this).data("DateTimePicker").date(moment());
      });

      //clear date
      $("#clear_date").click(function(e){
          e.preventDefault();
          $('#start_at').val("");
          $('#end_at').val("");
      });

  </script>

  @include('_admin.layouts.partials.error_messages')

@endsection
