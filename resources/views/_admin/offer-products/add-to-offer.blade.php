@extends('_admin.layouts.master')

@section('title')

    Add Product To Offer - {{ $offer->name }}

@endsection

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('admin.offers.add-products.create', $offer->id) !!}
 @endsection

@section('css_header')

<link href="{{ asset('_admin/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('_admin/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('_admin/css/dropify.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">

         <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Add Product To Offer  - {{ $offer->name }}</h5>
         </div>

         <!-- Breadcrumb -->
         @include('_admin.layouts.partials.breadcrumbs')
         <!-- /Breadcrumb -->

       </div>
      <!-- /Title -->


      <!-- Row -->
      <div class="row">

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

                                        <form class="form-horizontal" method="GET"
                                                        action="{{ route('admin.offers.add-products.create', $offer->id) }}">

                                                          {{ csrf_field() }}

                                            <div class="follo-data">

                                                <div class="form-group {{ $errors->has('company_product_id_main') ? ' has-error' : '' }}">

                                                    <label for="company_product_id_main" class="col-md-4 control-label text-left">
                                                        Product <span class="text-danger"> *</span>
                                                    </label>

                                                    <div class="col-md-8">

                                                        <select class="selectpicker form-control"
                                                                name="company_product_id_main" id="productChange"
                                                                data-style="form-control btn-default btn-outline"
                                                                required>

                                                                <li class="mb-10">
                                                                    <option value="" @if ("" == old('company_product_id_main')) selected="selected" @endif>
                                                                        Select Product
                                                                    </option>
                                                                </li>

                                                                @foreach ($companyproducts as $companyproduct)
                                                                    <li class="mb-10">
                                                                        <option value="{{ $companyproduct->id }}"

                                                                            @if($mainCompanyProduct)
                                                                                @if ($companyproduct->id == old('company_product_id_main', $mainCompanyProduct->id))
                                                                                    selected="selected"
                                                                                @endif
                                                                            @endif
                                                                            >
                                                                            {{ $companyproduct->product->name }}

                                                                        </option>
                                                                    </li>
                                                                @endforeach

                                                        </select>
                                                        <br>
                                                        <div class="text-right">
                                                            @if ($offer)
                                                                <a href="{{ route('admin.companyproducts.create', ['company_id_main' => $offer->company->id]) }}"
                                                                    class="text-info">Add New Establishment product
                                                                </a>
                                                            @else
                                                                <a href="{{ route('admin.companyproducts.create') }}"
                                                                    class="text-info">Add New Establishment product
                                                                </a>
                                                            @endif
                                                        </div>

                                                        @if ($errors->has('company_product_id_main'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('company_product_id_main') }}</strong>
                                                            </span>
                                                        @endif

                                                    </div>

                                                </div>

                                                @if ($offer->company)

                                                    <div class="form-group {{ $errors->has('company_id_main') ? ' has-error' : '' }}">

                                                        <label for="company_id_main" class="col-md-4 control-label text-left">
                                                            Establishment
                                                        </label>

                                                        <div class="col-md-8">
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                value="{{ $offer->company->name }}" readonly>
                                                        </div>

                                                    </div>

                                                @endif

                                                <div class="clearfix"></div>

                                            </div>

                                        </form>

                                        <form method="POST" action="{{ route('admin.offers.add-products.store', $offer->id) }}">

                                            {{ csrf_field() }}

                                            @if($mainCompanyProduct)

                                                <div class="form-group hidden">
                                                    <div class="col-md-9">
                                                        <input
                                                            type="hidden"
                                                            name="company_product_id"
                                                            value="{{ old('company_product_id', $mainCompanyProduct->id) }}">
                                                    </div>
                                                </div>

                                            @endif

                                            <div class="follo-data">

                                                    <div  class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">

                                                        <label for="status_id" class="col-md-4 control-label">
                                                            Product Status
                                                        </label>

                                                        <div class="col-md-8">

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

                                            <div class="follo-data">

                                                    <div  class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">

                                                        <label for="price" class="col-md-4 control-label">
                                                            Normal Price
                                                        </label>

                                                        <div class="col-md-8">

                                                            @if($mainCompanyProduct)
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="price"
                                                                    name="price"
                                                                    value="{{ old('price', $mainCompanyProduct->price) }}"
                                                                    readonly>
                                                            @else
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="price"
                                                                    name="price"
                                                                    value="{{ old('price') }}"
                                                                    readonly>
                                                            @endif

                                                            @if ($errors->has('price'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('price') }}</strong>
                                                                </span>
                                                            @endif

                                                        </div>

                                                    </div>

                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="follo-data">

                                                    <div  class="form-group{{ $errors->has('offer_price') ? ' has-error' : '' }}">

                                                        <label for="offer_price" class="col-md-4 control-label">
                                                        Offer Price
                                                        </label>
                                                        <div class="col-md-8">

                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="offer_price"
                                                                name="offer_price"
                                                                value="{{ old('offer_price') }}"
                                                                required>

                                                            @if ($errors->has('offer_price'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('offer_price') }}</strong>
                                                                </span>
                                                            @endif

                                                        </div>

                                                    </div>

                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="follo-data">

                                                    <div  class="form-group{{ $errors->has('offer_price') ? ' has-error' : '' }}">

                                                        <button
                                                            type="submit"
                                                            class="btn btn-lg btn-info btn-block mt-10 mb-10"
                                                            id="submit-btn">
                                                            Submit
                                                        </button>

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
                              <h5>Product Photo</h5>
                        </p>


                        {{-- <div class="panel-wrapper collapse in">
                           <div class="panel-body">
                              <div class="mt-0">
                                 <input type="file" id="input-file-now-custom-3" class="dropify" data-height="400"
                                    data-default-file="" name="item_image"/>
                              </div>
                           </div>
                        </div> --}}

                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="mt-0">
                                    @if($mainCompanyProduct)
                                        @if($mainCompanyProduct->main_image)
                                            <img src="{{ asset($mainCompanyProduct->main_image) }}"
                                            style="min-height:400px;"  title="{{ $mainCompanyProduct->product->name }}"/>
                                        @else
                                            <span class="text-danger">No Image</span>
                                        @endif
                                    @else
                                        <div class="panel-heading panel-heading-dark">
                                            <div class="alert alert-danger text-center">
                                                No Product Selected
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                     </div>
                  </div>
                  </div>

               </div>

               <div class="clearfix"></div>

            </form>

      </div>
      <!-- /Row -->

    </div>

@endsection


@section('page_scripts')

   <script type="text/javascript">

      var app = new Vue({
      el: "#app",

      data() {
            return {
            offer_expiry_method: 'by_date',
            offer_frequency: 'recurring-weekly',
            offer_type: 'regular'
            }
      }

      });
   </script>

  <script src="{{ asset('_admin/js/bootstrap-datetimepicker.min.js') }}"></script>
  <script src="{{ asset('_admin/js/bootstrap-select.min.js') }}"></script>

  <script src="{{ asset('_admin/myjs/dropify.min.js') }}"></script>
  <script src="{{ asset('_admin/myjs/form-file-upload-data.js') }}"></script>

  @include('_admin.layouts.partials.error_messages')

  <!-- search scripts -->
  @include('_admin.layouts.searchScripts')
  <!-- /search scripts -->



@endsection

