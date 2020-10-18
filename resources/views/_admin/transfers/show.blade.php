@extends('_admin.layouts.master')

@section('title')

    Showing Transfer Record - {{ $transfer->id }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing Transfer Record - {{ $transfer->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('transfers.show', $transfer->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
        <div class="row mt-15">

          {{-- {{ dd($transfer) }} --}}


          @include('_admin.layouts.partials.error_text')


          <div class="col-lg-6 col-xs-12">

            <div class="panel panel-default card-view pa-0 equalheight">

              <div  class="panel-wrapper collapse in">

                 <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                    <p class="mb-20">
                          <h5>
                            Source Account:
                            <span class="txt-danger">
                            {{ $transfer->source_account_no }}
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
                                      <div class="user-dataz">
                                        <span class="name block capitalize-font">
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                              <strong>Source Account Name:</strong>
                                            </span>
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                {{ titlecase($transfer->source_account_name) }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-dataz">
                                        <span class="name block capitalize-font">
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                <strong>Source Account Phone:</strong>
                                            </span>
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                {{ titlecase($transfer->source_phone) }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                        <span class="name block capitalize-font">
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                              <strong>Source Account No.:</strong>
                                            </span>
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                {{ titlecase($transfer->source_account_no) }}
                                            </span>
                                        </span>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                        <span class="name block capitalize-font">
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                <strong>Source Account Type:</strong>
                                            </span>
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                {{ $transfer->source_account_type }}
                                            </span>
                                        </span>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                        <span class="name block capitalize-font">
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                <strong>Company:</strong>
                                            </span>
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                @if ($transfer->company)
                                                  {{ $transfer->company->name }}
                                                @endif
                                            </span>
                                        </span>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                        <span class="name block capitalize-font">
                                          <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                            <strong>Amount:</strong>
                                          </span>
                                          <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                            {{ formatCurrency($transfer->amount) }}
                                          </span>
                                        </span>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                        <span class="name block">
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                              <strong>Status:</strong>
                                            </span>

                                            @if ($transfer->status->id == 1)
                                              <span class="txt-dark text-success col-lg-6 col-sm-12 nopadding">
                                                  {{ $transfer->status->name }}
                                              </span>
                                            @else
                                              <span class="txt-dark text-danger col-lg-6 col-sm-12 nopadding">
                                                  {{ $transfer->status->name }}
                                              </span>
                                            @endif

                                        </span>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-dataz">
                                        <span class="name block capitalize-font">
                                            <span class="col-lg-12 col-sm-12 nopadding dark-text">
                                              <strong>Comments:</strong>
                                            </span>
                                            <span class="col-lg-12 col-sm-12 nopadding dark-text">
                                              {{ $transfer->comments }}
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


                      {{-- <a
                          href="{{ route('user-savings-accounts.edit', $transfer->id) }}"
                          class="btn btn-success btn-block btn-outline btn-anim mt-30">
                          <i class="fa fa-pencil"></i>
                          <span class="btn-text">Edit Account</span>
                      </a> --}}


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
                          <h5><strong>Destination Account:</strong></h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-lg-12">
                            <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                <li class="follow-list">
                                  <div class="follo-body">

                                    <div class="follo-data">
                                        <div class="user-dataz">
                                          <span class="name block capitalize-font">
                                              <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                <strong>Destination Account Name:</strong>
                                              </span>
                                              <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                  {{ titlecase($transfer->destination_account_name) }}
                                              </span>
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-dataz">
                                          <span class="name block capitalize-font">
                                              <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                  <strong>Destination Account Phone:</strong>
                                              </span>
                                              <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                  {{ titlecase($transfer->source_phone) }}
                                              </span>
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                          <span class="name block capitalize-font">
                                              <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                <strong>Destination Account No.:</strong>
                                              </span>
                                              <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                  {{ titlecase($transfer->destination_account_no) }}
                                              </span>
                                          </span>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                          <span class="name block capitalize-font">
                                              <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                  <strong>Destination Account Type:</strong>
                                              </span>
                                              <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                                  {{ $transfer->destination_account_type }}
                                              </span>
                                          </span>
                                        <div class="clearfix"></div>
                                      </div>

                                      <p class="mb-20">
                                          <h5><strong>Transfer Record Details</strong></h5>
                                      </p>

                                      <hr>

                                    <div class="follo-data">
                                      <div class="user-dataz">
                                        <span class="name block">
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                              <strong>Created At:</strong>
                                            </span>
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                              {{ formatFriendlyDate($transfer->created_at) }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($transfer->created_by)
                                    <div class="follo-data">
                                      <div class="user-dataz">
                                        <span class="name block">
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                              <strong>Created By:</strong>
                                            </span>
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                              {{ $transfer->creator->first_name }}
                                              {{ $transfer->creator->last_name }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                    @endif

                                    <div class="follo-data">
                                      <div class="user-dataz">
                                        <span class="name block">
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                              <strong>Updated At:</strong>
                                            </span>
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                              {{ formatFriendlyDate($transfer->updated_at) }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($transfer->updated_by)
                                    <div class="follo-data">
                                      <div class="user-dataz">
                                        <span class="name block">
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                              <strong>Updated By:</strong>
                                            </span>
                                            <span class="col-lg-6 col-sm-12 nopadding dark-text">
                                              {{ $transfer->updater->first_name }}
                                              {{ $transfer->updater->last_name }}
                                            </span>
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




