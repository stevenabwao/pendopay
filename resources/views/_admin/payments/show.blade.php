@extends('_admin.layouts.master')

@section('title')

    Showing Payment - {{ $payment->id }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing Payment - {{ $payment->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('payments.show', $payment->id) !!}
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
                        <h5>Payment Record</h5>
                    </p>

                    <hr>

                        <div class="social-info">
                          <div class="row">

                              @if (!$payment->processed)

                                <div class="col-sm-6">
                                  <a
                                    href="{{ route('payments.edit', $payment->id) }}"
                                    class="btn btn-primary btn-block btn-anim">
                                    <i class="fa fa-pencil"></i>
                                    <span class="btn-text">Edit</span>
                                  </a>
                                </div>

                                <div class="col-sm-6">

                                  <a
                                      href="{{ route('payments.repost', $payment->id) }}"
                                      class="btn btn-success btn-block btn-anim">
                                      <i class="fa fa-check"></i>
                                      <span class="btn-text">Repost Transaction</span>
                                  </a>

                                </div>

                                <div class="clearfix"></div>

                                <hr>

                              @endif

                              <div class="col-lg-12">

                                        <div class="followers-wrap">
                                          <ul class="followers-list-wrap">
                                            <li class="follow-list">
                                              <div class="follo-body">

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Full Name:</strong>
                                                        {{ $payment->full_name }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Account No:</strong>
                                                        {{ $payment->account_no }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Account Name:</strong>
                                                        {{ titlecase($payment->account_name) }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Amount:</strong>
                                                        <span class="text-success">
                                                          {{ format_num($payment->amount) }}
                                                        </span>
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Paybill No:</strong>
                                                        {{ $payment->paybill_number }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Company Name:</strong>
                                                        {{ $payment->company_name }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Transaction ID:</strong>
                                                        {{ $payment->trans_id }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Phone No:</strong>
                                                        {{ $payment->phone }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                @if ($payment->created_at)
                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Created At:</strong>
                                                        {{ formatFriendlyDate($payment->created_at) }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>
                                                @endif

                                                @if ($payment->updated_at)
                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Updated At:</strong>
                                                        {{ formatFriendlyDate($payment->updated_at) }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>
                                                @endif

                                                @if ($payment->updated_by)
                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Updated By:</strong>
                                                        @if($payment->updater)
                                                         {{ $payment->updater->first_name }} {{ $payment->updater->last_name }}
                                                        @else
                                                          {{ $payment->updated_by_name }}
                                                        @endif
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>
                                                @endif

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Processed:</strong>

                                                        @if ($payment->processed)

                                                            @if (($payment->processed) && (!$payment->modified))
                                                              <span class="text-success">True</span>
                                                            @elseif (($payment->processed) && ($payment->modified))
                                                              <span class="text-primary">True</span>
                                                            @endif

                                                            @if ($payment->processed_at)
                                                              <div style="margin-top:15px;">
                                                                <strong>Processed At:</strong>

                                                                @if (($payment->processed) && (!$payment->modified))
                                                                  <span class="text-success">
                                                                    {{ formatFriendlyDate($payment->processed_at) }}
                                                                  </span>
                                                                @elseif (($payment->processed) && ($payment->modified))
                                                                  <span class="text-primary">
                                                                    {{ formatFriendlyDate($payment->processed_at) }}
                                                                  </span>
                                                                @endif

                                                              </div>
                                                            @endif

                                                        @else

                                                            <span class="text-danger">False</span>

                                                            @if ($payment->failed_at)
                                                              <div style="margin-top:15px;">
                                                                <strong>Last Failed At:</strong>
                                                                <span class="text-danger">
                                                                  {{ formatFriendlyDate($payment->failed_at) }}
                                                                </span>
                                                              </div>
                                                            @endif

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

          <div class="col-lg-6 col-xs-12">

            <div class="panel panel-default card-view pa-0">

              <div  class="panel-wrapper collapse in">

                 <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                      <p class="mb-20">
                          <h5 class="text-primary">Deposited Record</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-lg-12">

                          @if ($deposit_record)

                              <div class="followers-wrap">
                                  <ul class="followers-list-wrap">
                                    <li class="follow-list">
                                      <div class="follo-body">

                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Full Name:</strong>
                                                @if ($deposit_record->full_name)
                                                  {{ $deposit_record->full_name }}
                                                @endif
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>

                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Account No:</strong>
                                                {{ $deposit_record->account_no }}
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>

                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Account Name:</strong>
                                                {{ $deposit_record->account_name }}
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>

                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Amount:</strong>
                                                <span class="text-success">
                                                  {{ format_num($deposit_record->amount) }}
                                                </span>
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>

                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Paybill No:</strong>
                                                {{ $deposit_record->paybill_number }}
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>

                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Company Name:</strong>
                                                {{ $payment->company_name }}
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>

                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Transaction ID:</strong>
                                                {{ $deposit_record->trans_id }}
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>

                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Phone No:</strong>
                                                {{ $deposit_record->phone }}
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>

                                        @if ($deposit_record->created_at)
                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Created At:</strong>
                                                {{ formatFriendlyDate($deposit_record->created_at) }}
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>
                                        @endif

                                        @if ($deposit_record->updated_at)
                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Updated At:</strong>
                                                {{ formatFriendlyDate($deposit_record->updated_at) }}
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

                          @else
                            <h5 class="text-danger">
                                No Record found
                            </h5>
                          @endif

                      </div>

                  </div>

              </div>

            </div>

          </div>

          <div class="clearfix"></div>

          @if (!$payment->processed)
            <div class="clearfix"></div>
            <div class="col-xs-12">
              <div class="panel panel-default card-view pa-0">
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body pb-0 ml-20 mr-20 mb-20">
                      <strong>Fail Reason:</strong>
                      <div class="text-success wrap-text">
                        {{ $payment->fail_reason }}
                      </div>
                   </div>
                </div>
              </div>
            </div>
          @endif

        </div>
        <!-- /Row -->

    </div>

@endsection


@section('page_css')
  <style>
    .wrap-text {
        width: 100%;
        word-wrap: break-word;
    }
  </style>
@endsection

