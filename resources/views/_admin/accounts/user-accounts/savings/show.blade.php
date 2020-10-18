@extends('_admin.layouts.master')

@section('title')

    Showing User Savings Account - {{ $account->account_no }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing User Savings Account - {{ $account->account_no }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('user-savings-accounts.show', $account->account_no) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
        <div class="row mt-15">


          @include('_admin.layouts.partials.error_text')


          <div class="col-xs-12">

              <div class="panel panel-default card-view pa-0 equalheight">

                <div  class="panel-wrapper collapse in">

                   <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                    <!-- Row -->
                    <div class="row">
                        <div class="col-md-12">
                          <div class="panel panel-default card-view">

                            <div class="panel-wrapper collapse in">
                              <div class="panel-body">
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-wrap top-form">
                                      <form class="form-horizontal" role="form">
                                        <div class="form-body">

                                            @if (!$account->depositaccounts))

                                                <h5 class="text-danger">
                                                    No Deposit Accounts found
                                                </h5>

                                            @else

                                                @foreach ($account->depositaccounts as $depositaccount)

                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label class="control-label col-md-6">Account Name:</label>
                                                        <div class="col-md-6">
                                                          <p class="form-control-static"> {{ titlecase($account->account_name) }} </p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!--/span-->
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label class="control-label col-md-6">Phone:</label>
                                                        <div class="col-md-6">
                                                          <p class="form-control-static"> {{ $account->phone }} </p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!--/span-->
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label class="control-label col-md-6">Ledger Balance:</label>
                                                        <div class="col-md-6">
                                                          <p class="form-control-static">
                                                            @if ($depositaccount->depositaccountsummary)
                                                              {{ formatCurrency($depositaccount->depositaccountsummary->ledger_balance) }}
                                                            @else
                                                              Ksh 0
                                                            @endif
                                                          </p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!--/span-->
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label class="control-label col-md-6">Last Deposit Date:</label>
                                                        <div class="col-md-6">
                                                          <p class="form-control-static">
                                                              @if ($depositaccount->depositaccountsummary)
                                                                {{ formatFriendlyDate($depositaccount->depositaccountsummary->last_deposit_date) }}
                                                              @endif
                                                          </p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!--/span-->
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label class="control-label col-md-6">Last Deposit Amount:</label>
                                                        <div class="col-md-6">
                                                          <p class="form-control-static">
                                                              @if ($depositaccount->depositaccountsummary)
                                                                {{ formatCurrency($depositaccount->depositaccountsummary->last_deposit_amount) }}
                                                              @else
                                                                None
                                                              @endif
                                                          </p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!--/span-->
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label class="control-label col-md-6">Currency:</label>
                                                        <div class="col-md-6">
                                                          <p class="form-control-static">
                                                              @if ($account->currency)
                                                              {{ $account->currency->name }}
                                                              @endif
                                                          </p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!--/span-->
                                                  </div>
                                                  <!-- /Row -->
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label class="control-label col-md-6">Company:</label>
                                                        <div class="col-md-6">
                                                          <p class="form-control-static"> {{ $account->company->name }} </p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!--/span-->
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label class="control-label col-md-6">Group:</label>
                                                        <div class="col-md-6">
                                                          <p class="form-control-static">
                                                            @if ($account->group)
                                                              {{ $account->group->name }}
                                                            @else
                                                              None
                                                            @endif </p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!--/span-->
                                                  </div>
                                                  <!-- /Row -->
                                                  <div class="row">
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label class="control-label col-md-6">Status:</label>
                                                        <div class="col-md-6">
                                                          <p class="form-control-static">
                                                              @if ($account->status->id == 1)
                                                                <span class="txt-dark text-success">
                                                                    {{ $account->status->name }}
                                                                </span>
                                                              @else
                                                                <span class="txt-dark text-danger">
                                                                    {{ $account->status->name }}
                                                                </span>
                                                              @endif
                                                          </p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!--/span-->
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label class="control-label col-md-6">Account User:</label>
                                                        <div class="col-md-6">
                                                          <p class="form-control-static">
                                                              {{ titlecase($account->user->first_name) }}
                                                              {{ titlecase($account->user->last_name) }}
                                                          </p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!--/span-->
                                                  </div>
                                                  <!-- /Row -->

                                                @endforeach

                                            @endif

                                        </div>

                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /Row -->

                      <h5>Account Deposits</h5>
                      <hr>

                      @if (!count($depositaccountshistory))

                          <hr>

                          <div class="panel-heading panel-heading-dark">
                              <div class="alert alert-danger text-center">
                                  No deposit records found
                              </div>
                          </div>

                      @else

                          <div class="panel-wrapper collapse in">
                            <div class="panel-body row pa-0">
                                <div class="table-wrap">
                                  <div class="table-responsive">
                                      <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                              <th width="5%">ID</th>
                                              <th width="20%">Account Name</th>
                                              <th width="15%" class="text-right">Amount</th>
                                              <th width="15%">Currency</th>
                                              <th width="20%">Company/ Sacco</th>
                                              <th width="15%">Created At</th>
                                              <th width="10%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($depositaccountshistory as $depaccounthistory)
                                              <tr>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $depaccounthistory->id }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    @if ($depaccounthistory->depositaccountsummary)
                                                      @if ($depaccounthistory->depositaccountsummary->depositaccount)
                                                        {{ titlecase($depaccounthistory->depositaccountsummary->depositaccount->account_name) }}
                                                      @endif
                                                    @endif
                                                  </span>
                                                </td>

                                                <td align="right">
                                                    <span class="txt-dark">
                                                      {{ format_num($depaccounthistory->amount) }}
                                                    </span>
                                                  </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    @if ($depaccounthistory->currency)
                                                      {{ $depaccounthistory->currency->name }}
                                                    @endif
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    @if ($depaccounthistory->depositaccountsummary)
                                                      @if ($depaccounthistory->depositaccountsummary->company)
                                                        {{ $depaccounthistory->depositaccountsummary->company->name }}
                                                      @endif
                                                    @endif
                                                  </span>
                                                </td>



                                                <td>
                                                    <span class="txt-dark">
                                                    {{ formatFriendlyDate($depaccounthistory->created_at) }}
                                                    </span>
                                                </td>

                                                <td>

                                                    <a href="{{ route('deposit-accounts-history.show', $depaccounthistory->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-eye"></i>
                                                    </a>

                                                    {{-- <a href="{{ route('deposit-accounts-history.edit', $depaccounthistory->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-edit"></i>
                                                    </a> --}}

                                                    {{-- <a href="{{ route('deposit-accounts-history.destroy', $depaccounthistory->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-delete"></i>
                                                    </a> --}}

                                                </td>
                                              </tr>
                                            @endforeach

                                        </tbody>
                                      </table>
                                  </div>
                                </div>
                                <hr>
                                <div class="text-center mb-20">

                                    {{ $depositaccountshistory->links() }}

                                </div>
                            </div>
                          </div>

                      @endif

                    </div>

                </div>

              </div>
            </div>

        <!-- /Row -->

    </div>

@endsection




