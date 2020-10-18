@extends('_admin.layouts.master')


@section('title')

    Edit Payment - {{ $payment->id }} - {{ $payment->full_name }}

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Edit Payment - {{ $payment->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-6 col-sm-8 col-md-8 col-xs-12">
              {!! Breadcrumbs::render('payments.edit', $payment->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                <div  class="col-sm-12 col-md-8 col-md-offset-2">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">

                        <div class="panel panel-default card-view">

                           <div class="panel-wrapper collapse in">

                              <div class="panel-body">

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">
                                        Edit Payment - {{ $payment->id }}
                                    </h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('payments.update', $payment->id) }}">

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div  class="form-group">

                                          <label for="acct_no" class="col-sm-3 control-label">
                                             <strong>Full Name</strong>
                                          </label>
                                          <div class="col-sm-9">
                                            <label for="acct_no" class="control-label text-left">
                                               {{ $payment->full_name }}
                                            </label>
                                          </div>

                                       </div>

                                       <div  class="form-group">

                                          <label for="acct_no" class="col-sm-3 control-label">
                                             <strong>Phone No</strong>
                                          </label>
                                          <div class="col-sm-9">
                                            <label for="acct_no" class="control-label text-left">
                                               {{ $payment->phone }}
                                            </label>
                                          </div>

                                       </div>

                                       <div  class="form-group">

                                          <label for="acct_no" class="col-sm-3 control-label">
                                             <strong>Trans ID</strong>
                                          </label>
                                          <div class="col-sm-9">
                                            <label for="acct_no" class="control-label text-left">
                                               {{ $payment->trans_id }}
                                            </label>
                                          </div>

                                       </div>

                                       <hr>

                                       <div  class="form-group">

                                          <label for="acct_no" class="col-sm-3 control-label">
                                             <strong>Amount</strong>
                                          </label>
                                          <div class="col-sm-9">
                                            <label for="acct_no" class="control-label text-left">
                                               {{ format_num($payment->amount) }}
                                            </label>
                                          </div>

                                       </div>

                                       <div  class="form-group">

                                          <label for="acct_no" class="col-sm-3 control-label">
                                             <strong>Paid at</strong>
                                          </label>
                                          <div class="col-sm-9">
                                            <label for="acct_no" class="control-label text-left">
                                               {{ formatFriendlyDate($payment->created_at) }}
                                            </label>
                                          </div>

                                       </div>

                                       <div  class="form-group">

                                          <label for="acct_no" class="col-sm-3 control-label">
                                             <strong>Paybill No</strong>
                                          </label>
                                          <div class="col-sm-9">
                                            <label for="acct_no" class="control-label text-left">
                                               {{ $payment->paybill_number }}
                                            </label>
                                          </div>

                                       </div>

                                       <hr>

                                       <div  class="form-group{{ $errors->has('account_no') ? ' has-error' : '' }}">

                                          <label for="account_no" class="col-sm-3 control-label">
                                             Account No
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="account_no"
                                                name="account_no"
                                                value="{{ old('account_no', $payment->account_no)}}"
                                                required autofocus>

                                             @if ($errors->has('account_no'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('account_no') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>


                                       <div class="form-group">
                                          <div class="col-sm-3"></div>
                                          <div class="col-sm-9">
                                              <button
                                                type="submit"
                                                class="btn btn-lg btn-primary btn-block mr-10"
                                                 id="submit-btn">
                                                 Submit
                                              </button>
                                          </div>
                                       </div>

                                       <br/>

                                    </form>

                                 </div>

                              </div>

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


@section('page_scripts')

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  @include('_admin.layouts.partials.error_messages')

@endsection
