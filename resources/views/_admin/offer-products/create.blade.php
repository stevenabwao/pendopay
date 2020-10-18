@extends('_admin.layouts.master')

@section('title')

    Create Offer product

@endsection

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('admin.offerproducts.create') !!}
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
            <h5 class="txt-dark">Create Offer product</h5>
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
                                                        action="{{ route('admin.offerproducts.create') }}">

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

                                                    <div  class="form-group{{ $errors->has('offer_id_main') ? ' has-error' : '' }}">

                                                        <label for="offer_id_main" class="col-md-5 control-label">
                                                            Offer
                                                            <span class="text-danger"> *</span>
                                                        </label>
                                                        <div class="col-md-7">

                                                            <select class="selectpicker form-control"
                                                                name="offer_id_main"
                                                                data-style="form-control btn-default btn-outline"
                                                                id="productCategoryChange"
                                                                required>

                                                                <li class="mb-10">
                                                                    <option value=""
                                                                        @if ((!app('request')->input('offer_id_main')) ||
                                                                             (app('request')->input('offer_id_main') == ""))
                                                                             selected="selected"
                                                                        @endif>
                                                                        Select offer
                                                                    </option>
                                                                </li>

                                                                @foreach ($offers as $offer)
                                                                <li class="mb-10">
                                                                    <option value="{{ $offer->id }}" data-catid="{{ $offer->id }}"

                                                                        @if($mainOffer)
                                                                            @if ($offer->id == old('offer_id_main', $mainOffer->id))
                                                                                selected="selected"
                                                                            @endif
                                                                        @endif

                                                                    >
                                                                    {{ $offer->name }}

                                                                    </option>
                                                                </li>
                                                                @endforeach

                                                            </select>

                                                            @if ($errors->has('offer_id_main'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('offer_id_main') }}</strong>
                                                                </span>
                                                            @endif

                                                        </div>

                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">

                                                    <div  class="form-group{{ $errors->has('company_product_id_main') ? ' has-error' : '' }}">

                                                        <label for="company_product_id_main" class="col-md-5 control-label">
                                                            Product
                                                            <span class="text-danger"> *</span>
                                                        </label>
                                                        <div class="col-md-7">

                                                            <select class="selectpicker form-control"
                                                                name="company_product_id_main"
                                                                data-style="form-control btn-default btn-outline"
                                                                id="productChange"
                                                                required>

                                                                <li class="mb-10">
                                                                    <option value=""
                                                                        @if ((!app('request')->input('company_product_id_main')) ||
                                                                             (app('request')->input('company_product_id_main') == ""))
                                                                             selected="selected"
                                                                        @endif>
                                                                        Select product
                                                                    </option>
                                                                </li>

                                                                @foreach ($companyproducts as $companyproduct)
                                                                <li class="mb-10">
                                                                    <option value="{{ $companyproduct->id }}" data-catid="{{ $companyproduct->id }}"

                                                                        @if($mainCompanyProduct)
                                                                            @if ($companyproduct->id == old('company_product_id_main', $mainCompanyProduct->id))
                                                                                selected="selected"
                                                                            @endif
                                                                        @endif

                                                                    >
                                                                    {{ $companyproduct->product_name }}

                                                                    </option>
                                                                </li>
                                                                @endforeach

                                                            </select>

                                                            @if ($errors->has('company_product_id_main'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('company_product_id_main') }}</strong>
                                                                </span>
                                                            @endif

                                                        </div>

                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>

                                        </form>

                                        <form method="POST" action="{{ route('admin.offerproducts.store') }}">

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

                                            @if($mainOffer)

                                                <div class="form-group hidden">
                                                    <div class="col-md-9">
                                                        <input
                                                            type="hidden"
                                                            name="offer_id"
                                                            value="{{ old('offer_id', $mainOffer->id) }}">
                                                    </div>
                                                </div>

                                            @endif

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

                                                <div  class="form-group">

                                                    <label for="normal_price" class="col-md-5 control-label">
                                                        Normal Price
                                                    </label>
                                                    <div class="col-md-7">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="normal_price"
                                                            name="normal_price"
                                                            value="{{ $mainCompanyProduct ? format_num($mainCompanyProduct->price) : '' }}"
                                                            disabled>

                                                    </div>

                                                    </div>

                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="follo-data">

                                                <div  class="form-group{{ $errors->has('offer_price') ? ' has-error' : '' }}">

                                                    <label for="offer_price" class="col-md-5 control-label">
                                                        Offer Price
                                                        <span class="text-danger"> *</span>
                                                    </label>
                                                    <div class="col-md-7">
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
