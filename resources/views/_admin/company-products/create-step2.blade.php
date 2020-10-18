@extends('_admin.layouts.master')

@section('title')

    Create company product - Step 2

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
            <h5 class="txt-dark">Create company product - Step 2</h5>
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

                                      <form method="GET" action="{{ route('admin.companyproducts.create') }}">

                                        {{ csrf_field() }}

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

                                                      @foreach ($categories as $category)
                                                      <li class="mb-10">
                                                        <option value="{{ $category->id }}"

                                                          @if ($category->id == old('product_category_id'))
                                                                selected="selected"
                                                          @endif
                                                          >
                                                          {{ $category->name }}

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

                                      </form>

                                      <form class="form-horizontal" method="POST" action="{{ route('admin.companyproducts.store') }}">

                                          {{ csrf_field() }}

                                          {{-- {{ dump($product_category_id) }} --}}

                                          <div class="form-group hidden">
                                            <div class="col-md-12">
                                                <input
                                                    type="hidden"
                                                    name="product_category_id"
                                                    value="{{ old('product_category_id') }}">
                                            </div>
                                          </div>

                                          @if(count($products) > 0)
                                            <div class="follo-data">

                                              <div  class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">

                                                  <label for="product_id" class="col-md-5 control-label">
                                                      Product
                                                      <span class="text-danger"> *</span>
                                                  </label>
                                                  <div class="col-md-7">

                                                      <select class="selectpicker form-control"
                                                          name="product_id"
                                                          data-style="form-control btn-default btn-outline"
                                                          required>

                                                          @foreach ($products as $product)
                                                          <li class="mb-10">
                                                            <option value="{{ $product->id }}"

                                                              @if ($product->id == old('product_id'))
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

                                              <div class="clearfix"></div>
                                            </div>
                                          @endif

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

                                        </form>

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

                            Picture here

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


        </div>
        <!-- /Row -->

    </div>

    {{-- {{ dd($site_settings['default_longitude']) }} --}}

@endsection


@section('page_scripts')

  <script src="{{ asset('_admin/js/bootstrap-select.min.js') }}"></script>
  <script src="{{ asset('_admin/myjs/dropify.min.js') }}"></script>
  <script src="{{ asset('_admin/myjs/form-file-upload-data.js') }}"></script>

@endsection
