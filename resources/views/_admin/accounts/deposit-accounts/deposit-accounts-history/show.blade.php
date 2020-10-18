@extends('_admin.layouts.master')

@section('title')

    Showing Deposit Account History Record - {{ $depositaccounthistory->account_no }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing Deposit Account History Record - {{ $depositaccounthistory->account_no }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('deposit-accounts-history.show', $depositaccounthistory->account_no) !!}
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
                            {{ $depositaccounthistory->account_no }}
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
                                              @if ($depositaccounthistory->depositaccountsummary)
                                                @if ($depositaccounthistory->depositaccountsummary->depositaccount)
                                                  {{ titlecase($depositaccounthistory->depositaccountsummary->depositaccount->account_name) }}
                                                @endif
                                              @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($depositaccounthistory->product)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Account Type:</strong>
                                            <span>
                                              @if ($depositaccounthistory->depositaccountsummary)
                                                @if ($depositaccounthistory->depositaccountsummary->product)
                                                  {{ $depositaccounthistory->depositaccountsummary->product->name }}
                                                @endif
                                              @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                    @endif

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Company:</strong>
                                            <span>
                                              @if ($depositaccounthistory->depositaccountsummary)
                                                @if ($depositaccounthistory->depositaccountsummary->company)
                                                  {{ $depositaccounthistory->depositaccountsummary->company->name }}
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
                                            <strong>Amount:</strong>
                                            {{ formatCurrency($depositaccounthistory->amount) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>


                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Currency:</strong>
                                            {{ $depositaccounthistory->currency->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>


                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Status:</strong>

                                           @if ($depositaccounthistory->status->id == 1)
                                            <span class="txt-dark text-success">
                                                {{ $depositaccounthistory->status->name }}
                                            </span>
                                          @else
                                            <span class="txt-dark text-danger">
                                                {{ $depositaccounthistory->status->name }}
                                            </span>
                                          @endif

                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Trans Desc:</strong>
                                            {{ $depositaccounthistory->trans_desc }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Trans Ref Text:</strong>
                                            {{ $depositaccounthistory->trans_ref_txt }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($depositaccounthistory->user)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Account User:</strong>
                                            {{ $depositaccounthistory->user->first_name }}
                                            {{ $depositaccounthistory->user->last_name }}
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


                      {{-- <a
                          href="{{ route('user-savings-accounts.edit', $depositaccounthistory->id) }}"
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
                          <h5><strong>Deposit Account History Record Details</strong></h5>
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
                                           {{ formatFriendlyDate($depositaccounthistory->created_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($depositaccounthistory->created_by)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Created By:</strong>
                                           {{ $depositaccounthistory->creator->first_name }}
                                           {{ $depositaccounthistory->creator->last_name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                    @endif

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Updated At:</strong>
                                           {{ formatFriendlyDate($depositaccounthistory->updated_at) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($depositaccounthistory->updated_by)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Updated By:</strong>
                                           {{ $depositaccounthistory->updater->first_name }}
                                           {{ $depositaccounthistory->updater->last_name }}
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




