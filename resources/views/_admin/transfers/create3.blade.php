@extends('_admin.layouts.master')


@section('title')

    Create New Funds Transfer - Step 3

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Create New Funds Transfer - Step 3</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-7 col-sm-8 col-md-8 col-xs-12">

              {!! Breadcrumbs::render('transfers.create-step3') !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell vertical-align-middlexx auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                    <form class="form-horizontal" method="POST" action="{{ route('transfers.store') }}">

                        {{ csrf_field() }}

                        <div class="col-lg-6 col-xs-12">

                            <div class="panel panel-default card-view pa-0 equalheight">

                                <div  class="panel-wrapper collapse in">

                                    <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                                        <p class="mb-20">
                                            <h5>Source Account - {{ $source_title }}</h5>
                                        </p>

                                        <hr>

                                        <div class="social-info">

                                            <div class="col-lg-12">

                                                <input type="hidden" name="source_text" value="{{ $source_text }}">
                                                <input type="hidden" name="source_title" value="{{ $source_title }}">
                                                <input type="hidden" name="source_account" value="{{ $source_account->id }}">

                                                <div class="follo-data">
                                                    <div class="user-data">
                                                        <span class="name block capitalize-font">
                                                            <span class="col-sm-12 col-lg-4">
                                                                <strong>Account Name:</strong>
                                                            </span>
                                                            <span class="col-sm-12 col-lg-8">
                                                                @if($source_account)
                                                                {{ titlecase($source_account->account_name) }}
                                                                @endif
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data mt-15">
                                                    <div class="user-data">
                                                        <span class="name block capitalize-font">
                                                            <span class="col-sm-12 col-lg-4">
                                                                <strong>Phone:</strong>
                                                            </span>
                                                            <span class="col-sm-12 col-lg-8">
                                                                @if($source_account)
                                                                {{ $source_account->phone }}
                                                                @endif
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data mt-15">
                                                    <div class="user-data">
                                                        <span class="name block capitalize-font">
                                                            <span class="col-sm-12 col-lg-4">
                                                                <strong>Account Balance:</strong>
                                                            </span>
                                                            <span class="col-sm-12 col-lg-8">
                                                                @if($source_account)
                                                                {{ formatCurrency($source_account->amount) }}
                                                                @endif
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data mt-10">
                                                    <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                                                        <input type="text" class="form-control" value="{{ old('amount') }}" name="amount"
                                                                placeholder="Enter Amount To Transfer">
                                                        @if ($errors->has('amount'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('amount') }}</strong>
                                                            </span>
                                                        @endif
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

                            <div class="panel panel-default card-view pa-0 equalheight">

                                <div  class="panel-wrapper collapse in">

                                    <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                                        <p class="mb-20">
                                            <h5>Destination Account - {{ $destination_title }}</h5>
                                        </p>

                                        <hr>

                                        <div class="social-info">

                                            <div class="col-lg-12">

                                                <input type="hidden" name="destination_text" value="{{ $destination_text }}">
                                                <input type="hidden" name="destination_title" value="{{ $destination_title }}">
                                                <input type="hidden" name="destination_account" value="{{ $destination_account->id }}">

                                                <div class="follo-data">
                                                    <div class="user-data">
                                                        <span class="name block capitalize-font">
                                                            <span class="col-sm-12 col-lg-4">
                                                                <strong>Account Name:</strong>
                                                            </span>
                                                            <span class="col-sm-12 col-lg-8">
                                                                @if($destination_account)
                                                                {{ titlecase($destination_account->account_name) }}
                                                                @endif
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data mt-15">
                                                    <div class="user-data">
                                                        <span class="name block capitalize-font">
                                                            <span class="col-sm-12 col-lg-4">
                                                                <strong>Phone:</strong>
                                                            </span>
                                                            <span class="col-sm-12 col-lg-8">
                                                                @if($destination_account)
                                                                {{ $destination_account->phone }}
                                                                @endif
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="follo-data mt-15">
                                                    <div class="user-data">
                                                        <span class="name block capitalize-font">
                                                            <span class="col-sm-12 col-lg-4">
                                                                <strong>Account Balance:</strong>
                                                            </span>
                                                            <span class="col-sm-12 col-lg-8">
                                                                @if ($destination_text == 'shares_account')
                                                                    {{ formatCurrency(getUserSharesPayments($destination_account->company_user_id)) }}
                                                                @else
                                                                    {{ formatCurrency($destination_account->amount) }}
                                                                @endif
                                                            </span>
                                                        </span>
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
                                                Submit
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
