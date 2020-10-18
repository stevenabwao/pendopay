@extends('_admin.layouts.master')

@section('title')

    Showing Offer Product - {{ $offerproduct->companyproduct->product->name }}

@endsection

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('admin.offerproducts.show', $offerproduct->id) !!}
@endsection


@section('css_header')

    <link href="{{ asset('_admin/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('_admin/css/dropify.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

        <!-- Title -->
        <div class="row heading-bg">

            <div class="col-sm-6 col-xs-12">
                <h5 class="txt-dark">Showing Offer Product - {{ $offerproduct->companyproduct->product->name }}</h5>
            </div>

            <!-- Breadcrumb -->
            @include('_admin.layouts.partials.breadcrumbs')
            <!-- /Breadcrumb -->

        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">

            <form>

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

                                                                    <label for="name" class="col-md-4 control-label">
                                                                        Offer Product ID
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        <input
                                                                                type="text"
                                                                                class="form-control"
                                                                                id="name"
                                                                                name="name" disabled
                                                                                value="{{ $offerproduct->id }}"
                                                                                required
                                                                                autofocus>

                                                                    </div>

                                                                </div>

                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">

                                                                <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                                                    <label for="name" class="col-md-4 control-label">
                                                                        Offer Name
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        <input
                                                                                type="text"
                                                                                class="form-control"
                                                                                id="name"
                                                                                name="name" disabled
                                                                                value="{{ $offerproduct->offer->name }}"
                                                                                required
                                                                                autofocus>

                                                                        <div class="text-right">
                                                                            <a target="_blank" href="{{ route('admin.offerproducts.index', ['offer_id' => $offerproduct->offer_id]) }}"
                                                                                class="text-info">Show All Offer Products
                                                                            </a>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">

                                                                <div  class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">

                                                                    <label for="company_id" class="col-md-4 control-label">
                                                                        Establishment
                                                                    </label>
                                                                    <div class="col-md-8">

                                                                        <select class="selectpicker form-control"
                                                                                name="company_id" disabled
                                                                                data-style="form-control btn-default btn-outline"
                                                                                required>

                                                                            @foreach ($companies as $company)
                                                                                <li class="mb-10">
                                                                                    <option value="{{ $company->id }}"

                                                                                            @if ($company->id == $offerproduct->company_id)
                                                                                                selected="selected"
                                                                                            @endif
                                                                                    >
                                                                                        {{ $company->name }}

                                                                                    </option>
                                                                                </li>
                                                                            @endforeach

                                                                        </select>


                                                                    </div>

                                                                </div>

                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">
                                                                <div  class="form-group">
                                                                    <label for="status_id" class="col-md-4 control-label">
                                                                        Offer Product Status
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        {!! showStatusText($offerproduct->status_id) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">
                                                                <div  class="form-group">
                                                                    <label for="normal_price" class="col-md-4 control-label">
                                                                        Normal Price
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" disabled name="normal_price" value="{{ formatCurrency($offerproduct->normal_price) }}">
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">
                                                                <div  class="form-group">
                                                                    <label for="offer_price" class="col-md-4 control-label">
                                                                        Offer Price
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" disabled name="offer_price" value="{{ formatCurrency($offerproduct->offer_price) }}">
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">
                                                                <div  class="form-group">
                                                                    <label for="discount_percent" class="col-md-4 control-label">
                                                                        Discount
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" disabled name="discount_percent" value="{{ $offerproduct->discount_percent }}%">
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">
                                                                <div  class="form-group">
                                                                    <label class="col-md-4 control-label">
                                                                        Last Updated At
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" disabled value="{{ formatFriendlyDate($offerproduct->updated_at) }}">
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>

                                                            <div class="follo-data">
                                                                <div  class="form-group">
                                                                    <label class="col-md-4 control-label">
                                                                        Last Updated By
                                                                    </label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" disabled value="{{ $offerproduct->updater->full_name }}">
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
                                <h5>Offer Product Photo</h5>
                                </p>

                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="mt-0">
                                            @if($offerproduct->main_image)

                                                <img src="{{ asset($offerproduct->main_image) }}"
                                                    style="min-height:400px;"  title="{{ $offerproduct->companyproduct->product->name }}"/>
                                            @else
                                                <span class="text-danger">No Image</span>
                                            @endif
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
                                <div class="col-sm-4">
                                    <a href="{{ route('admin.offerproducts.edit', $offerproduct->id) }}"
                                            class="btn btn-lg btn-info btn-block mt-10 mb-10"
                                        >
                                        Edit Offer Product
                                    </a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ route('admin.offerproducts.index', ['offer_id' => $offerproduct->offer_id]) }}"
                                            class="btn btn-lg btn-primary btn-block mt-10 mb-10"
                                        >
                                        Show All Offer Products
                                    </a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ route('admin.offers.add-products.create', $offerproduct->offer_id) }}"
                                            class="btn btn-lg btn-success btn-block mt-10 mb-10"
                                        >
                                        <i class="zmdi zmdi-plus"></i> Add Products To Same Offer
                                    </a>
                                </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endsection


@section('page_scripts')

    <script src="{{ asset('_admin/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('_admin/js/bootstrap-select.min.js') }}"></script>

    <script src="{{ asset('_admin/myjs/dropify.min.js') }}"></script>
    <script src="{{ asset('_admin/myjs/form-file-upload-data.js') }}"></script>

    @include('_admin.layouts.partials.error_messages')

    <!-- search scripts -->
    @include('_admin.layouts.searchScripts')
    <!-- /search scripts -->



@endsection

