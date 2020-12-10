@extends('_admin.layouts.master')

@section('title')
    Edit GL Account - {{ $glaccount->description }}
@endsection

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('admin.manage.glaccounts.edit', $glaccount->id) !!}
@endsection

@section('css_header')
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
           
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Edit GL Account - {{ $glaccount->id }}</h5>
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
                                        Edit GL Account - {{ $glaccount->description }}
                                    </h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST" action="{{ route('admin.manage.glaccounts.update', $glaccount->id) }}">

                                       {{ method_field('PUT') }}
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
                                                value="{{ old('description', $glaccount->description)}}"
                                                required
                                                autofocus>

                                             @if ($errors->has('description'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('description') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>


                                       <div  class="form-group{{ $errors->has('gl_account_no') ? ' has-error' : '' }}">

                                          <label for="gl_account_no" class="col-sm-3 control-label">
                                             GL Account No
                                             {{-- <span class="text-danger"> *</span> --}}
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="gl_account_no"
                                                name="gl_account_no" disabled
                                                value="{{ old('gl_account_no', $glaccount->gl_account_no)}}"
                                                required>

                                             @if ($errors->has('gl_account_no'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('gl_account_no') }}</strong>
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

                                          @if ($status->id == old('status_id', $glaccount->status->id))
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

                                       <hr>

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
