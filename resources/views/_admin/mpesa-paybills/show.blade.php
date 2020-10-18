@extends('_admin.layouts.master')

@section('title')

    Showing Paybill - {{ $mpesapaybill->paybill_number }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing Paybill - {{ $mpesapaybill->paybill_number }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('mpesa-paybills.show', $mpesapaybill->id) !!}
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
                          <h5>Local Paybill Record</h5>
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
                                            <strong>Paybill Number:</strong>
                                            {{ $mpesapaybill->paybill_number }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Name:</strong>
                                            {{ $mpesapaybill->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Till No.:</strong>
                                            {{ $mpesapaybill->till_number }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Paybill Type:</strong>
                                            {{ ucfirst($mpesapaybill->type) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Company:</strong>
                                            @if ($mpesapaybill->company)
                                              {{ $mpesapaybill->company->name }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Description:</strong>
                                            {{ $mpesapaybill->description }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created:</strong>
                                           {{ formatFriendlyDate($mpesapaybill->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block">
                                             <strong>Created At:</strong>
                                             {{ formatFriendlyDate($mpesapaybill->created_at) }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block">
                                             <strong>Created By:</strong>
                                             @if ($mpesapaybill->creator)
                                               {{ $mpesapaybill->creator->first_name }}
                                               {{ $mpesapaybill->creator->last_name }}
                                             @endif
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block">
                                             <strong>Updated At:</strong>
                                             {{ formatFriendlyDate($mpesapaybill->updated_at) }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block">
                                             <strong>Updated By:</strong>
                                             @if ($mpesapaybill->updater)
                                                {{ $mpesapaybill->updater->first_name }}
                                                {{ $mpesapaybill->updater->last_name }}
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
                          href="{{ route('mpesa-paybills.edit', $mpesapaybill->id) }}"
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Mpesa Paybill</span>
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
                          <h5>Remote Paybill Record</h5>
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
                                           {{ formatFriendlyDate($mpesapaybill->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created By:</strong>
                                           @if ($mpesapaybill->creator)
                                             {{ $mpesapaybill->creator->first_name }}
                                             {{ $mpesapaybill->creator->last_name }}
                                           @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Updated At:</strong>
                                           {{ formatFriendlyDate($mpesapaybill->updated_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Updated By:</strong>
                                           @if ($mpesapaybill->updater)
                                              {{ $mpesapaybill->updater->first_name }}
                                              {{ $mpesapaybill->updater->last_name }}
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

                  </div>

              </div>

            </div>

          </div>
        </div>
        <!-- /Row -->

    </div>

@endsection

