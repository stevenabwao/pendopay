@extends('_admin.layouts.master')

@section('title')

    Showing USSD Contact Us - {{ $ussdcontactus->id }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing USSD Contact Us - {{ $ussdcontactus->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('ussd-contactus.show', $ussdcontactus->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
        <div class="row mt-15">


          @include('_admin.layouts.partials.error_text')


          <div class="col-lg-6 col-xs-12">

            <div class="panel panel-default card-view pa-0">

              <div  class="panel-wrapper collapse in">

                 <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                    <p class="mb-20">
                          <h5>
                            Recipient Phone:
                            <span class="txt-danger">
                            {{ $ussdcontactus->phone }}
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
                                            <strong>Company:</strong>
                                            <span class="text-success">
                                              {{ $ussdcontactus->company->name }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>



                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Sender Phone:</strong>
                                           {{ $ussdcontactus->phone }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Message:</strong>
                                            {{ $ussdcontactus->messsage }}
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

          <div class="col-lg-6 col-xs-12">

            <div class="panel panel-default card-view pa-0">

              <div  class="panel-wrapper collapse in">

                 <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                      <p class="mb-20">
                          <h5>USSD Contact Us Details</h5>
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
                                        <span class="name block capitalize-font">
                                            <strong>Created At:</strong>
                                            <span>
                                            {{ formatFriendlyDate($ussdcontactus->created_at) }}
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

                  </div>

              </div>

            </div>

          </div>
        </div>
        <!-- /Row -->

    </div>

@endsection

