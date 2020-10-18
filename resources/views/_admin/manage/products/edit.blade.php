@extends('_admin.layouts.master')


@section('title')

    Edit Product - {{ $product->id }} - {{ $product->name }}

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
            <h5 class="txt-dark">Edit Product - {{ $product->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
              {!! Breadcrumbs::render('products.edit', $product->id) !!}
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
                                    <h3 class="text-center txt-dark mb-10">
                                        Edit Product - {{ $product->id }} - {{ $product->name }}
                                    </h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('products.update', $product->id) }}">

                                       {{ method_field('PUT') }}
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
                                                value="{{ old('name', $product->name)}}"
                                                required
                                                autofocus>

                                             @if ($errors->has('name'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('name') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>


                                       <div  class="form-group{{ $errors->has('product_cd') ? ' has-error' : '' }}">

                                          <label for="product_cd" class="col-sm-3 control-label">
                                             Product CD
                                             <span class="text-danger"> *</span>
                                             &nbsp;&nbsp;
                                             <a href="#" title="Unique numeric product identifier e.g. 100" data-toggle="tooltip" class="ml-10">
                                               <i class="zmdi zmdi-info"  style="font-size: 20px"></i>
                                             </a>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="product_cd"
                                                name="product_cd"
                                                value="{{ old('product_cd', $product->product_cd)}}"
                                                required>

                                             @if ($errors->has('product_cd'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('product_cd') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('product_cat_ty') ? ' has-error' : '' }}">

                                          <label for="product_cat_ty" class="col-sm-3 control-label">
                                             Product Category Identifier
                                             <span class="text-danger"> *</span>
                                             &nbsp;&nbsp;
                                             <a href="#" title="Unique product category identifier e.g. LN-loans, DP-deposits, etc" data-toggle="tooltip" class="ml-10">
                                               <i class="zmdi zmdi-info"  style="font-size: 20px"></i>
                                             </a>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="product_cat_ty"
                                                name="product_cat_ty"
                                                value="{{ old('product_cat_ty', $product->product_cat_ty)}}"
                                                required>

                                             @if ($errors->has('product_cat_ty'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('product_cat_ty') }}</strong>
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

                                          @if ($status->id == old('status_id', $product->status->id))
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


                                       <div  class="form-group{{ $errors->has('start_at') ? ' has-error' : '' }}">

                                          <label for="start_at" class="col-sm-3 control-label">
                                             Start At
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">

                                            <div class='input-group date' id='start_at_group'>
                                                <input
                                                    type='text'
                                                    class="form-control"
                                                    placeholder="Start Date"
                                                    id='start_at'
                                                    name="start_at"
                                                    required
                                                    value="{{ old('start_at', formatDatePickerDate($product->start_at)) }}"
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

                                       <div  class="form-group{{ $errors->has('end_at') ? ' has-error' : '' }}">

                                          <label for="end_at" class="col-sm-3 control-label">
                                             End At
                                          </label>
                                          <div class="col-sm-9">

                                            <div class='input-group date' id='end_at_group'>
                                                <input
                                                    type='text'
                                                    class="form-control"
                                                    placeholder="End Date"
                                                    id='end_at'
                                                    name="end_at"
                                                    value="{{ old('end_at', formatDatePickerDate($product->end_at)) }}"
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
