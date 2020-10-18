@extends('_admin.layouts.master')

@section('title')

    Showing Yehu Deposit - {{ $yehudeposit['message']->data[0]->id }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing Yehu Deposit - {{ $yehudeposit['message']->data[0]->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('yehu-deposits.show', $yehudeposit['message']->data[0]->id) !!}
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
                        <h5>Local Record (PM)</h5>
                    </p>

                    <hr>

                        <div class="social-info">
                          <div class="row">

                              @if (!$yehudeposit['message']->data[0]->processed)

                                <div class="col-sm-6">
                                  <a
                                    href="{{ route('yehu-deposits.edit', $yehudeposit['message']->data[0]->id) }}"
                                    class="btn btn-primary btn-block btn-anim">
                                    <i class="fa fa-pencil"></i>
                                    <span class="btn-text">Edit</span>
                                  </a>
                                </div>

                                <div class="col-sm-6">

                                  <a
                                      href="{{ route('yehu-deposits.repost', $yehudeposit['message']->data[0]->id) }}"
                                      class="btn btn-success btn-block btn-anim">
                                      <i class="fa fa-check"></i>
                                      <span class="btn-text">Repost Transaction</span>
                                  </a>

                                </div>

                                <div class="clearfix"></div>

                                <hr>

                              @endif

                              <div class="col-lg-12">
                                @if ($yehudeposit['error'])

                                    <h5 class="text-danger">
                                        {{ $yehudeposit['message'] }}
                                    </h5>

                                @else

                                    @if (!$yehudeposit['message']->data)

                                        <h5 class="text-danger">
                                            No Local Record found
                                        </h5>

                                    @else

                                        <div class="followers-wrap">
                                          <ul class="followers-list-wrap">
                                            <li class="follow-list">
                                              <div class="follo-body">

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Full Name:</strong>
                                                        {{ $yehudeposit['message']->data[0]->full_name }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Account No:</strong>
                                                        {{ $yehudeposit['message']->data[0]->acct_no }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Deposit Account Name:</strong>
                                                        {{ $yehudeposit['message']->data[0]->acct_name }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Business Unit ID:</strong>
                                                        {{ $yehudeposit['message']->data[0]->bu_id }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Business Unit Name:</strong>
                                                        {{ $yehudeposit['message']->data[0]->bu_nm }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Amount:</strong>
                                                        <span class="text-success">
                                                          {{ format_num($yehudeposit['message']->data[0]->amount) }}
                                                        </span>
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Paybill Number:</strong>
                                                        {{ $yehudeposit['message']->data[0]->paybill_number }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Transaction ID:</strong>
                                                        {{ $yehudeposit['message']->data[0]->trans_id }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Phone Number:</strong>
                                                        {{ $yehudeposit['message']->data[0]->phone_number }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                @if ($yehudeposit['message']->data[0]->created_at)
                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Created At:</strong>
                                                        {{ formatFriendlyDate($yehudeposit['message']->data[0]->created_at) }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>
                                                @endif

                                                @if ($yehudeposit['message']->data[0]->updated_at)
                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Updated At:</strong>
                                                        {{ formatFriendlyDate($yehudeposit['message']->data[0]->updated_at) }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>
                                                @endif

                                                @if ($yehudeposit['message']->data[0]->updated_by)
                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Updated By:</strong>
                                                        {{ $yehudeposit['message']->data[0]->updated_by }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>
                                                @endif

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Processed:</strong>
                                                        @if (($yehudeposit['message']->data[0]->processed) && (!$yehudeposit['message']->data[0]->modified))

                                                          <span class="text-success">True</span>
                                                          @if ($yehudeposit['message']->data[0]->processed_at)
                                                            <div style="margin-top:15px;">
                                                              <strong>Processed At:</strong>
                                                              <span class="text-success">
                                                                {{ formatFriendlyDate($yehudeposit['message']->data[0]->processed_at) }}
                                                              </span>
                                                            </div>
                                                          @endif

                                                        @elseif (($yehudeposit['message']->data[0]->processed) && ($yehudeposit['message']->data[0]->modified))

                                                          <span class="text-primary">True</span>

                                                        @else

                                                            <span class="text-danger">False</span>

                                                            <!-- @if ($yehudeposit['message']->data[0]->failed_at)
                                                              <div style="margin-top:15px;">
                                                                <strong>Last Failed At:</strong>
                                                                <span class="text-danger">
                                                                  {{ formatFriendlyDate($yehudeposit['message']->data[0]->failed_at) }}
                                                                </span>
                                                              </div>
                                                            @endif -->

                                                        @endif
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                            @if (($yehudeposit['message']->data[0]->reposted_at) &&
                                                ($yehudeposit['message']->data[0]->reposted_by))

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Reposted At:</strong>
                                                        {{ formatFriendlyDate($yehudeposit['message']->data[0]->reposted_at) }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Reposted By:</strong>
                                                        {{ $yehudeposit['message']->data[0]->reposted_by }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                            @endif

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Comments:</strong>
                                                        {{ $yehudeposit['message']->data[0]->comments }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                              </div>
                                            </li>
                                          </ul>
                                        </div>

                                    @endif

                                @endif
                              </div>

                          </div>

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
                          <h5 class="text-primary">Remote Record (Yehu)</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-lg-12">

                            @if ($remote_yehudeposit['error'])

                                <h5 class="text-danger">
                                    {{ $remote_yehudeposit['message'] }}
                                </h5>

                            @else

                                @if (!$remote_yehudeposit['message']->data)

                                    <h5 class="text-danger">
                                        No Remote Record found
                                    </h5>

                                @else

                                    <div class="followers-wrap">
                                      <ul class="followers-list-wrap">
                                        <li class="follow-list">
                                          <div class="follo-body">

                                            <div class="follo-data">
                                              <div class="user-data">
                                                <span class="name block capitalize-font">
                                                    <strong>Full Name:</strong>
                                                    @if ($remote_yehudeposit['message']->data[0]->full_name)
                                                      {{ $remote_yehudeposit['message']->data[0]->full_name }}
                                                    @endif
                                                </span>
                                              </div>
                                              <div class="clearfix"></div>
                                            </div>

                                            <div class="follo-data">
                                              <div class="user-data">
                                                <span class="name block capitalize-font">
                                                    <strong>Account No:</strong>
                                                    {{ $remote_yehudeposit['message']->data[0]->acct_no }}
                                                </span>
                                              </div>
                                              <div class="clearfix"></div>
                                            </div>



                                            <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Deposit Account Name:</strong>
                                                        {{ $remote_yehudeposit['message']->data[0]->acct_name }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Business Unit ID:</strong>
                                                        {{ $remote_yehudeposit['message']->data[0]->bu_id }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Business Unit Name:</strong>
                                                        {{ $remote_yehudeposit['message']->data[0]->bu_nm }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Amount:</strong>
                                                        <span class="text-success">
                                                          {{ format_num($remote_yehudeposit['message']->data[0]->amount) }}
                                                        </span>
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Paybill Number:</strong>
                                                        {{ $remote_yehudeposit['message']->data[0]->paybill_number }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Transaction ID:</strong>
                                                        {{ $remote_yehudeposit['message']->data[0]->trans_id }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Phone Number:</strong>
                                                        {{ $remote_yehudeposit['message']->data[0]->phone_number }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                @if ($remote_yehudeposit['message']->data[0]->created_at)
                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Created At:</strong>
                                                        {{ formatFriendlyDate($remote_yehudeposit['message']->data[0]->created_at) }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>
                                                @endif

                                                @if ($remote_yehudeposit['message']->data[0]->updated_at)
                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Updated At:</strong>
                                                        {{ formatFriendlyDate($remote_yehudeposit['message']->data[0]->updated_at) }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>
                                                @endif

                                                @if ($remote_yehudeposit['message']->data[0]->updated_by)
                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Updated By:</strong>
                                                        {{ $remote_yehudeposit['message']->data[0]->updated_by }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>
                                                @endif

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Processed:</strong>
                                                        @if (($remote_yehudeposit['message']->data[0]->processed) && (!$remote_yehudeposit['message']->data[0]->modified))

                                                          <span class="text-success">True</span>
                                                          @if ($remote_yehudeposit['message']->data[0]->processed_at)
                                                            <div style="margin-top:15px;">
                                                              <strong>Processed At:</strong>
                                                              <span class="text-success">
                                                                {{ formatFriendlyDate($remote_yehudeposit['message']->data[0]->processed_at) }}
                                                              </span>
                                                            </div>
                                                          @endif

                                                        @elseif (($remote_yehudeposit['message']->data[0]->processed) && ($remote_yehudeposit['message']->data[0]->modified))

                                                          <span class="text-primary">True</span>

                                                        @else

                                                            <span class="text-danger">False</span>

                                                            @if ($remote_yehudeposit['message']->data[0]->failed_at)
                                                              <div style="margin-top:15px;">
                                                                <strong>Last Failed At:</strong>
                                                                <span class="text-danger">
                                                                  {{ formatFriendlyDate($remote_yehudeposit['message']->data[0]->failed_at) }}
                                                                </span>
                                                              </div>
                                                            @endif

                                                        @endif
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data">
                                                  <div class="user-data">
                                                    <span class="name block capitalize-font">
                                                        <strong>Comments:</strong>
                                                        {{ $remote_yehudeposit['message']->data[0]->comments }}
                                                    </span>
                                                  </div>
                                                  <div class="clearfix"></div>
                                                </div>

                                          </div>
                                        </li>
                                      </ul>
                                    </div>

                                @endif

                            @endif

                          </div>
                      </div>

                  </div>

              </div>

            </div>

          </div>

          @if (!$yehudeposit['message']->data[0]->processed)
            <div class="clearfix"></div>
            <div class="col-xs-12">
              <div class="panel panel-default card-view pa-0">
                <div  class="panel-wrapper collapse in">
                   <div  class="panel-body pb-0 ml-20 mr-20 mb-20">
                      <strong>Fail Reason:</strong>
                      <div class="text-success wrap-text">
                        {{ $yehudeposit['message']->data[0]->fail_reason }}
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

