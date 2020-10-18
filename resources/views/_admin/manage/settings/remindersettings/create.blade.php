@extends('_admin.layouts.master')

@section('title')

    Create Company Product

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create Company Product</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('companyproducts.create') !!}
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
                                    <h3 class="text-center txt-dark mb-10">Create Company Product</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('companyproducts.store') }}">

                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                          <label for="name" class="col-sm-3 control-label">
                                             Name
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                name="name"
                                                value="{{ old('name') }}">

                                             @if ($errors->has('name'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('name') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">

                                            <label for="company_id" class="col-sm-3 control-label">
                                               Company Name
                                               <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                               <select class="selectpicker form-control"
                                                  name="company_id"
                                                  data-style="form-control btn-default btn-outline"
                                                  required>

                                                  @foreach ($companies as $company)
                                                  <li class="mb-10">
                                                  <option value="{{ $company->id }}"
                                            @if ($company->id == old('company_id', $company->id))
                                                selected="selected"
                                            @endif
                                                      >
                                                        {{ $company->name }}
                                                      </option>
                                                  </li>
                                                  @endforeach

                                               </select>

                                               @if ($errors->has('company_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('company_id') }}</strong>
                                                    </span>
                                               @endif

                                            </div>

                                        </div>

                                        <div  class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">

                                                <label for="product_id" class="col-sm-3 control-label">
                                                   Product Type
                                                   <span class="text-danger"> *</span>
                                                </label>
                                                <div class="col-sm-9">

                                                   <select class="selectpicker form-control"
                                                      name="product_id"
                                                      data-style="form-control btn-default btn-outline"
                                                      required>

                                                      @foreach ($products as $product)
                                                      <li class="mb-10">
                                                      <option value="{{ $product->id }}"
                                                @if ($product->id == old('product_id', $product->id))
                                                    selected="selected"
                                                @endif
                                                          >
                                                            {{ $product->name }}
                                                          </option>
                                                      </li>
                                                      @endforeach

                                                   </select>

                                                   @if ($errors->has('product_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('product_id') }}</strong>
                                                        </span>
                                                   @endif

                                                </div>

                                            </div>

                                       <div  class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">

                                          <label for="status_id" class="col-sm-3 control-label">
                                             Status
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">

                                             <select class="selectpicker form-control"
                                                name="status_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($statuses as $status)
                                                <li class="mb-10">
                                                <option value="{{ $status->id }}"

                                          @if ($status->id == old('status_id', '1'))
                                              selected="selected"
                                          @endif
                                                    >
                                                      {{ $status->name }}
                                                    </option>
                                                </li>
                                                @endforeach

                                             </select>

                                             @if ($errors->has('status_id'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('status_id') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div>


                                       <hr/>

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



        <section class="content">
            <div class="box box-info" data-select2-id="6">
            <form action="https://x.loandisk.com/loans/add_loan.php" class="form-horizontal" method="post" enctype="multipart/form-data" name="form" id="form" data-select2-id="form">
                <input type="hidden" name="back_url" value="">
                <input type="hidden" name="left_menu_add_loan" value="1">
                <input type="hidden" name="borrower_id" value="">
                <input type="hidden" name="add_loan" value="1">
                <div class="box-body" data-select2-id="5">
                    <div class="form-group">
                        <label for="inputLoanType" class="col-sm-3 control-label">Loan Product</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="loan_product_id" id="inputLoanType" onchange="window.location.href = &#39;https://x.loandisk.com/loans/add_loan.php?left_menu_add_loan=1&amp;loan_product_id=&#39; + this.value">
                                <option value="26918" selected="">Business Loan</option>
                                <option value="26920">Overseas Worker Loan</option>
                                <option value="26921">Pensioner Loan</option>
                                <option value="26917">Personal Loan</option>
                                <option value="26919">Student Loan</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                        <div class="pull-left" style="margin-top:5px">
                                <a href="https://x.loandisk.com/admin/view_loan_products.php" target="_blank">Add/Edit Loan Products</a>
                        </div>
                        </div>
                    </div>
                        <div class="form-group">
                            <label for="inputBorrowerId" class="col-sm-3 control-label">Borrower</label>
                            <div class="col-sm-6">
                                <select class="form-control select2 select2-hidden-accessible" name="borrower_id" id="inputBorrowerId" style="width: 100%;" required="" data-select2-id="inputBorrowerId" tabindex="-1" aria-hidden="true">
                                    <option value="" data-select2-id="2"></option>
                                    <option value="470925" data-select2-id="7">Peter  Apollo - Swift Systems - 1000002</option>
                                </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="1" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-inputBorrowerId-container"><span class="select2-selection__rendered" id="select2-inputBorrowerId-container" role="textbox" aria-readonly="true" title="Peter  Apollo - Swift Systems - 1000002">Peter  Apollo - Swift Systems - 1000002</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                            </div>
                        </div>
                    <div class="form-group">

                        <label for="inputLoanApplicationId" class="col-sm-3 control-label">Loan #</label>
                        <div class="col-sm-6">
                            <input type="text" name="loan_application_id" class="form-control" id="inputLoanApplicationId" required="" value="1000001">
                        </div>
                        <div class="col-sm-3">
                        <div class="pull-left" style="margin-top:5px">
                                <a href="https://x.loandisk.com/admin/add_branch.php?edit_branch=1&amp;branch_id=6288#generate_unique_loan_numbers" target="_blank">Set Custom Loan #</a>
                        </div>
                        </div>
                    </div>
                    <hr>
                    <div class="panel panel-default"><div class="panel-body bg-gray text-bold">Loan Terms (required fields):</div></div>
                    <h5 class="text-red text-bold">Principal:</h5>
                    <div class="form-group">
                        <label for="inputDisbursedById" class="col-sm-3 control-label">Disbursed By</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="loan_disbursed_by_id" id="inputDisbursedById" required="">
                                <option value="20693">Cash</option>
                                <option value="20694">Cheque</option>
                                <option value="20695">Wire Transfer</option>
                                <option value="20696">Online Transfer</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                        <div class="pull-left" style="margin-top:5px">
                                <a href="https://x.loandisk.com/admin/view_loan_disbursed_by.php" target="_blank">Add/Edit Disbursed By</a>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="inputLoanPrincipalAmount" class="col-sm-3 control-label">Principal Amount</label>
                        <div class="col-sm-6">
                            <input type="text" name="loan_principal_amount" class="form-control decimal-2-places" id="inputLoanPrincipalAmount" placeholder="Principal Amount" required="" value="">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLoanReleasedDate" class="col-sm-3 control-label">Loan Release Date</label>
                        <div class="col-sm-6">
                            <input type="text" name="loan_released_date" class="form-control date_select is-datepick" id="inputLoanReleasedDate" placeholder="dd/mm/yyyy" value="" required="">
                        </div>
                    </div>
                    <hr>
                    <h5 class="text-red text-bold">Interest:</h5>
                    <div class="form-group">
                        <label for="inputLoanInterestMethod" class="col-sm-3 control-label">Interest Method</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="loan_interest_method" id="inputLoanInterestMethod" required="" onchange="enableDisableMethod();">
                                <option value="flat_rate"> Flat Rate</option>
                                <option value="reducing_rate_equal_installments">Reducing Balance - Equal Installments</option>
                                <option value="reducing_rate_equal_principal">Reducing Balance - Equal Principal</option>
                                <option value="interest_only">Interest-Only</option>
                                <option value="compound_interest">Compound Interest</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLoanInterestType" class="col-sm-3 control-label">Interest Type</label>
                        <div class="col-sm-6">
                            <div class="radio">
                                <label>
                                <input type="radio" name="loan_interest_type" id="inputInterestTypePercentage" value="percentage" onclick="checkITPRRadio()" checked=""> I want Interest to be percentage % based

                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                <input type="radio" name="loan_interest_type" id="inputInterestTypeFixed" value="fixed" onclick="checkITPRRadio()"> I want Interest to be a fixed amount Per Cycle

                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLoanInterest" id="inputLoanInterestLabel" class="col-sm-3 control-label">Loan Interest %</label>
                        <div class="col-sm-3">
                            <input type="text" name="loan_interest" class="form-control decimal-4-places" id="inputLoanInterest" placeholder=" %" value="" required="">

                        </div>
                        <div class="col-sm-3">
                            <select class="form-control" name="loan_interest_period" id="inputInterestPeriod" onchange="check();">
                                <option value="Day">Per Day</option>
                                <option value="Week">Per Week</option>
                                <option value="Month">Per Month</option>
                                <option value="Year">Per Year</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h5 class="text-red text-bold">Duration:</h5>
                    <div class="form-group">

                        <label for="inputLoanDuration" class="col-sm-3 control-label">Loan Duration</label>
                        <div class="col-sm-3">
                            <div class="input-group bootstrap-touchspin"><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-down" type="button">-</button></span><span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span><input class="form-control positive-integer" name="loan_duration" id="inputLoanDuration" value="1" type="text" min="1" max="730" required="" onchange="setNumofRep();" oninput="setNumofRep();" style="display: block;"><span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-up" type="button">+</button></span></div>


                        </div>
                        <div class="col-sm-3">
                            <select class="form-control" name="loan_duration_period" id="inputLoanDurationPeriod" required="" onchange="setNumofRep();">
                                <option value=""></option>
                                <option value="Days">Days</option>
                                <option value="Weeks">Weeks</option>
                                <option value="Months">Months</option>
                                <option value="Years">Years</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h5 class="text-red text-bold">Repayments:</h5>
                    <div class="form-group">
                        <label for="inputLoanPaymentSchemeId" class="col-sm-3 control-label">Repayment Cycle</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="loan_payment_scheme_id" id="inputLoanPaymentSchemeId" required="" onchange=" disableNumRepayments(); setNumofRep();">
                                <option value=""></option>
                                <option value="6">Daily</option>
                                <option value="4">Weekly</option>
                                <option value="9">Biweekly</option>
                                <option value="3">Monthly</option>
                                <option value="12">Bimonthly</option>
                                <option value="13">Quarterly</option>
                                <option value="14">Semi-Annual</option>
                                <option value="11">Yearly</option>
                                <option value="10">Lump-Sum</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                        <div class="pull-left" style="margin-top:5px">
                                <a href="https://x.loandisk.com/admin/view_repayment_cycles.php" target="_blank">Add Repayment Cycle</a>
                        </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="inputLoanNumOfRepayments" class="col-sm-3 control-label">Number of Repayments</label>
                        <div class="col-sm-3">
                            <div class="input-group bootstrap-touchspin"><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-down" type="button">-</button></span><span class="input-group-addon bootstrap-touchspin-prefix" style="display: none;"></span><input class="form-control positive-integer" name="loan_num_of_repayments" id="inputLoanNumOfRepayments" value="1" type="text" min="1" max="2000" required="" onchange="removeNumRepaymentsMessage()" oninput="removeNumRepaymentsMessage();" style="display: block;"><span class="input-group-addon bootstrap-touchspin-postfix" style="display: none;"></span><span class="input-group-btn"><button class="btn btn-default bootstrap-touchspin-up" type="button">+</button></span></div>

                        </div>

                        <div class="col-sm-6" id="inputLoanNumOfRepaymentsChanged"></div>
                    </div>
                    <hr>

                    <div class="panel panel-default"><div class="panel-body bg-gray text-bold">Advance Settings: <a href="https://x.loandisk.com/loans/add_loan.php#" class="show_hide_advance_settings" style="display: inline;">Hide</a></div></div>
                    <div class="slidingDivAdvanceSettings" style="display: block;">
                        <p>These are <u>optional</u> fields</p>
                        <div class="form-group">
                            <label for="inputLoanDecimalPlaces" class="col-sm-3 control-label">Decimal Places</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="loan_decimal_places" id="inputLoanDecimalPlaces">
                                    <option value="round_off_to_two_decimal">Round Off to 2 Decimal Places</option>
                                    <option value="round_off_to_integer">Round Off to Integer</option>
                                    <option value="round_off_to_one_decimal">Round Off to 1 Decimal Place</option>
                                    <option value="round_up_to_one_decimal">Round Up to 1 Decimal Place</option>
                                    <option value="round_up_to_ten">Round Up to Nearest 10</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#decimal_places">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="decimal_places" class="collapse">
                                    <p><u><strong>Decimal Places</strong></u>
                                        <br>This is an optional field. Select if the repayment amounts should be calculated/shown in decimals or as integers (whole amounts without decimals). You can select from</p>

                                    <ul>
                                        <li><strong>Round Off to 2 Decimal Places</strong>
                                            <br>- This is the default option. For example 2.359 will be rounded off to 2.36
                                        </li>
                                        <li><strong>Round Off to Integer</strong>
                                            <br>- This will round off the value to an integer. For example 2.539 will be rounded off to 3.00
                                        </li>
                                        <li><strong>Round Off to 1 Decimal Places</strong>
                                            <br>- This will round off the value to one decimal place. For example 2.539 will be rounded off to 2.50, and 2.55 will become 2.60.
                                        </li>
                                        <li><strong>Round Up to Nearest 10</strong>
                                            <br>- This will round <u>up</u> the value to the nearest 10. For example, 12.01 will become 20, and 16 will also become 20.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLoanInterestStartDate" class="col-sm-3 control-label">Interest Start Date</label>
                            <div class="col-sm-6">
                                <input type="text" name="loan_interest_start_date" class="form-control date_select is-datepick" id="inputLoanInterestStartDate" placeholder="dd/mm/yyyy" value="">
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#loan_interest_start_date">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="loan_interest_start_date" class="collapse">
                                    <p><u><strong>Interest Start Date (optional)</strong></u></p>
                                    <p>This is an optional field. You can select the date when interest will start to be calculated on the <strong>Principal Amount</strong> above. If you leave this field empty, the interest would start from the <strong>Loan Release Date</strong> selected above.</p>
                                    <p>For example, if you select weekly repayment and <b>Loan Release Date</b> is 1st January and you put <b>Interest Start Date</b> as 5th January, then the first repayment would be on 12th January (5+7). But if <b>Interest Start Date</b> is empty, then first repayment would be on 8th Jan (1+7).
                                    </p>
                                    <p>Some lending companies charge interest at a later date and give a few days interest free at the start of the loan. For example, if you release the loan on the night of 31st January, you might want interest to begin calculating on 1st February since there are only a few hours left in 31st January.</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLoanFirstRepaymentDate" class="col-sm-3 control-label">First Repayment Date</label>
                            <div class="col-sm-6">
                                <input type="text" name="loan_first_repayment_date" class="form-control date_select is-datepick" id="inputLoanFirstRepaymentDate" placeholder="dd/mm/yyyy" value="">
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#loan_first_repayment_date">Help</a>
                            </div>
                            <div class="col-sm-offset-3 col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="LoanFirstRepaymentAmountProRata" name="loan_first_repayment_pro_rata" value="1" onchange="first_repayment_pro_rata_click();"> Calculate  first repayment on pro-rata basis

                                        <div class="checkbox">
                                            <label>
                                            <input type="checkbox" id="inputLoanFeesProRata" name="loan_fees_pro_rata" value="1" disabled=""> Adjust Fees in first repayment on pro-rata basis
                                            </label>
                                        </div>

                                        <div class="checkbox">
                                            <label>
                                            <input type="checkbox" id="inputLoanDoNotAdjustRemainingProRata" name="loan_do_not_adjust_remaining_pro_rata" value="1" disabled=""> Do not adjust remaining repayments (Flat-Rate and Interest-Only)
                                            </label>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="loan_first_repayment_date" class="collapse">
                                <p><u><strong>First Repayment Date (optional)</strong></u>

                                <br>This is an optional field. You can select the date of the first repayment. If you leave this field empty, the first repayment date would be calculated based on the <strong>Repayment Cycle</strong> above.</p>
                                    <p>For example, if you select weekly repayment and <b>Loan Release Date</b> is 1st January and you put <b>First Repayment Date</b> as 5th January, then the second repayment would be on 12th January (5+7). But if <b>First Repayment Date</b> is empty, then first repayment would be on 8th Jan (1+7).
                                    </p>
                                <p>If you <b>check</b> <u>Calculate first repayment on pro-rata basis</u>, the first repayment amount will be calculated on pro-rata basis based on the first repayment date</p>
                                <p>If you <b>check</b> <u>Adjust Fees in first repayment on pro-rata basis</u>, the non-deductable fees in first repayment amount will be calculated on pro-rata basis based on the first repayment date. After the first repayment, fees will be charged in full.</p>
                                <p>If you <b>check</b> <u>Do not adjust remaining repayments (Flat-Rate and Interest-Only) </u>, the remaining repayments (after the first repayment) will remain the same as before. For example, let's assume there is $1000 due every repayment and there are total of 10 repayments and the first repayment has been calculated as $100 on pro-rata basis. If you leave this option <b>unchecked</b>, the remaining $900($1000-$100) will be divided equally among the remaining 9 repayments so each repayment will have $100 due($900/9). But if you <b>check</b> this option, each repayment will still have the original due of $1000 irrespective of what the first repayment is.</p>
                                <p>Some lending companies charge the first repayment at an earlier date to reduce risk. For example, if the <strong>Repayment Cycle</strong> is <strong>Weekly</strong>, then the system would automatically set the repayments every week and the first repayment would be 1 week from the <strong>Loan Release Date&nbsp;</strong> But, you might want the first repayment earlier than 1 week to reduce risk or to follow a certain schedule. If you do select a date here, the repayment schedule will be calculated from the <strong>First Repayment Date</strong>.</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="inputFirstRepaymentAmount" class="col-sm-3 control-label">First Repayment Amount</label>
                            <div class="col-sm-6">
                                <input type="text" name="first_repayment_amount" class="form-control decimal-2-places" id="inputFirstRepaymentAmount" placeholder="First Repayment Amount" value="">
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#first_repayment_amount">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="first_repayment_amount" class="collapse">
                                    <p><u><strong>First Repayment Amount (optional)</strong></u></p>

                                    <p>This is an optional field. Only valid for <strong>Flat-Rate</strong> interest method. You can type an amount that will be charged on the first repayment. If you leave this field empty, the first repayment amount would be calculated based on the <strong>Loan Interest</strong> and <strong>Loan Duration</strong> fields above.</p>

                                    <p>Some lending companies charge a higher amount on the first repayment to reduce risk. If you do type an amount here, the <strong>First Repayment Amount</strong> will be subtracted from the total loan due amount and the remaining amount will be divided in the repayment cycle as per the <strong>Interest Method</strong> above.</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="inputLastRepaymentAmount" class="col-sm-3 control-label">Last Repayment Amount</label>
                            <div class="col-sm-6">
                                <input type="text" name="last_repayment_amount" class="form-control decimal-2-places" id="inputLastRepaymentAmount" placeholder="Last Repayment Amount" value="">
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#last_repayment_amount">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="last_repayment_amount" class="collapse">
                                    <p><u><strong>Last Repayment Amount (optional)</strong></u></p>

                                    <p>This is an optional field. Only valid for <strong>Flat-Rate</strong> interest method. You can type an amount that will be charged on the last repayment. If you leave this field empty, the last repayment amount would be calculated based on the <strong>Loan Interest</strong> and <strong>Loan Duration</strong> fields above.</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLoanOverrideMaturityDate" class="col-sm-3 control-label">Override Maturity Date</label>
                            <div class="col-sm-6">
                                <input type="text" name="loan_override_maturity_date" class="form-control date_select is-datepick" id="inputLoanOverrideMaturityDate" placeholder="dd/mm/yyyy" value="">
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#loan_override_maturity_date">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="loan_override_maturity_date" class="collapse">
                                    <p><strong><u>Override Maturity Date</u></strong>
                                        <br>This is an optional field. You can specify a maturity date for the loan. If you leave this field empty, the system will calculate maturity date as per the <strong>Repayment Cycle</strong> selected above.
                                    </p>
                                    <p>Some lending companies have specific maturity dates. For example, let's say you have a 1 month loan with daily repayments that starts on 15th May and ends on 14th June. But you don't want to count the days between the start and end date every time you add a loan since months have different number of days. In this example, you can select a really high value in <strong>Repayment Cycle</strong> like 60 Days and put 14th June in <strong>Override Maturity Date</strong>. The system will automatically stop the loan schedule at 14th June and divide the due amounts accordingly. Please note that the total due amounts will not change.</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputOverrideEachRepaymentAmount" class="col-sm-3 control-label">Override Each Repayment Amount to</label>
                            <div class="col-sm-6">
                                <input type="text" name="override_each_repayment_amount" class="form-control decimal-2-places" id="inputOverrideEachRepaymentAmount" placeholder="Repayment Amount" value="">
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#override_each_repayment_amount">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="override_each_repayment_amount" class="collapse">
                                    <p><strong><u>Override Each Repayment Amount to</u></strong>
                                        <br>This is an optional field. Only valid for <strong>Flat-Rate</strong> interest method. You can specify the total amount for each repayment cycle. If you leave this field empty, the system will calculate repayment amount as per the <strong>Repayment Cycle</strong> selected above.</p>
                                        <p>Some lending companies don't calculate the exact interest amount for each repayment cycle. Consider a scenario where you give a borrower $5000 for 24 weeks and agree to a total repayment of $288.75 for each week. If you multiply $288.75 by 24 weeks, you get $6930. So the total interest charged is $6930-$5000 = $1930. If you divide $1930 by 24 weeks, you get 80.416666666666 interest for each repayment cycle. If you enter that in <strong>Loan Interest</strong> field above (such as 80.41 or 80.42), the due amount for each repayment would not all be the same due to the rounding off error. Hence for this type of loan, you can put $288.75 in <strong>Override Each Repayment Amount to</strong> and the system will automatically calculate the interest for each repayment and do the proper rounding off. In this case, you can put 0 in <strong>Loan Interest</strong> above.</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLoanInterestSchedule" class="col-sm-3 control-label">How should Interest be charged in Loan Schedule?</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="loan_interest_schedule" id="inputLoanInterestSchedule">
                                    <option value="charge_interest_normally">Include interest normally as per Interest Method</option>
                                    <option value="charge_interest_on_released_date">Charge All Interest on the Released Date</option>
                                    <option value="charge_interest_on_first_repayment">Charge All Interest on the First Repayment</option>
                                    <option value="charge_interest_on_last_repayment">Charge All Interest on the Last Repayment</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#loan_interest_schedule">Help</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">
                                <div id="loan_interest_schedule" class="collapse">
                                    <p><strong><u>How should Interest be charged in Loan Schedule?</u></strong>
                                        <br>This is an optional field. Select how the total interest should be charged in the loan schedule. You can select from</p>

                                    <ul>
                                        <li><strong>Include interest normally as per Interest Method</strong>
                                            <br>- The interest will be shown as per the <strong>Interest Method</strong> above.</li>
                                        <li><strong>Charge All Interest on the Released Date</strong>
                                            <br>- All the interest will be charged on the released date.</li>
                                        <li><strong>Charge All Interest on the First Repayment</strong>
                                            <br>- All interest will be charged on the first repayment date as per the schedule.</li>
                                        <li><strong>Charge All Interest on the Last Repayment</strong>
                                            <br>- All interest will be charged on the last repayment date as per the schedule.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="panel panel-default"><div class="panel-body bg-gray text-bold">Automated Payments: <a href="https://x.loandisk.com/loans/add_loan.php#" class="show_hide_automated_payments" style="display: inline;">Hide</a></div></div>

                    <div class="slidingDivAutomatedPayments" style="">
                        <div class="well">
                            If you select <b>Yes</b> below, the system will automatically add due payments on the schedule dates for this loan. This is useful if you expect to receive payments <u>on time</u> for this loan. For example, you may have a direct deposit or payroll system which automatically deducts payment from the borrower on the scheduled dates. This will save you time from having to manually add payments on Loandisk on the scheduled dates.
                        </div>
                        <div class="form-group">
                            <label for="inputAutomaticPayments" class="col-sm-3 control-label">Add Automatic Payments</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <label>
                                    <input type="radio" name="automatic_payments" id="inputAutomaticPaymentsNo" value="0" onclick="enableDisablePostingPeriod()" checked=""> No

                                    </label>

                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>
                                    <input type="radio" name="automatic_payments" id="inputAutomaticPaymentsYes" value="1" onclick="enableDisablePostingPeriod()"> Yes

                                    </label>
                                </div>
                                If you select <b>Yes</b> above, the system will automatically add the due payments on every repayment cycle based on the scheduled dates.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPaymentPostingPeriod" class="col-sm-3 control-label">Time to Post between</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="payment_posting_period" id="inputPaymentPostingPeriod" disabled="">
                                    <option value="0" selected="">                      </option><option value="1">12.01am - 04.00am</option>                      <option value="2">04.01am - 08.00am</option>                      <option value="3">08.01am - 12.00pm</option>                      <option value="4">12.01pm - 04.00pm</option>                      <option value="5">04.01pm - 08.00pm</option>                      <option value="6">08.01pm - 11.59pm</option>
                                </select>
                                The payment will be added between the above selected times on the scheduled dates. If you change <b>Add Automatic Payments</b> to <b>No</b> before this time, the system will not add the payment.
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="panel panel-default"><div class="panel-body bg-gray text-bold">Loan Fees: <a class="btn btn-primary btn-xs pull-right" data-toggle="collapse" data-target="#loan_fee_schedule">Help</a></div></div><p class="margin">There are no fees in your account. To add fees, please <a href="https://x.loandisk.com/admin/view_loan_fees.php" target="_blank">click here.</a></p>
                    <hr>
                <div class="panel panel-default"><div class="panel-body bg-gray text-bold">Loan Status:</div></div>
                    <div class="form-group">
                        <label for="inputStatusId" class="col-sm-3 control-label">Loan Status</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="loan_status_id" id="inputStatusId">
                            <option value="8">Processing</option>
                            <option value="1" selected="">Open</option>
                            <option value="3">Defaulted</option>
                            <option value="13">----Sequestrate</option>
                            <option value="12">----Debt Review</option>
                            <option value="7">----Fraud</option>
                            <option value="11">----Investigation</option>
                            <option value="15">----Legal</option>
                            <option value="14">----Write-Off</option>
                            <option value="9">Denied</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                <div class="panel panel-default"><div class="panel-body bg-gray text-bold">Other (optional):</div></div>
                    <div class="form-group">
                        <label for="inputAutomaticPayments" class="col-sm-3 control-label">Select Guarantors</label>
                        <div class="col-sm-6">
                            <select class="form-control guarantor_select select2-hidden-accessible" multiple="" name="guarantors[]" id="inputGuarantors" style="width: 100%;" data-select2-id="inputGuarantors" tabindex="-1" aria-hidden="true">
                                <option value="b470925" data-select2-id="10">Peter  Apollo - Swift Systems - 1000002</option>
                            </select><span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="3" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1"><ul class="select2-selection__rendered"><span class="select2-selection__clear" data-select2-id="12">×</span><li class="select2-selection__choice" title="Peter  Apollo - Swift Systems - 1000002" data-select2-id="11"><span class="select2-selection__choice__remove" role="presentation">×</span>Peter  Apollo - Swift Systems - 1000002</li><li class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                        </div>
                        <div class="col-sm-3">
                        <div class="pull-left" style="margin-top:5px">
                                <a href="https://x.loandisk.com/loans/guarantors/view_guarantors_branch.php" target="_blank">Add/Edit Guarantors</a>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLoanDescription" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <textarea name="loan_description" class="form-control" id="inputLoanDescription" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="loan_files" class="col-sm-3 control-label">Loan Files<br>(text, word, pdf, image, zip, csv, or excel)</label>
                        <div class="col-sm-9">
                            <input type="file" id="data_files" name="loan_files[]" multiple="">
                        </div>
                        <div class="col-sm-9">
                            You can select up to 20 files. Please click <b>Browse</b> button and then hold <b>Ctrl</b> button on your keyboard to select multiple files.
                    </div>
                    </div>
                    <p style="text-align:center; font-weight:bold;"><small><a href="https://x.loandisk.com/admin/view_custom_fields.php" target="_blank">Click here to add custom fields on this page</a></small></p>
                    <div class="box-footer">
                        <button type="button" class="btn btn-default" onclick="parent.location=&#39;&#39;">Back</button>
                        <button type="submit" class="btn btn-info pull-right" data-loading-text="&lt;i class=&#39;fa fa-spinner fa-spin &#39;&gt;&lt;/i&gt; Please Wait">Submit</button>
                    </div><!-- /.box-footer -->
                </div>
            </form>
        </div>
        <script>
        $( "#pre_loader" ).hide();
        </script>

    </section>




@endsection


@section('page_scripts')

  <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  <script type="text/javascript">
      /* Start Datetimepicker Init*/
      $('#start_at_group').datetimepicker({
          useCurrent: false,
          format: 'DD-MM-YYYY',
          icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
        }).on('dp.show', function() {
        if($(this).data("DateTimePicker").date() === null)
          $(this).data("DateTimePicker").date(moment());
      });

      /* End Datetimepicker Init*/
      $('#end_at_group').datetimepicker({
          useCurrent: false,
          format: 'DD-MM-YYYY',
          icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
        }).on('dp.show', function() {
        if($(this).data("DateTimePicker").date() === null)
          $(this).data("DateTimePicker").date(moment());
      });

      //clear date
      $("#clear_date").click(function(e){
          e.preventDefault();
          $('#start_at').val("");
          $('#end_at').val("");
      });

  </script>

  @include('_admin.layouts.partials.error_messages')

@endsection
