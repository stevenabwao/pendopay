@extends('_admin.layouts.master')

@section('title')

    Showing Loan Application - {{ $loanapplication->id }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing Loan Application - {{ $loanapplication->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('loan-applications.show', $loanapplication->id) !!}
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
                            Loan Application Details
                          </h5>
                    </p>

                    <hr>

                    <div class="social-info">
                      <div class="row">

                          @if ($loanapplication->status->id == 16)

                            <div class="col-sm-6">

                                <a
                                    href="{{ route('loan-applications.loanapprove.repost', $loanapplication->id) }}"
                                    class="btn btn-success btn-block btn-anim">
                                    <i class="fa fa-check"></i>
                                    <span class="btn-text">Repost Transaction</span>
                                </a>

                            </div>

                            <div class="col-sm-6"></div>

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
                                            <strong>Company:</strong>
                                            <span>
                                              @if ($loanapplication->company)
                                                {{ $loanapplication->company->name }}
                                              @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Deposit Account No.:</strong>
                                            <span>
                                              @if ($loanapplication->depositaccount)
                                                {{ $loanapplication->depositaccount->account_no }}
                                              @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Deposit Account Name:</strong>
                                            <span>
                                                @if ($loanapplication->depositaccount)
                                                {{ titlecase($loanapplication->depositaccount->account_name) }}
                                                @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Member Deposit Summary:</strong>
                                            <span>
                                                @if ($loanapplication->companyuser)
                                                  @if ($loanapplication->companyuser->depositaccountsummary)
                                                    @if ($loanapplication->companyuser->depositaccountsummary->ledger_balance)
                                                      {{ formatCurrency($loanapplication->companyuser->depositaccountsummary->ledger_balance, 2, $loanapplication->currency->initials) }}
                                                    @endif
                                                  @else
                                                  0
                                                  @endif
                                                @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>





                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Loan Type:</strong>
                                           @if ($loanapplication->companyproduct)
                                            @if ($loanapplication->companyproduct->product)
                                              {{ $loanapplication->companyproduct->product->name }}
                                            @endif
                                          @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Loan Amount:</strong>
                                           <span class="text-primary">
                                              {{ formatCurrency($loanapplication->loan_amt, 2, $loanapplication->currency->initials) }}
                                           </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Max Loan Limit:</strong>
                                           <span
                                           @if (($loanapplication->status->id == 10) || (($loanapplication->status->id != 13)
                                           && ($loanapplication->status->id != 16)))
                                              class="text-success"
                                           @elseif ($loanapplication->status->id == 16)
                                              class="text-warning"
                                           @else
                                              class="text-danger"
                                           @endif
                                           >
                                              {{ formatCurrency($loanapplication->prime_limit_amt, 2, $loanapplication->currency->initials) }}
                                           </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Repayment Period:</strong>
                                           {{ format_num($loanapplication->term_value, 0) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Repayment Cycle:</strong>
                                           @if ($loanapplication->term)
                                              {{ $loanapplication->term->name }}
                                           @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Interest Method:</strong>
                                           @if ($loanapplication->interest_method)
                                            @if ($loanapplication->interest_method == 'flat_rate')
                                                Flat Rate
                                            @endif
                                           @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Interest Amount:</strong>
                                           @if ($loanapplication->interest_amount_full_text)
                                              {{ $loanapplication->interest_amount_full_text }}
                                           @endif
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Status:</strong>

                                            @if (($loanapplication->status->id == 10) || (($loanapplication->status->id != 13)
                                            && ($loanapplication->status->id != 16)))
                                              <span class="txt-dark text-success">
                                                  {{ $loanapplication->status->name }}
                                              </span>
                                            @elseif ($loanapplication->status->id == 5)
                                              <span class="txt-dark text-primary">
                                                  {{ $loanapplication->status->name }}
                                              </span>
                                            @elseif ($loanapplication->status->id == 16)
                                              <span class="txt-dark text-warning">
                                                  {{ $loanapplication->status->name }}
                                              </span>
                                            @else
                                              <span class="txt-dark text-danger">
                                                  {{ $loanapplication->status->name }}
                                              </span>
                                            @endif

                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($loanapplication->applied_at)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Applied At:</strong>
                                            <span>
                                             {{ formatFriendlyDate($loanapplication->applied_at) }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                    @endif

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Created At:</strong>
                                            <span>
                                             {{ formatFriendlyDate($loanapplication->created_at) }}
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

                      @if (($loanapplication->status->id != 9) && ($loanapplication->status->id != 10)
                           && ($loanapplication->status->id != 12) && ($loanapplication->status->id != 13)
                           && ($loanapplication->status->id != 16))
                        <a
                            href="{{ route('loan-applications.approve', $loanapplication->id) }}"
                            class="btn btn-success btn-block btn-outline btn-anim mt-30">
                            <i class="fa fa-pencil"></i>
                            <span class="btn-text">Approve / Reject Loan</span>
                        </a>
                      @endif

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
                          <h5>Loan Approval Details</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-lg-12">
                            <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                <li class="follow-list">
                                  <div class="follo-body">

                                    @if (($loanapplication->status->id == 10) || (($loanapplication->status->id != 13) &&
                                    ($loanapplication->status->id != 16)))

                                      <div class="text-center">
                                        <div class="panel panel-success">
                                          <div class="panel-body">
                                            <br>
                                            <h5 class="text-success">{{ $loanapplication->status->name }}</h5>
                                          </div>
                                        </div>
                                      </div>

                                    @elseif ($loanapplication->status->id == 5)

                                      <div class="text-center">
                                        <div class="panel panel-primary">
                                          <div class="panel-body">
                                            <br>
                                            <h5 class="text-primary">{{ $loanapplication->status->name }}</h5>
                                          </div>
                                        </div>
                                      </div>
                                    @elseif ($loanapplication->status->id == 16)

                                      <div class="text-center">
                                        <div class="panel panel-warning">
                                          <div class="panel-body">
                                            <br>
                                            <h5 class="text-warning">{{ $loanapplication->status->name }}</h5>
                                          </div>
                                        </div>
                                      </div>

                                    @else

                                      <div class="text-center">
                                        <div class="panel panel-danger">
                                          <div class="panel-body">
                                            <br>
                                            <h5 class="text-danger">{{ $loanapplication->status->name }}</h5>
                                          </div>
                                        </div>
                                      </div>

                                    @endif


                                    @if (($loanapplication->status->id == 10) || ($loanapplication->status->id != 13))

                                      {{-- show if loan is approved --}}
                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block">
                                            <strong>Approved Amount:</strong>
                                            <span class="text-success">
                                                {{ formatCurrency($loanapplication->approved_loan_amt, 2, $loanapplication->currency->initials) }}
                                            </span>
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block">
                                            <strong>Approved Repayment Period:</strong>
                                            {{ format_num($loanapplication->approved_term_value, 0) }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block">
                                            <strong>Approved Repayment Cycle:</strong>
                                            @if ($loanapplication->approvedterm)
                                                {{ $loanapplication->approvedterm->name }}
                                            @endif
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block">
                                            <strong>Approved By:</strong>
                                            {{ $loanapplication->approved_by_name }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>Approved At:</strong>
                                              <span>
                                              {{ formatFriendlyDate($loanapplication->approved_at) }}
                                              </span>
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      @if ($loanapplication->comments)
                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block">
                                              <strong>Comments:</strong>
                                              {{ $loanapplication->comments }}
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>
                                      @endif

                                    @else

                                        {{-- show if loan is declined --}}
                                        @if (($loanapplication->status->id == 9) || ($loanapplication->status->id == 13))
                                            <div class="follo-data">
                                              <div class="user-data">
                                                <span class="name block">
                                                  <strong>Declined By:</strong>
                                                  {{ $loanapplication->declined_by_name }}
                                                </span>
                                              </div>
                                              <div class="clearfix"></div>
                                            </div>

                                            <div class="follo-data">
                                              <div class="user-data">
                                                <span class="name block capitalize-font">
                                                    <strong>Declined At:</strong>
                                                    <span>
                                                    {{ formatFriendlyDate($loanapplication->created_at) }}
                                                    </span>
                                                </span>
                                              </div>
                                              <div class="clearfix"></div>
                                            </div>

                                            @if ($loanapplication->comments)
                                              <div class="follo-data">
                                                <div class="user-data">
                                                  <span class="name block">
                                                    <strong>Comments:</strong>
                                                    {{ $loanapplication->comments }}
                                                  </span>
                                                </div>
                                                <div class="clearfix"></div>
                                              </div>
                                            @endif

                                        @endif

                                    @endif


                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                      </div>


                      <p class="mb-20">
                          <h5>Member Stats</h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-lg-12">
                            <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                <li class="follow-list">
                                  <div class="follo-body">

                                      @if ($loanapplication->allowed_loan_amt > 0)
                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Allowed Max Loan:</strong>
                                                <span>
                                                  {{ formatCurrency($loanapplication->allowed_loan_amt) }}
                                                </span>
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>
                                      @endif

                                      @if ($loanapplication->membership_age_limit_amt)
                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Membership Age Limit Amount:</strong>
                                                <span>

                                                    {{ formatCurrency($loanapplication->membership_age_limit_amt) }}

                                                </span>
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>

                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Membership Date:</strong>
                                                <span>
                                                  {{ formatDisplayDate($loanapplication->companyuser->registration_paid_date) }}
                                                </span>
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>
                                      @endif

                                      @if ($loanapplication->membership_age_limit)
                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Membership Selected Age Limit:</strong>
                                                <span>
                                                  {{ $loanapplication->membership_age_limit }}
                                                </span>
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>
                                      @endif

                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>Current Loan Exposure Limit:</strong>
                                              <span>

                                                  @if ($loanapplication->companyuser)
                                                    @if ($loanapplication->companyuser->loanexposurelimit)
                                                      {{ $loanapplication->companyuser->loanexposurelimit->limit }}
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
                                              <strong>Loan Exposure Limit At Application:</strong>
                                              <span>
                                                {{ $loanapplication->exposure_limit_at_application }}
                                              </span>
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Member Contribution At Application:</strong>
                                                <span>
                                                    @if($loanapplication->contributions_at_application)
                                                        {{ formatCurrency($loanapplication->contributions_at_application) }}
                                                    @else
                                                    0
                                                    @endif
                                                </span>
                                            </span>
                                          </div>
                                          <div class="clearfix"></div>
                                        </div>

                                        <div class="follo-data">
                                          <div class="user-data">
                                            <span class="name block capitalize-font">
                                                <strong>Member Contribution Comments At Application:</strong>
                                                <br>
                                                <span>
                                                  {{ $loanapplication->contributions_at_application_comments }}
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

