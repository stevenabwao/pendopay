@extends('_admin.layouts.master')


@section('title')

    Edit Loan Settings - {{ $loansetting->id }} - {{ $loansetting->name }}

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Edit Loan Settings - {{ $loansetting->companyproduct->product->name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
              {!! Breadcrumbs::render('loansettings.edit', $loansetting->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

    </div>




    <div class="container-fluid">


        <!-- Row -->
         <div class="table-struct full-width full-height">
            <div class="table-cell auth-form-wrap-inner">
               <div class="ml-auto mr-auto no-float">

                  <div  class="col-sm-12">

                    <div class="row">
                       <div class="col-sm-12 col-xs-12">

                          <div class="panel panel-default card-view">

                             <div class="panel-wrapper collapse in">

                                <div class="panel-body">

                                   <div class="form-wrap">

                                        <br/>

                                        <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                                            action="{{ route('loansettings.update', $loansetting->id) }}" id="form" data-select2-id="form">

                                                {{ method_field('PUT') }}
                                                {{ csrf_field() }}

                                            <div class="form-group">

                                                <label for="name" class="col-sm-3 control-label">
                                                Name
                                                </label>
                                                <div class="col-sm-6">
                                                <input disabled
                                                    type="text"
                                                    class="form-control"
                                                    name="name"
                                                    value="{{ $loansetting->companyproduct->name }}">

                                                </div>

                                                <input type="hidden" name="id"  value="{{ $loansetting->id }}">
                                                <input type="hidden" name="company_id"  value="{{ $loansetting->company->id }}">
                                                <input type="hidden" name="company_product_id"  value="{{ $loansetting->companyproduct->id }}">

                                            </div>

                                            <div class="form-group">

                                                <label for="name" class="col-sm-3 control-label">
                                                Product Type
                                                </label>
                                                <div class="col-sm-6">
                                                <input disabled
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    value="{{ $loansetting->companyproduct->product->name }}">
                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="name" class="col-sm-3 control-label">
                                                    Company
                                                </label>
                                                <div class="col-sm-6">
                                                <input disabled
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    value="{{ $loansetting->company->name }}">
                                                </div>

                                            </div>

                                            <hr>
                                            <h5 class="text-red text-bold">Activate/ Deactivate Loan Product:</h5>
                                            <div  class="form-group{{ $errors->has('loan_product_status') ? ' has-error' : '' }}">
                                                <label for="loan_product_status" class="col-sm-3 control-label">Loan Product Status</label>
                                                <div class="col-sm-6">
                                                    <div class="radio">
                                                        <input type="radio" name="loan_product_status" id="loan_product_status" value="1"
                                                        @if(old('loan_product_status', $loansetting->loan_product_status)=="1") checked @endif>
                                                        <label for="1">Enable Loan Product</label>
                                                    </div>
                                                    <div class="radio">
                                                        <input type="radio" name="loan_product_status" id="loan_product_status" value="99"
                                                        @if(old('loan_product_status', $loansetting->loan_product_status)=="99") checked @endif>
                                                        <label for="99">Disable Loan Product</label>
                                                    </div>
                                                    @if ($errors->has('loan_product_status'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('loan_product_status') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>
                                            </div>

                                            <hr>
                                            <h5 class="text-red text-bold">Loan Approval Method:</h5>
                                            <div  class="form-group{{ $errors->has('loan_approval_method') ? ' has-error' : '' }}">
                                                <label for="loan_approval_method" class="col-sm-3 control-label">Please Select</label>
                                                <div class="col-sm-6">
                                                    <div class="radio">
                                                        <input type="radio" name="loan_approval_method" id="loan_approval_method" value="auto"
                                                        @if(old('loan_approval_method', $loansetting->loan_approval_method)=="auto") checked @endif>
                                                        <label for="auto">Auto Approve Loans</label>
                                                    </div>
                                                    <div class="radio">
                                                        <input type="radio" name="loan_approval_method" id="loan_approval_method" value="manual"
                                                        @if(old('loan_approval_method', $loansetting->loan_approval_method)=="manual") checked @endif>
                                                        <label for="manual">Manually Approve Loans</label>
                                                    </div>
                                                    @if ($errors->has('loan_approval_method'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('loan_approval_method') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>
                                            </div>

                                            <hr>
                                            <h5 class="text-red text-bold">Criteria:</h5>
                                            <div  class="form-group{{ $errors->has('borrow_criteria') ? ' has-error' : '' }}">
                                                <label for="borrow_criteria" class="col-sm-3 control-label">Loan Criteria</label>
                                                <div class="col-sm-6">
                                                    <div class="radio">
                                                        <input type="radio" name="borrow_criteria" id="borrow_criteria" value="contributions"
                                                        @if(old('borrow_criteria', $loansetting->borrow_criteria)=="contributions") checked @endif
                                                        >
                                                        <label for="contributions">Members must have contributions to apply for a loan</label>
                                                    </div>
                                                    <div class="radio">
                                                        <input type="radio" name="borrow_criteria" id="borrow_criteria" value="no_contributions"
                                                        @if(old('borrow_criteria', $loansetting->borrow_criteria)=="no_contributions") checked @endif
                                                        >
                                                        <label for="no_contributions">Members dont need contributions to apply for a loan</label>
                                                    </div>
                                                    @if ($errors->has('borrow_criteria'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('borrow_criteria') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>
                                            </div>

                                            <div  class="form-group{{ ($errors->has('minimum_contributions') || $errors->has('minimum_contributions_condition_id')) ? ' has-error' : '' }}"
                                                    >
                                                <label for="minimum_contributions" class="col-sm-3 control-label">Minimum Contributions (Optional)</label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="minimum_contributions" class="form-control digitsOnly"
                                                    value="{{ old('minimum_contributions', $loansetting->minimum_contributions)}}">
                                                    @if ($errors->has('minimum_contributions'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('minimum_contributions') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-3">
                                                    <select class="form-control" name="minimum_contributions_condition_id">

                                                            <li class="mb-10">
                                                                <option value="">None</option>
                                                            </li>

                                                        @foreach ($loanlimitcalculations as $loanlimitcalculation)
                                                            <li class="mb-10">
                                                                <option value="{{ $loanlimitcalculation->id }}"

                                                        @if ($loanlimitcalculation->id == old('minimum_contributions_condition_id', $loansetting->minimum_contributions_condition_id))
                                                            selected="selected"
                                                        @endif
                                                                >
                                                                    {{ $loanlimitcalculation->name }}
                                                                </option>
                                                            </li>
                                                            @endforeach



                                                    </select>

                                                    @if ($errors->has('minimum_contributions_condition_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('minimum_contributions_condition_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <hr>
                                            <h5 class="text-red text-bold">Exposure Limit:</h5>

                                            <div  class="form-group{{ $errors->has('initial_exposure_limit') ? ' has-error' : '' }}">
                                                <label for="initial_exposure_limit" class="col-sm-3 control-label">Initial Exposure Limit</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="initial_exposure_limit" class="form-control digitsOnly" maxlength="3"
                                                    value="{{ old('initial_exposure_limit', $loansetting->initial_exposure_limit)}}">
                                                    @if ($errors->has('initial_exposure_limit'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('initial_exposure_limit') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-3">

                                                </div>
                                            </div>

                                            <div  class="form-group{{ $errors->has('increase_exposure_limit') ? ' has-error' : '' }}">
                                                <label for="increase_exposure_limit" class="col-sm-3 control-label">Increase Exposure Limit</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="increase_exposure_limit" class="form-control digitsOnly" maxlength="3"
                                                    value="{{ old('increase_exposure_limit', $loansetting->increase_exposure_limit)}}">
                                                    @if ($errors->has('increase_exposure_limit'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('increase_exposure_limit') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-3">

                                                </div>
                                            </div>

                                            <div  class="form-group{{ $errors->has('decrease_exposure_limit') ? ' has-error' : '' }}">
                                                <label for="decrease_exposure_limit" class="col-sm-3 control-label">Decrease Exposure Limit</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="decrease_exposure_limit" class="form-control digitsOnly" maxlength="3"
                                                    value="{{ old('decrease_exposure_limit', $loansetting->decrease_exposure_limit)}}">
                                                    @if ($errors->has('decrease_exposure_limit'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('decrease_exposure_limit') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-3">

                                                </div>
                                            </div>

                                            <hr>
                                            <h5 class="text-red text-bold">Loan Limit:</h5>

                                            <div  class="form-group{{ $errors->has('max_loan_limit') ? ' has-error' : '' }}">
                                                <label for="max_loan_limit" class="col-sm-3 control-label">Max Loan Limit</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="max_loan_limit" class="form-control digitsOnly"
                                                    value="{{ old('max_loan_limit', $loansetting->max_loan_limit)}}">

                                                    @if ($errors->has('max_loan_limit'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('max_loan_limit') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-3">

                                                </div>
                                            </div>

                                            <div  class="form-group{{ $errors->has('initial_loan_limit') ? ' has-error' : '' }}">

                                                <label for="initial_loan_limit" class="col-sm-3 control-label">First/ Initial Loan Limit (Optional)</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="initial_loan_limit" class="form-control digitsOnly"
                                                    value="{{ old('initial_loan_limit', $loansetting->initial_loan_limit)}}">
                                                    @if ($errors->has('initial_loan_limit'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('initial_loan_limit') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>

                                            <div  class="form-group{{ $errors->has('loan_limit_calculation_id') ? ' has-error' : '' }}">
                                                <label for="loan_limit_calculation_id" class="col-sm-3 control-label">Loan Limit Calculation</label>
                                                <div class="col-sm-6">

                                                    <select class="form-control" name="loan_limit_calculation_id">

                                                        @foreach ($loanlimitcalculations as $loanlimitcalculation)
                                                            <li class="mb-10">
                                                                <option value="{{ $loanlimitcalculation->id }}"

                                                                        @if ($loanlimitcalculation->id == old('loan_limit_calculation_id', $loansetting->loan_limit_calculation_id))
                                                                        selected="selected"
                                                                        @endif
                                                                >
                                                                    {{ $loanlimitcalculation->name }}
                                                                </option>
                                                            </li>
                                                        @endforeach

                                                    </select>

                                                    @if ($errors->has('loan_limit_calculation_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('loan_limit_calculation_id') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>

                                                <div class="col-sm-3">

                                                </div>
                                            </div>

                                            <div  class="form-group{{ $errors->has('min_loan_limit') ? ' has-error' : '' }}">
                                                <label for="min_loan_limit" class="col-sm-3 control-label">Min Loan Amount</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="min_loan_limit" class="form-control digitsOnly"
                                                    value="{{ old('min_loan_limit', $loansetting->min_loan_limit)}}">

                                                    @if ($errors->has('min_loan_limit'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('min_loan_limit') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-3">

                                                </div>
                                            </div>

                                            <div  class="form-group{{ $errors->has('max_loan_applications_per_day') ? ' has-error' : '' }}">
                                                <label for="max_loan_applications_per_day" class="col-sm-3 control-label">Max Loans Per Day</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="max_loan_applications_per_day" class="form-control digitsOnly"
                                                    value="{{ old('max_loan_applications_per_day', $loansetting->max_loan_applications_per_day)}}">

                                                    @if ($errors->has('max_loan_applications_per_day'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('max_loan_applications_per_day') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-sm-3">

                                                </div>
                                            </div>

                                            <hr>
                                            <h5 class="text-red text-bold">Loans Exceeding Allowed Limit:</h5>

                                            <div  class="form-group{{ $errors->has('loans_exceeding_limit') ? ' has-error' : '' }}">
                                                <label for="loans_exceeding_limit" class="col-sm-3 control-label">Please Select Option</label>
                                                <div class="col-sm-6">
                                                    <div class="radio">
                                                        <input type="radio" name="loans_exceeding_limit" id="loans_exceeding_limit" value="decline"
                                                        @if(old('loans_exceeding_limit', $loansetting->loans_exceeding_limit)=="decline") checked @endif>
                                                        <label for="decline">Decline Loan Application</label>
                                                    </div>
                                                    <div class="radio">
                                                        <input type="radio" name="loans_exceeding_limit" id="loans_exceeding_limit" value="queue"
                                                        @if(old('loans_exceeding_limit', $loansetting->loans_exceeding_limit)=="queue") checked @endif>
                                                        <label for="queue">Queue Loan Application For Later Processing</label>
                                                    </div>
                                                    @if ($errors->has('loans_exceeding_limit'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('loans_exceeding_limit') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>
                                            </div>

                                            <hr>

                                            <h5 class="text-red text-bold">Interest:</h5>
                                            <div  class="form-group{{ $errors->has('interest_method') ? ' has-error' : '' }}">
                                                <label for="interest_method" class="col-sm-3 control-label">Interest Method</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="interest_method" required="">
                                                        <option value="flat_rate" @if($loansetting->interest_method=="flat_rate") selected @endif> Flat Rate</option>
                                                        {{--<option value="reducing_rate_equal_installments">Reducing Balance - Equal Installments</option>
                                                         <option value="reducing_rate_equal_principal">Reducing Balance - Equal Principal</option>
                                                        <option value="interest_only">Interest-Only</option>
                                                        <option value="compound_interest">Compound Interest</option> --}}
                                                    </select>
                                                    @if ($errors->has('interest_method'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('interest_method') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div  class="form-group{{ $errors->has('interest_type') ? ' has-error' : '' }}">
                                                <label for="interest_type" class="col-sm-3 control-label">Interest Type</label>
                                                <div class="col-sm-6">
                                                    <div class="radio">
                                                        <input type="radio" name="interest_type" id="interest_type" value="percentage"
                                                        @if(old('interest_type', $loansetting->interest_type)=="percentage") checked @endif>
                                                        <label for="percentage">I want Interest to be percentage % based</label>
                                                    </div>
                                                    <div class="radio">
                                                        <input type="radio" name="interest_type" id="interest_type" value="fixed"
                                                        @if(old('interest_type', $loansetting->interest_type)=="fixed") checked @endif>
                                                        <label for="fixed">I want Interest to be a fixed amount Per Cycle</label>
                                                    </div>
                                                    @if ($errors->has('interest_type'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('interest_type') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>
                                            </div>

                                            <div  class="form-group{{ $errors->has('interest_amount') ? ' has-error' : '' }}">
                                                <label for="interest_amount" class="col-sm-3 control-label">Interest Amount</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="interest_amount" class="form-control digitsOnly"
                                                    placeholder="Amount" required=""
                                                    value="{{ old('interest_amount', $loansetting->interest_amount)}}">
                                                    @if ($errors->has('interest_amount'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('interest_amount') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>
                                                <div class="col-sm-3">

                                                </div>

                                            </div>

                                            <hr>
                                            <h5 class="text-red text-bold">Loan Repayments:</h5>

                                            <div  class="form-group{{ $errors->has('loan_instalment_period') ? ' has-error' : '' }}">

                                                <label for="loan_instalment_period" class="col-sm-3 control-label">Max Repayment Instalments</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control digitsOnly"  type="text" name="loan_instalment_period"
                                                    value="{{ old('loan_instalment_period', $loansetting->loan_instalment_period)}}">
                                                     @if ($errors->has('loan_instalment_period'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('loan_instalment_period') }}</strong>
                                                        </span>
                                                     @endif
                                                </div>
                                                <div class="col-sm-3">

                                                </div>

                                            </div>

                                            <div  class="form-group{{ $errors->has('loan_instalment_cycle') ? ' has-error' : '' }}">

                                                <label for="loan_instalment_period" class="col-sm-3 control-label">Loan Repayment Cycle</label>

                                                <div class="col-sm-6">
                                                    <select class="form-control" name="loan_instalment_cycle" required="">

                                                        @foreach ($terms as $term)
                                                            <li class="mb-10">
                                                            <option value="{{ $term->id }}"

                                                        @if ($term->id == old('loan_instalment_cycle', $loansetting->loan_instalment_cycle))
                                                            selected="selected"
                                                        @endif
                                                                >
                                                                    {{ $term->name }}
                                                                </option>
                                                            </li>
                                                        @endforeach

                                                    </select>
                                                    @if ($errors->has('loan_instalment_cycle'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('loan_instalment_cycle') }}</strong>
                                                        </span>
                                                     @endif
                                                </div>
                                                <div class="col-sm-3">

                                                </div>

                                            </div>



                                            <hr>

                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary pull-right"><i class="zmdi zmdi-save"></i> &nbsp;&nbsp; Submit</button>
                                            </div><!-- /.box-footer -->

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
            </div>
         </div>
         <!-- /Row -->


      </div>



        @endsection





        @section('page_scripts')



        <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('js/jquery.bootstrap-touchspin.min.js') }}"></script>

        <script type="text/javascript">

            var app = new Vue({
              el: "#app",

              data() {
                  return {
                    borrow_criteria_mod: 'contributions'
                  }
              }

            });
        </script>

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

            $("input[name='tch3_22']").TouchSpin({
                initval: 1
            });

        </script>

  @include('_admin.layouts.partials.error_messages')

@endsection
