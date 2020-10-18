@extends('_admin.layouts.master')

@section('title')

    Showing USSD Registration - {{ $ussdregistration->id }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing USSD Registration - {{ $ussdregistration->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('ussd-registration.show', $ussdregistration->id) !!}
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
                            Name:
                            <span class="txt-danger">
                            {{ $ussdregistration->name }}
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
                                            <strong>Phone:</strong>
                                            <span class="text-success">
                                              {{ $ussdregistration->phone }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Alternate Phone:</strong>
                                            <span>
                                              {{ $ussdregistration->alternate_phone }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Email:</strong>
                                            <span>
                                              {{ $ussdregistration->email }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Workplace:</strong>
                                           {{ $ussdregistration->workplace }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>County:</strong>
                                            {{ $ussdregistration->county }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Sub-County:</strong>
                                            {{ $ussdregistration->sub_county }}
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
                          <h5>USSD Registration Details</h5>
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
                                           {{ formatFriendlyDate($ussdregistration->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>TSC Number:</strong>
                                            {{ $ussdregistration->tsc_no }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Subjects:</strong>
                                            {{ $ussdregistration->subjects }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>ICT Level:</strong>
                                            {{ $ussdregistration->ict_level }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>


                                    @if (Auth::user()->hasRole('superadministrator'))

                                    <p class="mb-20">
                                        <h5>User Details</h5>
                                    </p>

                                    <hr>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>User Agent:</strong>
                                              {{ $ussdregistration->user_agent }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>Browser:</strong>
                                              {{ $ussdregistration->browser }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>Browser Version:</strong>
                                              {{ $ussdregistration->browser_version }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>OS:</strong>
                                              {{ $ussdregistration->os }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>Device:</strong>
                                              {{ $ussdregistration->device }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>IP Address:</strong>
                                              {{ $ussdregistration->src_ip }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                    @endif


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

