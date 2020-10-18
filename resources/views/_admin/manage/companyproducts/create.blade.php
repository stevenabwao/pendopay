@extends('_admin.layouts.master')

@section('title')

    Create Company Product

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
            <h5 class="txt-dark">Create Company Product</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('companyproducts.create') !!}
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
                                    <h3 class="text-center txt-dark mb-10">Create Company Product</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('companyproducts.store') }}">

                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                          <label for="name" class="col-sm-3 control-label">
                                             Name
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                name="name"
                                                value="{{ old('name') }}">

                                             @if ($errors->has('name'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('name') }}</strong>
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

                                               @if ($errors->has('company_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('company_id') }}</strong>
                                                    </span>
                                               @endif

                                            </div>

                                        </div>

                                        <div  class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">

                                                <label for="product_id" class="col-sm-3 control-label">
                                                   Product Type
                                                   <span class="text-danger"> *</span>
                                                </label>
                                                <div class="col-sm-9">

                                                   <select class="selectpicker form-control"
                                                      name="product_id"
                                                      data-style="form-control btn-default btn-outline"
                                                      required>

                                                      @foreach ($products as $product)
                                                      <li class="mb-10">
                                                      <option value="{{ $product->id }}"
                                                @if ($product->id == old('product_id', $product->id))
                                                    selected="selected"
                                                @endif
                                                          >
                                                            {{ $product->name }}
                                                          </option>
                                                      </li>
                                                      @endforeach

                                                   </select>

                                                   @if ($errors->has('product_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('product_id') }}</strong>
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
