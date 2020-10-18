@extends('_admin.layouts.master')


@section('title')

    Create New Funds Transfer

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Create New Funds Transfer</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

              {!! Breadcrumbs::render('transfers.create') !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell vertical-align-middlexx auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                    <form class="form-horizontal" method="GET"
                    action="{{ route('transfers.create_step2') }}">

                        {{ csrf_field() }}

                        <div class="col-lg-6 col-xs-12">

                            <div class="panel panel-default card-view pa-0 equalheightz">

                                <div  class="panel-wrapper collapse in">

                                    <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                                        <p class="mb-20">
                                            <h5>Source Account</h5>
                                        </p>

                                        <hr>

                                        <div class="social-info">

                                            <div class="col-lg-12">

                                                <div class="follo-data">
                                                    <div class="user-data">
                                                        <select class="selectpicker form-control"
                                                            name="source_account"
                                                            data-style="form-control btn-default btn-outline"
                                                            required>

                                                                <li class="mb-10">
                                                                    <option value="deposit_account"
                                                                        @if ('deposit_account' == old('source_account', 'deposit_account'))
                                                                            selected="selected"
                                                                        @endif
                                                                        >Deposit Account</option>
                                                                </li>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="follo-data mt-10">
                                                    <div class="user-data">
                                                        <input type="text" class="form-control" name="source_account_search" placeholder="Search Account">
                                                    </div>
                                                </div>

                                                <div class="clearfix"></div>

                                            </div>


                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6 col-xs-12">

                            <div class="panel panel-default card-view pa-0 equalheightz">

                                <div  class="panel-wrapper collapse in">

                                    <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                                        <p class="mb-20">
                                            <h5>Destination Account</h5>
                                        </p>

                                        <hr>

                                        <div class="social-info">

                                            <div class="col-lg-12">


                                                <div class="follo-data">
                                                    <div class="user-data">
                                                        <select class="selectpicker form-control"
                                                            name="destination_account"
                                                            data-style="form-control btn-default btn-outline"
                                                            required>

                                                                <li class="mb-10">
                                                                    <option value="deposit_account"
                                                                        @if ('deposit_account' == old('destination_account', 'deposit_account'))
                                                                            selected="selected"
                                                                        @endif
                                                                        >Deposit Account</option>
                                                                </li>

                                                                <li class="mb-10">
                                                                    <option value="loan_account"
                                                                        @if ('loan_account' == old('destination_account', 'loan_account'))
                                                                            selected="selected"
                                                                        @endif
                                                                        >Loan Account</option>
                                                                </li>

                                                                <li class="mb-10">
                                                                    <option value="shares_account"
                                                                        @if ('shares_account' == old('destination_account', 'shares_account'))
                                                                            selected="selected"
                                                                        @endif
                                                                        >Shares Account</option>
                                                                </li>

                                                        </select>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data mt-10">
                                                    <div class="user-data">
                                                        <input type="text" class="form-control" name="destination_account_search" placeholder="Search Account">
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>


                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="clearfix"></div>

                        <div class="col-xs-12">
                            <div class="panel panel-default card-view pa-0">
                                <div  class="panel-wrapper collapse in">
                                    <div  class="panel-body pb-0 ml-20 mr-0 mb-10 mt-10">
                                        <div class="col-lg-6 col-xs-12"></div>
                                        <div class="col-lg-6 col-xs-12">
                                            <button class="btn btn-primary pull-right btn-block">
                                                Next &nbsp;&nbsp;&nbsp; <i class="fa fa-angle-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

             </div>
          </div>
       </div>
       <!-- /Row -->


    </div>


@endsection


@section('page_scripts')

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  @include('_admin.layouts.partials.error_messages')

@endsection
