@extends('_admin.layouts.master')

@section('title')

    Showing Company Product - {{ $companyproduct->name }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing Product - {{ $companyproduct->name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('companyproducts.show', $companyproduct->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
        <div class="row mt-15">


          @include('_admin.layouts.partials.error_text')


          <div class="col-lg-6 col-xs-12">

            <div class="panel panel-default card-view pa-0 equalheight">

              <div  class="panel-wrapper collapse in">

                 <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                    <p class="mb-20">
                          <h5>
                           Name:

                           @if ($companyproduct->status->id == 1)
                              <span class="text-success">
                           @elseif (($companyproduct->status->id == 2)
                                 || ($companyproduct->status->id == 3)
                                 || ($companyproduct->status->id == 7)
                                 || ($companyproduct->status->id == 99))
                              <span class="text-danger">
                           @else
                              <span class="text-primary">
                           @endif

                                {{ $companyproduct->name }}
                              </span>

                          </h5>
                    </p>

                    <hr>

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
                                            <strong>ID:</strong>
                                            <span>
                                              {{ $companyproduct->id }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Product Type:</strong>
                                            <span>
                                                @if ($companyproduct->product)
                                                  {{ $companyproduct->product->name }}
                                                @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Company:</strong>
                                            <span>
                                                @if ($companyproduct->company)
                                                  {{ $companyproduct->company->name }}
                                                @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>



                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Status:</strong>
                                           @if ($companyproduct->status->id == 1)
                                              <span class="text-success">
                                           @elseif (($companyproduct->status->id == 2)
                                                 || ($companyproduct->status->id == 3)
                                                 || ($companyproduct->status->id == 7)
                                                 || ($companyproduct->status->id == 99))
                                              <span class="text-danger">
                                           @else
                                              <span class="text-primary">
                                           @endif

                                                {{ $companyproduct->status->name }}
                                              </span>
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
                          href="{{ route('companyproducts.edit', $companyproduct->id) }}"
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Product</span>
                      </a>


                    </div>
                  </div>

              </div>

            </div>
          </div>

          <div class="col-lg-6 col-xs-12">

            <div class="panel panel-default card-view pa-0 equalheight">

              <div  class="panel-wrapper collapse in">

                 <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                      <p class="mb-20">
                          <h5>Details</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-lg-12">
                            <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                <li class="follow-list">
                                  <div class="follo-body">

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created At:</strong>
                                           {{ formatFriendlyDate($companyproduct->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Updated At:</strong>
                                           {{ formatFriendlyDate($companyproduct->updated_at) }}
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

                  </div>

              </div>

            </div>

          </div>
        </div>
        <!-- /Row -->

    </div>

@endsection

