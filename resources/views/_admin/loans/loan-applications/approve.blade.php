@extends('_admin.layouts.master')

@section('title')

    Approve Loan Application - {{ $loanapplication->id }}

@endsection

@section('css_header')

    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection

@section('page_css')

    <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Approve Loan Application - {{ $loanapplication->id }}</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('loan-applications.approve', $loanapplication->id) !!}
          </div>
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
                                    <h3 class="text-center txt-dark mb-10">Approve Loan Application - {{ $loanapplication->id }}</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('loan-applications.loanapprove', $loanapplication->id) }}"  data-parsley-validate>

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div  class="form-group">

                                          <label for="company_id" class="col-sm-4 control-label">
                                             Created At
                                          </label>
                                          <div class="col-sm-8">
                                             <input class="form-control" value="{{ formatFriendlyDate($loanapplication->created_at) }}" readonly>
                                          </div>

                                        <input type="hidden" name="loan_application_id" value="{{ $loanapplication->id }}">

                                       </div>

                                       <div  class="form-group">


                                          <label for="company_id" class="col-sm-4 control-label">
                                             Company Name
                                          </label>
                                          <div class="col-sm-8">
                                             <input class="form-control" value="{{ $loanapplication->company->name }}" readonly>
                                          </div>

                                       </div>

                                       <div  class="form-group">

                                          <label for="deposit_account_id" class="col-sm-4 control-label">
                                             Deposit Account
                                          </label>
                                          <div class="col-sm-8">
                                             <input class="form-control"
                                             value="{{ $loanapplication->depositaccount->account_no }} - {{ $loanapplication->depositaccount->account_name }}"
                                             readonly>
                                          </div>

                                       </div>



                                       <div  class="form-group">

                                          <label for="product_id" class="col-sm-4 control-label">
                                             Loan Type
                                          </label>
                                          <div class="col-sm-8">

                                             <input class="form-control"
                                             value="{{ $loanapplication->companyproduct->product->name }}"
                                             readonly>

                                          </div>

                                       </div>


                                       <div  class="form-group">

                                          <label for="loan_amt" class="col-sm-4 control-label">
                                             Loan Amount
                                          </label>
                                          <div class="col-sm-8">
                                            <input
                                                type="text"
                                                class="form-control text-primary"
                                                value="{{ format_num($loanapplication->loan_amt) }}" readonly>
                                          </div>

                                       </div>

                                       <div  class="form-group">

                                          <label for="repayment_period" class="col-sm-4 control-label">
                                             Repayment Period
                                          </label>
                                          <div class="col-sm-4">
                                            <input
                                                type="text"
                                                class="form-control"
                                                value="{{ $loanapplication->term_value }}" readonly>
                                          </div>

                                          <div class="col-sm-4">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    value="{{ $loanapplication->term->name }}" readonly>
                                              </div>

                                       </div>

                                       <hr>

                                       <div  class="form-group{{ $errors->has('approved_loan_amt') ? ' has-error' : '' }}">

                                          <label for="approved_loan_amt" class="col-sm-4 control-label">
                                             Approved Loan Amount
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-8">
                                            <input
                                                type="text"
                                                class="form-control digitsOnly"
                                                id="approved_loan_amt"
                                                name="approved_loan_amt"
                                                value="{{ old('approved_loan_amt', $loanapplication->loan_amt) }}"
                                                 required>

                                             @if ($errors->has('approved_loan_amt'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('approved_loan_amt') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('approved_term_value') ? ' has-error' : '' }}">

                                          <label for="approved_term_value" class="col-sm-4 control-label">
                                             Approved Repayment Period
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-4">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="approved_term_value"
                                                name="approved_term_value"
                                                value="{{ old('approved_term_value', $loanapplication->term_value) }}" required>

                                             @if ($errors->has('approved_term_value'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('approved_term_value') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                          <div class="col-sm-4">
                                                <select class="selectpicker form-control"
                                                    name="approved_term_id"  id="approved_term_id"
                                                    data-style="form-control btn-default btn-outline" required>

                                                    @foreach ($terms as $term)
                                                    <li class="mb-10">
                                                        <option value="{{ $term->id }}"
                                                            @if ($term->id == old('approved_term_id', $loanapplication->term_id))
                                                                selected="selected"
                                                            @endif
                                                        >{{ $term->name }}
                                                        </option>
                                                    </li>
                                                    @endforeach

                                                </select>

                                                @if ($errors->has('approved_term_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('approved_term_id') }}</strong>
                                                    </span>
                                                @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('comments') ? ' has-error' : '' }}">

                                          <label for="comments" class="col-sm-4 control-label">
                                             Comments
                                          </label>
                                          <div class="col-sm-8">
                                            <textarea
                                                rows="4"
                                                class="form-control"
                                                id="comments"
                                                name="comments">{{ old('comments') }}</textarea>

                                             @if ($errors->has('comments'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('comments') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <hr/>

                                       <div class="form-group">
                                          <div class="col-sm-4"></div>
                                          <div class="col-sm-8">
                                              <div class="col-sm-6">
                                                <button
                                                  type="submit"
                                                  class="btn btn-lg btn-success btn-block mr-10"
                                                   name="submit_btn" value="approve">
                                                   Approve Loan
                                                </button>
                                              </div>
                                              <div class="col-sm-6">
                                                <button
                                                  type="submit"
                                                  class="btn btn-lg btn-danger btn-block mr-10"
                                                   name="submit_btn" value="decline">
                                                   Decline Loan
                                                </button>
                                              </div>

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
  <script src="{{ asset('js/parsley.js') }}"></script>

@endsection
