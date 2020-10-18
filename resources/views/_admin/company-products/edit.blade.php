@extends('_admin.layouts.master')

@section('title')

    Edit Establishment Product - {{ $companyproduct->name }}

@endsection

@section('page_breadcrumbs')

    {!! Breadcrumbs::render('admin.companyproducts.edit', $companyproduct->id) !!}

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
            <h5 class="txt-dark">Edit Establishment Product - {{ $product->name }}</h5>
          </div>

          <!-- Breadcrumb -->
          @include('_admin.layouts.partials.breadcrumbs')
          <!-- /Breadcrumb -->

       </div>
       <!-- /Title -->

        <!-- Row -->
        <div class="row">

            <form method="POST" enctype="multipart/form-data"
                action="{{ route('admin.companyproducts.update', $companyproduct->id) }}">

                {{ method_field('PUT') }}
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

                                          <div  class="form-group">

                                              <label for="name" class="col-md-5 control-label">
                                                  Establishment Name
                                              </label>
                                              <div class="col-md-7">

                                                @if($companyproduct->establishment)

                                                  <input
                                                      type="text"
                                                      class="form-control"
                                                      id="name"
                                                      name="name"
                                                      value="{{ old('name', $companyproduct->establishment->name) }}"
                                                      disabled>

                                                @else

                                                  <input
                                                      type="text"
                                                      class="form-control"
                                                      id="name"
                                                      name="name"
                                                      value="No establishment set"
                                                      disabled>

                                                @endif

                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>


                                      <div class="follo-data">

                                          <div  class="form-group">

                                              <label for="product_name" class="col-md-5 control-label">
                                                  Product Name
                                              </label>
                                              <div class="col-md-7">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="product_name"
                                                    name="product_name"
                                                    value="{{ old('product_name', $product->name) }}"
                                                    disabled>

                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">

                                        <div  class="form-group{{ $errors->has('product_category_id') ? ' has-error' : '' }}">

                                            <label for="product_category_id" class="col-md-5 control-label">
                                                Product Category
                                            </label>
                                            <div class="col-md-7">

                                                <select class="selectpicker form-control"
                                                    name="product_category_id"
                                                    data-style="form-control btn-default btn-outline"
                                                    disabled>

                                                    @foreach ($categories as $category)
                                                    <li class="mb-10">
                                                      <option value="{{ $category->id }}"

                                                        @if ($category->id == old('product_category_id', $product->productcategory->id))
                                                              selected="selected"
                                                        @endif
                                                        >
                                                        {{ $category->name }}

                                                        @if(($category->company) && (Auth::user()->hasRole('superadministrator')))
                                                              &nbsp; ({{ $category->company->name }})
                                                        @endif
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

                                          <div  class="form-group">

                                              <label for="recommended_price" class="col-md-5 control-label">
                                                  Price
                                              </label>
                                              <div class="col-md-7">

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="price"
                                                    name="price"
                                                    value="{{ old('price', $companyproduct->price) }}">

                                              </div>

                                          </div>

                                        <div class="clearfix"></div>
                                      </div>



                                      <div class="follo-data">

                                          <div  class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">

                                              <label for="status_id" class="col-md-5 control-label">
                                                  Status
                                              </label>
                                              <div class="col-md-7">

                                                  <select class="selectpicker form-control"
                                                      name="status_id"
                                                      data-style="form-control btn-default btn-outline"
                                                      required>

                                                      @foreach ($statuses as $status)
                                                      <li class="mb-10">
                                                        <option value="{{ $status->id }}"

                                                          @if ($status->id == old('status_id', $companyproduct->status->id))
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
                                  @if(count($product->images))
                                    <input type="file" id="input-file-now-custom-3" class="dropify" data-height="400"
                                      data-default-file="{{ asset($product->images[0]->thumb_img_400) }}" name="item_image"/>
                                  @else
                                    <input type="file" id="input-file-now-custom-3" class="dropify" data-height="400"
                                      data-default-file="" name="item_image"/>
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

    {{-- {{ dd($site_settings['default_longitude']) }} --}}

@endsection


@section('page_scripts')

  <script src="{{ asset('_admin/js/bootstrap-select.min.js') }}"></script>
  <script src="{{ asset('_admin/myjs/dropify.min.js') }}"></script>
  <script src="{{ asset('_admin/myjs/form-file-upload-data.js') }}"></script>

@endsection
