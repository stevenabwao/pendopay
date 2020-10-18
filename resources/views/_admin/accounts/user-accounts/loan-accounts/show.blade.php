@extends('_admin.layouts.master')

@section('title')

    Showing Loan Account - {{ $loanaccount->id }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing Loan Account - {{ $loanaccount->account_no }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('loan-accounts.show', $loanaccount->account_no) !!}
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
                            Account No:
                            <span class="txt-primary">
                            {{ $loanaccount->account_no }}
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
                                                @if ($loanaccount->status->id == 14)
                                                  <span class="txt-dark text-success">
                                                      {{ titlecase($loanaccount->account_name) }}
                                                  </span>
                                                @elseif ($loanaccount->status->id == 11)
                                                  <span class="txt-dark text-primary">
                                                      {{ titlecase($loanaccount->account_name) }}
                                                  </span>
                                                @else
                                                  <span class="txt-dark text-danger">
                                                      {{ titlecase($loanaccount->account_name) }}
                                                  </span>
                                                @endif
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    @if ($loanaccount->product)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Product:</strong>
                                            <span>
                                              {{ $loanaccount->product->name }}
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
                                              {{ $loanaccount->company->name }}
                                            </span>
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>


                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Group:</strong>
                                            <span>
                                              @if ($loanaccount->group)
                                                {{ $loanaccount->group->name }}
                                              @else
                                                None
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
                                            {{ $loanaccount->currency->name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Principal Amount:</strong>
                                            {{ format_num($loanaccount->loan_amt) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Total Amount:</strong>
                                            {{ format_num($loanaccount->repayment_amt) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Loan Balance:</strong>
                                            {{ format_num($loanaccount->loan_bal) }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>Start Date:</strong>
                                              {{ formatFriendlyDate($loanaccount->start_at) }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block capitalize-font">
                                              <strong>Maturity Date:</strong>
                                              {{ formatFriendlyDate($loanaccount->maturity_at) }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>


                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block">
                                           <strong>Status:</strong>

                                            @if ($loanaccount->status->id == 14)
                                              <span class="txt-dark text-success">
                                                  {{ $loanaccount->status->name }}
                                              </span>
                                            @elseif ($loanaccount->status->id == 11)
                                              <span class="txt-dark text-primary">
                                                  {{ $loanaccount->status->name }}
                                              </span>
                                            @else
                                              <span class="txt-dark text-danger">
                                                  {{ $loanaccount->status->name }}
                                              </span>
                                            @endif


                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>



                                    @if ($loanaccount->user)
                                    <div class="follo-data">
                                      <div class="user-data">
                                        <span class="name block capitalize-font">
                                            <strong>Account User:</strong>
                                            {{ $loanaccount->user->first_name }}
                                            {{ $loanaccount->user->last_name }}
                                        </span>
                                      </div>
                                      <div class="clearfix"></div>
                                    </div>
                                    @endif

                                    <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block">
                                             <strong>Created At:</strong>
                                             {{ formatFriendlyDate($loanaccount->created_at) }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      @if ($loanaccount->created_by)
                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block">
                                             <strong>Created By:</strong>
                                             {{ $loanaccount->creator->first_name }}
                                             {{ $loanaccount->creator->last_name }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>
                                      @endif

                                      {{-- <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block">
                                             <strong>Updated At:</strong>
                                             {{ formatFriendlyDate($loanaccount->updated_at) }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>

                                      @if ($loanaccount->updated_by)
                                      <div class="follo-data">
                                        <div class="user-data">
                                          <span class="name block">
                                             <strong>Updated By:</strong>
                                             {{ $loanaccount->updater->first_name }}
                                             {{ $loanaccount->updater->last_name }}
                                          </span>
                                        </div>
                                        <div class="clearfix"></div>
                                      </div>
                                      @endif  --}}


                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>

                      </div>


                      {{-- <a
                          href="{{ route('loan-accounts.edit', $loanaccount->id) }}"
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
                          <h5><strong>Loan Repayment Schedule</strong></h5>
                      </p>

                      <hr>

                      <div class="row">
                        <div class="col-lg-12">
                            <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                <li class="follow-list">
                                  <div class="follo-body">

                                      <table class="table table-hover table-bordered mb-0">
                                          <thead>
                                              <tr>
                                                  <th>Schedule Date</th>
                                                  <th  class="text-right">Amount</th>
                                                  <th>Status</th>
                                                  <th class="text-nowrap">Paid</th>
                                                  <th></th>
                                              </tr>
                                          </thead>
                                          <tbody>

                                            @if (count($loanaccount->loanrepaymentschedules))
                                              @foreach ($loanaccount->loanrepaymentschedules as $loanrepaymentschedule)
                                                <tr>
                                                    <td>{{ formatDisplayDate($loanrepaymentschedule->repayment_at) }}</td>
                                                    <td>
                                                        @if ($loanrepaymentschedule->amount)
                                                          {{ formatCurrency($loanrepaymentschedule->amount) }}
                                                        @endif
                                                    <td>
                                                        @if ($loanrepaymentschedule->status->id == 14)
                                                          <span class="txt-dark text-success">
                                                              {{ $loanrepaymentschedule->status->name }}
                                                          </span>
                                                        @elseif ($loanrepaymentschedule->status->id == 11)
                                                          <span class="txt-dark text-primary">
                                                              {{ $loanrepaymentschedule->status->name }}
                                                          </span>
                                                        @else
                                                          <span class="txt-dark text-danger">
                                                              {{ $loanrepaymentschedule->status->name }}
                                                          </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-nowrap" align="right">

                                                        {{ $loanrepaymentschedule->paid_amt }}

                                                    </td>
                                                    <td class="text-nowrap">

                                                        @if ($loanrepaymentschedule->status->id == 14)
                                                          <i class="fa fa-check text-success"></i>
                                                        @else
                                                          <i class="fa fa-close text-danger"></i>
                                                        @endif

                                                    </td>
                                                </tr>
                                              @endforeach
                                            @endif

                                          </tbody>
                                      </table>


                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                      </div>

                      <hr>

                      <p class="mb-20">
                          <h5><strong>Loan Repayments</strong></h5>
                      </p>

                      <div class="row">
                        <div class="col-lg-12">
                            <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                <li class="follow-list">
                                  <div class="follo-body">

                                      <table class="table table-hover table-bordered mb-0">

                                        @if (count($loanrepayments))

                                          <thead>
                                              <tr>
                                                  <th width="30%">Payment Date</th>
                                                  <th width="20%" class="text-right">Amount</th>
                                                  <th width="50%">Comments</th>
                                              </tr>
                                          </thead>
                                          <tbody>

                                              @foreach ($loanrepayments as $loanrepayment)
                                                <tr>
                                                    <td>{{ formatFriendlyDate($loanrepayment->created_at) }}</td>
                                                    <td align="right">
                                                        @if ($loanrepayment->amount)
                                                          {{ formatCurrency($loanrepayment->amount) }}
                                                        @endif
                                                    </td>
                                                    <td>

                                                        {{ $loanrepayment->ref_txt }}

                                                    </td>

                                                </tr>
                                              @endforeach

                                          </tbody>

                                        @else

                                          <div class="text-center">
                                            <div class="panel panel-danger">
                                              <div class="panel-body">
                                                <br>
                                                <h5 class="text-danger">No repayments found</h5>
                                              </div>
                                            </div>
                                          </div>

                                        @endif

                                      </table>


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




