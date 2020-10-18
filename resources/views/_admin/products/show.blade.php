@extends('_admin.layouts.master')

@section('title')

    Displaying Product - {{ $product->name }}

@endsection

@section('page_breadcrumbs')

    {!! Breadcrumbs::render('admin.products.show', $product->id) !!}

@endsection


@section('content')


    <div class="container-fluid pt-10">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Displaying Product - {{ $product->name }}</h5>
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
                                            <strong>Product Name:</strong>
                                            {{ $product->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                          <strong>Product Description:</strong>
                                          @if ($product->description)
                                            {{ $product->description }}
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
                                            @if($product->productcategory)
                                            {{ $product->productcategory->name }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Recommended Price:</strong>
                                            {{ formatCurrency($product->recommended_price) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>


                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created:</strong>
                                           {{ formatFriendlyDate($product->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Status:</strong>
                                           @if ($product->status)

                                           @if(($product->status->id) == config('constants.status.inactive'))
                                            <span class="text-danger">
                                           @else
                                            <span class="text-success">
                                           @endif

                                            {{ $product->status->name }}
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
                          href="{{ route('admin.products.edit', $product->id) }}"
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Product</span>
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
                    <h5>Product Photo</h5>
                  </p>


                  <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                      <div class="mt-0">
                          @if(count($product->images))
                            <img src="{{ asset($product->images[0]->thumb_img_400) }}" style="min-height:400px;"/>
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
        </div>
        <!-- /Row -->

    </div>

    {{-- {{ dd($site_settings['default_longitude']) }} --}}

@endsection


@section('page_scripts')


@endsection
