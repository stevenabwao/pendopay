@extends('_admin.layouts.master')

@section('title')

    Showing Shortcode - {{ $mpesashortcode->shortcode_number }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing Shortcode - {{ $mpesashortcode->shortcode_number }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('mpesa-shortcodes.show', $mpesashortcode->id) !!}
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
                            Shortcode Number: <span class="txt-danger">{{ $mpesashortcode->shortcode_number }}</span>
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
                                            <strong>Name:</strong>
                                            {{ $mpesashortcode->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Status:</strong>
                                            {{ $mpesashortcode->status->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Company:</strong>
                                            @if ($mpesashortcode->company)
                                              {{ $mpesashortcode->company->name }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>Description:</strong>
                                              {{ $mpesashortcode->description }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>Shortcode User:</strong>
                                              {{ $mpesashortcode->shortcode_user }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>Shortcode Password:</strong>
                                              {{ $mpesashortcode->shortcode_password }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created:</strong>
                                           {{ formatFriendlyDate($mpesashortcode->created_at) }}
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
                          href="{{ route('mpesa-shortcodes.edit', $mpesashortcode->id) }}"
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Mpesa Shortcode</span>
                      </a>

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
                          <h5>Shortcode Details</h5>
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
                                           {{ formatFriendlyDate($mpesashortcode->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created By:</strong>
                                           @if ($mpesashortcode->creator)
                                             {{ $mpesashortcode->creator->first_name }}
                                             {{ $mpesashortcode->creator->last_name }}
                                           @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Updated At:</strong>
                                           {{ formatFriendlyDate($mpesashortcode->updated_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Updated By:</strong>
                                           {{ $mpesashortcode->updater->first_name }}
                                           {{ $mpesashortcode->updater->last_name }}
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

