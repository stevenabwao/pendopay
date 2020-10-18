@extends('_admin.layouts.master')

@section('title')

    Create Establishment product

@endsection

@section('page_breadcrumbs')

    {!! Breadcrumbs::render('admin.companyproducts.create') !!}

@endsection

@section('css_header')

  <link href="{{ asset('_admin/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('_admin/css/dropify.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')


    <div class="container-fluid pt-10">

       <!-- Title -->
       <div class="row heading-bg">

          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create Establishment product</h5>
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
                                                        action="{{ route('admin.companyproducts.create') }}">

                                                {{ csrf_field() }}

                                                @if ($companies)

                                                    <div class="follo-data">

                                                        <div  class="form-group{{ $errors->has('company_id_main') ? ' has-error' : '' }}">

                                                            <label for="company_id_main" class="col-md-5 control-label">
                                                                Establishment
                                                                <span class="text-danger"> *</span>
                                                            </label>
                                                            <div class="col-md-7">

                                                                <select class="selectpicker form-control"
                                                                name="company_id_main"
                                                                id="companyIdChange"
                                                                data-style="form-control btn-default btn-outline"
                                                                required>

                                                                        <li class="mb-10">
                                                                            <option value="" @if ((!app('request')->input('company_id_main')) || (app('request')->input('company_id_main') == "")) selected="selected" @endif>
                                                                                Select establishment
                                                                            </option>
                                                                        </li>

                                                                        @foreach ($companies as $company)

                                                                            <li class="mb-10">

                                                                                <option value="{{ $company->id }}"

                                                                                    @if($mainCompany)
                                                                                        @if ($company->id == old('company_id_main', $mainCompany->id))
                                                                                            selected="selected"
                                                                                        @endif
                                                                                    @endif

                                                                                >

                                                                                {{ $company->name }}

                                                                                </option>

                                                                            </li>

                                                                        @endforeach

                                                                </select>
                                                                @if ($errors->has('company_id_main'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('company_id_main') }}</strong>
                                                                    </span>
                                                                @endif

                                                            </div>

                                                        </div>

                                                        <div class="clearfix"></div>

                                                    </div>

                                                @endif

                                                <div class="follo-data">

                                                    <div  class="form-group{{ $errors->has('product_category_id_main') ? ' has-error' : '' }}">

                                                        <label for="product_category_id_main" class="col-md-5 control-label">
                                                            Product Category
                                                            <span class="text-danger"> *</span>
                                                        </label>
                                                        <div class="col-md-7">

                                                            <select class="selectpicker form-control"
                                                                name="product_category_id_main"
                                                                data-style="form-control btn-default btn-outline"
                                                                id="productCategoryChange"
                                                                required>

                                                                <li class="mb-10">
                                                                    <option value="" @if ((!app('request')->input('product_category_id_main')) || (app('request')->input('product_category_id_main') == "")) selected="selected" @endif>
                                                                        Select product category
                                                                    </option>
                                                                </li>

                                                                @foreach ($categories as $category)
                                                                <li class="mb-10">
                                                                    <option value="{{ $category->id }}" data-catid="{{ $category->id }}"

                                                                        @if($mainProductCategory)
                                                                            @if ($category->id == old('product_category_id_main', $mainProductCategory->id))
                                                                                selected="selected"
                                                                            @endif
                                                                        @endif

                                                                    >
                                                                    {{ $category->name }}

                                                                    </option>
                                                                </li>
                                                                @endforeach

                                                            </select>

                                                            @if ($errors->has('product_category_id_main'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('product_category_id_main') }}</strong>
                                                                </span>
                                                            @endif

                                                        </div>

                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">

                                                    <div  class="form-group{{ $errors->has('product_id_main') ? ' has-error' : '' }}">

                                                        <label for="product_id_main" class="col-md-5 control-label">
                                                            Product
                                                            <span class="text-danger"> *</span>
                                                        </label>
                                                        <div class="col-md-7">

                                                            <select class="selectpicker form-control"
                                                                name="product_id_main"
                                                                data-style="form-control btn-default btn-outline"
                                                                id="productChange"
                                                                required>

                                                                <li class="mb-10">
                                                                    <option value="" @if ((!app('request')->input('product_id_main')) || (app('request')->input('product_id_main') == "")) selected="selected" @endif>
                                                                        Select product
                                                                    </option>
                                                                </li>

                                                                @foreach ($products as $product)
                                                                <li class="mb-10">
                                                                    <option value="{{ $product->id }}" data-catid="{{ $product->id }}"

                                                                        @if($mainProduct)
                                                                            @if ($product->id == old('product_id_main', $mainProduct->id))
                                                                                selected="selected"
                                                                            @endif
                                                                        @endif

                                                                    >
                                                                    {{ $product->name }}

                                                                    </option>
                                                                </li>
                                                                @endforeach

                                                            </select>

                                                            @if ($errors->has('product_id_main'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('product_id_main') }}</strong>
                                                                </span>
                                                            @endif

                                                        </div>

                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>

                                        </form>

                                        <form method="POST" action="{{ route('admin.companyproducts.store') }}">

                                            {{ csrf_field() }}

                                            @if($mainCompany)

                                                <div class="form-group hidden">
                                                    <div class="col-md-9">
                                                        <input
                                                            type="hidden"
                                                            name="company_id"
                                                            value="{{ old('company_id', $mainCompany->id) }}">
                                                    </div>
                                                </div>

                                            @endif

                                            @if($mainProductCategory)

                                                <div class="form-group hidden">
                                                    <div class="col-md-9">
                                                        <input
                                                            type="hidden"
                                                            name="product_category_id"
                                                            value="{{ old('product_category_id', $mainProductCategory->id) }}">
                                                    </div>
                                                </div>

                                            @endif

                                            @if($mainProduct)

                                                <div class="form-group hidden">
                                                    <div class="col-md-9">
                                                        <input
                                                            type="hidden"
                                                            name="product_id"
                                                            value="{{ old('product_id', $mainProduct->id) }}">
                                                    </div>
                                                </div>

                                            @endif

                                            <div class="follo-data">

                                                <div  class="form-group">

                                                    <label for="recommended_price" class="col-md-5 control-label">
                                                        Recommended Price
                                                        <span class="text-danger"> *</span>
                                                    </label>
                                                    <div class="col-md-7">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="recommended_price"
                                                            name="recommended_price"
                                                            value="{{ $mainProduct ? $mainProduct->recommended_price : '' }}"
                                                            disabled>

                                                    </div>

                                                    </div>

                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="follo-data">

                                                <div  class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">

                                                    <label for="price" class="col-md-5 control-label">
                                                        Price
                                                        <span class="text-danger"> *</span>
                                                    </label>
                                                    <div class="col-md-7">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="price"
                                                            name="price"
                                                            value="{{ old('price') }}"
                                                            required>

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
                          <h5>Product Photo</h5>
                      </p>

                      <div class="panel-wrapper collapse in">

                        <div class="panel-body">

                            @if($product_image)

                                <img src="{{ asset($product_image) }}"
                                        style="min-height:400px;"  title=""/>

                            @else
                                <div class="mt-0" id="prodImage" style="min-height:400px;">
                                    <span class="text-danger">No Image</span>
                                </div>
                            @endif

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

        </div>
        <!-- /Row -->

      </form>

    </div>


@endsection


@section('page_scripts')

  <script src="{{ asset('_admin/js/bootstrap-select.min.js') }}"></script>
  <script src="{{ asset('_admin/myjs/dropify.min.js') }}"></script>
  <script src="{{ asset('_admin/myjs/form-file-upload-data.js') }}"></script>

@endsection
