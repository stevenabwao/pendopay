@extends('_admin.layouts.master')


@section('title')

Create Funds Transfer Step 2 - Select Accounts

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

<div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Create Funds Transfer Step 2 - Select Accounts</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-7 col-sm-8 col-md-8 col-xs-12">

              {!! Breadcrumbs::render('transfers.create-step2') !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell vertical-align-middlexx auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                <form class="form-horizontal" method="GET"
                    action="{{ route('transfers.create_step3') }}">

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
                                        <div class="row">

                                            <div class="col-lg-12">

                                                <div  class="col-sm-12">

                                                    <input type="hidden" name="source_text" value="{{ $source_text }}">
                                                    <input type="hidden" name="source_title" value="{{ $source_title }}">

                                                        <div class="panel panel-default border-panel card-view">

                                                            {{-- <div class="panel-heading">

                                                            <div class="text-left">
                                                                <h5 class="panel-title txt-dark">
                                                                    <strong class="pull-left">
                                                                            Source Account
                                                                    </strong>

                                                                </h5>
                                                            </div>
                                                            <div class="clearfix"></div>

                                                            </div> --}}


                                                            <!-- <hr> -->

                                                            <div  class="panel-wrapper collapse in">
                                                                <div  class="panel-body pt-0">

                                                                    <!-- Row -->
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-sm-12">
                                                                            <div  class="tab-struct custom-tab-1 mt-0">

                                                                                <div class="{{ $errors->has('source_account') ? ' has-error' : '' }}">
                                                                                    @if ($errors->has('source_account'))
                                                                                        <span class="help-block">
                                                                                            <strong>{{ $errors->first('source_account') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="user_options nicescroll-bar">

                                                                                    <p>
                                                                                        <ul>
                                                                                            @foreach ($source_accounts as $source_account)
                                                                                            <li>
                                                                                            <div class="radio">
                                                                                                <input
                                                                                                        id="{{ $source_account->id }}"
                                                                                                        value="{{ $source_account->id }}"
                                                                                                        name="source_account"

                                                                                                        @if ($source_account->id == old('source_account'))
                                                                                                            selected="selected"
                                                                                                        @endif

                                                                                                        type="radio">
                                                                                                <label for="{{ $source_account->id }}">
                                                                                                        <strong>
                                                                                                        {{ titlecase($source_account->account_name) }}
                                                                                                        </strong>
                                                                                                        &nbsp; - &nbsp;
                                                                                                        {{ $source_account->phone }}
                                                                                                        &nbsp; - &nbsp;
                                                                                                        <em>
                                                                                                        ({{ formatCurrency($source_account->amount) }})
                                                                                                        </em>

                                                                                                        @if(($source_account->company) && (Auth::user()->hasRole('superadministrator')))
                                                                                                            &nbsp; - &nbsp; ({{ $source_account->company->name }})
                                                                                                        @endif


                                                                                                </label>
                                                                                            </div>
                                                                                            </li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </p>


                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <!-- /Row -->

                                                                </div>
                                                            </div>

                                                        </div>

                                                </div>

                                                <div class="clearfix"></div>

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
                                        <h5>Destination Account - {{ $destination_title }}</h5>
                                    </p>

                                    <hr>

                                    <div class="social-info">
                                        <div class="row">

                                            <div class="col-lg-12">

                                                <div  class="col-sm-12">

                                                    <input type="hidden" name="destination_text" value="{{ $destination_text }}">
                                                    <input type="hidden" name="destination_title" value="{{ $destination_title }}">

                                                        <div class="panel panel-default border-panel card-view">

                                                            <div  class="panel-wrapper collapse in">
                                                                <div  class="panel-body pt-0">

                                                                    <!-- Row -->
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-sm-12">
                                                                            <div  class="tab-struct custom-tab-1 mt-0">

                                                                                <div class="{{ $errors->has('destination_account') ? ' has-error' : '' }}">
                                                                                    @if ($errors->has('destination_account'))
                                                                                        <span class="help-block">
                                                                                            <strong>{{ $errors->first('destination_account') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div>

                                                                                <div class="user_options nicescroll-bar">

                                                                                    <p>
                                                                                        <ul>
                                                                                            @foreach ($destination_accounts as $destination_account)
                                                                                            <li>
                                                                                                <div class="radio">
                                                                                                    <input
                                                                                                            id="{{ $destination_account->id }}"
                                                                                                            value="{{ $destination_account->id }}"
                                                                                                            name="destination_account"

                                                                                                            @if ($destination_account->id == old('destination_account'))
                                                                                                                selected="selected"
                                                                                                            @endif

                                                                                                            type="radio">
                                                                                                    <label for="{{ $destination_account->id }}">
                                                                                                            <strong>
                                                                                                            {{ titlecase($destination_account->account_name) }}
                                                                                                            </strong>
                                                                                                            &nbsp; - &nbsp;
                                                                                                            {{ $destination_account->phone }}
                                                                                                            &nbsp; - &nbsp;
                                                                                                            <em>
                                                                                                                @if ($destination_text == 'shares_account')
                                                                                                                    ({{ formatCurrency(getUserSharesPayments($destination_account->company_user_id)) }})
                                                                                                                @else
                                                                                                                    ({{ formatCurrency($destination_account->amount) }})
                                                                                                                @endif
                                                                                                            </em>

                                                                                                            @if(($destination_account->company) && (Auth::user()->hasRole('superadministrator')))
                                                                                                                &nbsp; - &nbsp; ({{ $destination_account->company->name }})
                                                                                                            @endif


                                                                                                    </label>
                                                                                                </div>
                                                                                            </li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </p>

                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <!-- /Row -->

                                                                </div>
                                                            </div>

                                                        </div>

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

  <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  <script type="text/javascript">

      var app = new Vue({
        el: "#app"

      });

  </script>

  @include('_admin.layouts.partials.error_messages')

@endsection
