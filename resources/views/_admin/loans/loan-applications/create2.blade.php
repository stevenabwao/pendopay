@extends('_admin.layouts.master')

@section('title')

    Create Loan Application - Step 2

@endsection

@section('css_header')

    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create Loan Application - Step 2</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('loan-applications.create_step2') !!}
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
                                    <h3 class="text-center txt-dark mb-10">Create Loan Application - Step 2</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('loan-applications.store') }}">

                                       {{ csrf_field() }}

                                       <div  class="form-group">

                                          <label for="company_id" class="col-sm-4 control-label">
                                             Company Name
                                          </label>
                                          <div class="col-sm-8">
                                             <input class="form-control" value="{{ $company->name }}" readonly="">
                                             <input type="hidden" name="company_id" value="{{ $company->id }}">
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('deposit_account_id') ? ' has-error' : '' }}">

                                          <label for="deposit_account_id" class="col-sm-4 control-label">
                                             Deposit Account
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-8" id="deposit_account_loader_div">

                                             <select class="selectpicker form-control"
                                                name="deposit_account_id"  id="deposit_account_data_div"
                                                data-style="form-control btn-default btn-outline" required>

                                                @foreach ($deposit_accounts as $depacct)
                                                <li class="mb-10">
                                                    <option value="{{ $depacct->id }}"
                                                        @if ($depacct->id == old('deposit_account_id', $depacct->id))
                                                            selected="selected"
                                                        @endif
                                                    >{{ $depacct->account_no }} - {{ $depacct->account_name }} - {{ $depacct->company->name }}
                                                    </option>
                                                </li>
                                                @endforeach

                                             </select>

                                             @if ($errors->has('deposit_account_id'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('deposit_account_id') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('company_product_id') ? ' has-error' : '' }}">

                                          <label for="company_product_id" class="col-sm-4 control-label">
                                             Loan Product
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-8">

                                             <select class="selectpicker form-control"
                                                name="company_product_id"  id="company_product_id"
                                                data-style="form-control btn-default btn-outline" required>

                                                @foreach ($companyproducts as $product)
                                                <li class="mb-10">
                                                    <option value="{{ $product->id }}"
                                                        @if ($product->id == old('company_product_id', $product->id))
                                                            selected="selected"
                                                        @endif
                                                    >{{ $product->name }}
                                                    </option>
                                                </li>
                                                @endforeach

                                             </select>

                                             @if ($errors->has('company_product_id'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('company_product_id') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div>


                                       <div  class="form-group{{ $errors->has('loan_amt') ? ' has-error' : '' }}">

                                          <label for="loan_amt" class="col-sm-4 control-label">
                                             Loan Amount
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-8">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="loan_amt"
                                                name="loan_amt"
                                                value="{{ old('loan_amt') }}" required>

                                             @if ($errors->has('loan_amt'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('loan_amt') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       {{-- <div  class="form-group{{ $errors->has('prime_limit_amt') ? ' has-error' : '' }}">

                                          <label for="prime_limit_amt" class="col-sm-4 control-label">
                                             Loan Limit
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-8">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="prime_limit_amt"
                                                name="prime_limit_amt"
                                                value="{{ old('prime_limit_amt', '100000') }}"
                                                readonly required>

                                             @if ($errors->has('prime_limit_amt'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('prime_limit_amt') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('term_value') ? ' has-error' : '' }}">

                                          <label for="term_value" class="col-sm-4 control-label">
                                             Repayment Period
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-8">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="term_value"
                                                name="term_value"
                                                value="{{ old('term_value', '12') }}" required>

                                             @if ($errors->has('term_value'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('term_value') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('term_id') ? ' has-error' : '' }}">

                                          <label for="term_id" class="col-sm-4 control-label">
                                             Repayment Cycle
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-8">

                                             <select class="selectpicker form-control"
                                                name="term_id"  id="term_id"
                                                data-style="form-control btn-default btn-outline" required>

                                                @foreach ($terms as $term)
                                                <li class="mb-10">
                                                    <option value="{{ $term->id }}"
                                                        @if ($term->id == old('term_id', $term->id))
                                                            selected="selected"
                                                        @endif
                                                    >{{ $term->name }}
                                                    </option>
                                                </li>
                                                @endforeach

                                             </select>

                                             @if ($errors->has('term_id'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('term_id') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div> --}}

                                       <br/>

                                       <div class="form-group">
                                          <div class="col-sm-4"></div>
                                          <div class="col-sm-8">
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

@endsection
