@extends('_admin.layouts.master')

@section('title')

    Displaying Establishment Product - {{ $companyproduct->product->name }}

@endsection

@section('page_breadcrumbs')

    {!! Breadcrumbs::render('admin.companyproducts.show', $companyproduct->id) !!}

@endsection


@section('content')


    <div class="container-fluid pt-10">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying Establishment Product - {{ $companyproduct->product->name }}</h5>
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

                          <div class="col-lg-12">
                            <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                <li class="follow-list">
                                  <div class="follo-body">

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                          <strong>Establishment Name:</strong>

                                          @if ($companyproduct->establishment)

                                            @if(($companyproduct->status->id) == config('constants.status.inactive'))
                                              <span class="text-danger">
                                            @else
                                              <span class="text-success">
                                            @endif

                                              {{ $companyproduct->establishment->name }}

                                            </span>

                                          @else

                                            <span class="text-danger">No establishment set</span>

                                          @endif

                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Product Name:</strong>
                                            {{ $companyproduct->product->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                          <strong>Product Description:</strong>
                                          @if ($companyproduct->product->description)
                                            {{ $companyproduct->product->description }}
                                          @else
                                            <span class="text-danger">No description</span>
                                          @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Product Category:</strong>
                                            @if($companyproduct->product->productcategory)
                                            {{ $companyproduct->product->productcategory->name }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Price:</strong>
                                            {{ formatCurrency($companyproduct->price) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>


                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created:</strong>
                                           {{ formatFriendlyDate($companyproduct->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Status:</strong>
                                           @if ($companyproduct->status)

                                           @if(($companyproduct->status->id) == config('constants.status.inactive'))
                                            <span class="text-danger">
                                           @else
                                            <span class="text-success">
                                           @endif

                                            {{ $companyproduct->status->name }}
                                           </span>
                                           @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>

                      </div>

                      <a
                          href="{{ route('admin.companyproducts.edit', $companyproduct->id) }}"
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Establishment Product</span>
                      </a>
                      <a
                          href="{{ route('admin.companyproducts.index', ['companies' => $companyproduct->company->id]) }}"
                          class="btn btn-info btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Show All Establishment Products</span>
                      </a>

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
                    Product Photo</h5>
                  </p>

                  <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                      <div class="mt-0">
                          @if(count($images))
                            <img src="{{ asset($images[0]->thumb_img_400) }}" style="min-height:400px;"
                                alt="{{ $companyproduct->product->name }}"/>
                          @else
                            <span class="text-danger text-center">{{ config('constants.site_text.no_photo_text') }}</span>
                          @endif

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

    {{-- {{ dd($site_settings['default_longitude']) }} --}}

@endsection


@section('page_scripts')


@endsection
