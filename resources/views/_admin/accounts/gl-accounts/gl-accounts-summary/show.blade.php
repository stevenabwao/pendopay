@extends('_admin.layouts.master')

@section('title')

    Showing GL Account Summary - {{ $glaccountsummary->gl_account_no }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing GL Account Summary - {{ $glaccountsummary->gl_account_no }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('gl-accounts-summary.show', $glaccountsummary->gl_account_no) !!}
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
                            Account:
                            <span class="txt-danger">
                            {{ $glaccountsummary->gl_account_no }}
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
                                            <strong>Account Name:</strong>
                                            <span class="text-success">
                                                @if ($glaccountsummary->glaccount)
                                                  {{ $glaccountsummary->glaccount->description }}
                                                @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Account Type:</strong>
                                            <span class="">
                                                @if ($glaccountsummary->glaccount)
                                                  @if ($glaccountsummary->glaccount->glaccounttype)
                                                    {{ $glaccountsummary->glaccount->glaccounttype->description }}
                                                  @endif
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
                                                @if ($glaccountsummary->company)
                                                  {{ $glaccountsummary->company->name }}
                                                @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Currency:</strong>
                                            @if ($glaccountsummary->currency)
                                              {{ $glaccountsummary->currency->name }}
                                            @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>


                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Ledger Balance:</strong>
                                            {{ format_num($glaccountsummary->ledger_balance) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                            <strong>Last Activity Date:</strong>
                                            {{ formatFriendlyDate($glaccountsummary->last_activity_date) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Status:</strong>

                                           @if ($glaccountsummary->status->id == 1)
                                            <span class="txt-dark text-success">
                                                {{ $glaccountsummary->status->name }}
                                            </span>
                                          @else
                                            <span class="txt-dark text-danger">
                                                {{ $glaccountsummary->status->name }}
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


                      {{-- <a
                          href="{{ route('user-savings-accounts.edit', $glaccountsummary->id) }}"
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
                          <h5><strong>GL Account Summary Details</strong></h5>
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
                                           {{ formatFriendlyDate($glaccountsummary->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($glaccountsummary->created_by)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created By:</strong>
                                           @if ($glaccountsummary->creator)
                                            {{ $glaccountsummary->creator->first_name }}
                                            {{ $glaccountsummary->creator->last_name }}
                                           @else
                                            {{ $glaccountsummary->created_by_name }}
                                           @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                    @endif

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Updated At:</strong>
                                           {{ formatFriendlyDate($glaccountsummary->updated_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($glaccountsummary->updated_by)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Updated By:</strong>
                                           @if ($glaccountsummary->updater)
                                            {{ $glaccountsummary->updater->first_name }}
                                            {{ $glaccountsummary->updater->last_name }}
                                           @else
                                            {{ $glaccountsummary->updated_by_name }}
                                           @endif
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




