@extends('_admin.layouts.master')

@section('title')

    Create Product

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create Product</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('products.create') !!}
          </div>
       </div>
      <!-- /Title -->


      <!-- Row -->
      <div class="row">

            <form method="POST" enctype="multipart/form-data"
               action="{{ route('products.store') }}">

               {{ csrf_field() }}

               <div class="col-lg-6 col-xs-12">

                  <div class="panel panel-default card-view  pa-0 equalheight">
                  <div class="panel-wrapper collapse in">
                     <div class="panel-body  pa-0">
                        <div class="profile-box">

                        <div class="social-info">
                           <div class="row">

                              <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                 <li class="follow-list">
                                    <div class="follo-body">

                                    <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                             <label for="name" class="col-md-5 control-label">
                                                Product Name
                                                <span class="text-danger"> *</span>
                                             </label>
                                             <div class="col-md-7">
                                                <input
                                                   type="text"
                                                   class="form-control"
                                                   id="name"
                                                   name="name"
                                                   value="{{ old('name') }}"
                                                   required
                                                   autofocus>

                                                @if ($errors->has('name'))
                                                      <span class="help-block">
                                                         <strong>{{ $errors->first('name') }}</strong>
                                                      </span>
                                                @endif
                                             </div>

                                          </div>

                                       <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                             <label for="description" class="col-md-5 control-label">
                                                Product Description
                                             </label>
                                             <div class="col-md-7">
                                                <textarea name="description" id="description" rows="5"
                                                   class="form-control">{{ old('description') }}</textarea>

                                                @if ($errors->has('description'))
                                                      <span class="help-block">
                                                         <strong>{{ $errors->first('description') }}</strong>
                                                      </span>
                                                @endif
                                             </div>

                                          </div>

                                       <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('recommended_price') ? ' has-error' : '' }}">

                                             <label for="recommended_price" class="col-md-5 control-label">
                                                Recommended Price
                                             </label>

                                             <div class="col-md-3">
                                                <select class="selectpicker form-control"
                                                      name="recommended_price"
                                                      data-style="form-control btn-default btn-outline"
                                                      required>

                                                      @foreach ($currencies as $currency)
                                                      <li class="mb-10">
                                                      <option value="{{ $currency->id }}"

                                                         @if ($currency->id == old('recommended_price'))
                                                               selected="selected"
                                                         @endif
                                                         >
                                                         {{ $currency->initials }}

                                                      </option>
                                                      </li>
                                                      @endforeach

                                                </select>
                                             </div>

                                             <div class="col-md-4">
                                                <input
                                                   type="text"
                                                   class="form-control digitsOnly"
                                                   id="recommended_price"
                                                   name="recommended_price"
                                                   value="{{ old('recommended_price') }}"
                                                   >
                                             </div>

                                             <br>

                                             @if ($errors->has('recommended_price'))
                                                   <span class="help-block">
                                                      <strong>{{ $errors->first('recommended_price') }}</strong>
                                                   </span>
                                             @endif


                                          </div>

                                       <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('product_category_id') ? ' has-error' : '' }}">

                                             <label for="product_category_id" class="col-md-5 control-label">
                                                Product Category
                                                <span class="text-danger"> *</span>
                                             </label>
                                             <div class="col-md-7">

                                                <select class="selectpicker form-control"
                                                      name="product_category_id"
                                                      data-style="form-control btn-default btn-outline"
                                                      required>

                                                      @foreach ($productcategories as $productcategory)
                                                      <li class="mb-10">
                                                      <option value="{{ $productcategory->id }}"

                                                         @if ($productcategory->id == old('product_category_id'))
                                                               selected="selected"
                                                         @endif
                                                         >
                                                         {{ $productcategory->name }}

                                                      </option>
                                                      </li>
                                                      @endforeach

                                                </select>

                                                @if ($errors->has('product_category_id'))
                                                      <span class="help-block">
                                                         <strong>{{ $errors->first('product_category_id') }}</strong>
                                                      </span>
                                                @endif

                                             </div>

                                          </div>

                                       <div class="clearfix"></div>
                                    </div>




                                    <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">

                                             <label for="status_id" class="col-md-5 control-label">
                                                Status
                                                <span class="text-danger"> *</span>
                                             </label>
                                             <div class="col-md-7">

                                                <select class="selectpicker form-control"
                                                      name="status_id"
                                                      data-style="form-control btn-default btn-outline"
                                                      required>

                                                      @foreach ($statuses as $status)
                                                      <li class="mb-10">
                                                      <option value="{{ $status->id }}"

                                                         @if ($status->id == old('status_id'))
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

                                    </div>
                                 </li>
                              </ul>
                              </div>

                           </div>

                        </div>
                        </div>
                     </div>
                  </div>
                  </div>
               </div>

               <div class="col-lg-6 col-xs-12">
                  <div class="panel panel-default card-view pa-0 equalheight">
                  <div class="panel-wrapper collapse in">
                     <div  class="panel-body pb-0 ml-20 mr-20">

                        <p class="mb-20">
                              <h5>Product Photo (400 X 400 px)</h5>
                        </p>


                        <div class="panel-wrapper collapse in">
                           <div class="panel-body">
                              <div class="mt-0">
                                 <input type="file" id="input-file-now-custom-3" class="dropify" data-height="400"
                                    data-default-file="" name="item_image"/>
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>
                  </div>

               </div>

               <div class="clearfix"></div>

               <div class="col-xs-12">
                  <div class="panel panel-default card-view pa-0">
                  <div class="panel-wrapper collapse in">
                     <div  class="panel-body pb-0 ml-20 mr-20">

                        <button
                        type="submit"
                        class="btn btn-lg btn-info btn-block mt-10 mb-10"
                           id="submit-btn">
                           Submit
                        </button>

                     </div>
                  </div>
                  </div>
               </div>

            </form>

      </div>
      <!-- /Row -->

    </div>

@endsection


@section('page_scripts')

  <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  <script src="{{ asset('myjs/dropify.min.js') }}"></script>
  <script src="{{ asset('myjs/form-file-upload-data.js') }}"></script>

  @include('_admin.layouts.partials.error_messages')

@endsection
