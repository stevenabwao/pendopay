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

                <div class="col-lg-6 col-xs-12">

                    <div class="panel panel-default card-view pa-0">

                        <div  class="panel-wrapper collapse in">

                            <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                                <p class="mb-20">
                                    <h5>Source Account</h5>
                                </p>

                                <hr>

                                <div class="social-info">
                                    <div class="row">

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
                                                <div class="clearfix"></div>
                                            </div>


                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-lg-6 col-xs-12">

                    <div class="panel panel-default card-view pa-0">

                        <div  class="panel-wrapper collapse in">

                            <div  class="panel-body pb-0 ml-20 mr-20 mb-20">

                                <p class="mb-20">
                                    <h5>Destination Account</h5>
                                </p>

                                <hr>

                                <div class="social-info">
                                    <div class="row">

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

                                                    </select>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>


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




                <div  class="col-sm-12">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">


                        {{-- <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div  class="tab-struct custom-tab-2 mt-40">
                                    <ul role="tablist" class="nav nav-tabs" id="myTabs_15">
                                        <li class="active" role="presentation"><a aria-expanded="true"  data-toggle="tab" role="tab" id="home_tab_15" href="#home_15">active</a></li>
                                        <li role="presentation" class="">
                                            <a  data-toggle="tab" id="profile_tab_15" role="tab" href="#profile_15" aria-expanded="false">inactive</a>
                                        </li>

                                    </ul>
                                    <div class="tab-content" id="myTabContent_15">
                                        <div  id="home_15" class="tab-pane fade active in" role="tabpanel">
                                            <p>Lorem ipsum dolor sit amet, et pertinax ocurreret scribentur sit, eum euripidis assentior ei. In qui quodsi maiorum, dicta clita duo ut. Fugit sonet quo te. Ad vel quando causae signiferumque. Aperiam luptatum senserit eu vis, eu ius purto torquatos vituperatoribus.An nec fastidii eligendi molestiae.</p>
                                        </div>
                                        <div  id="profile_15" class="tab-pane fade" role="tabpanel">
                                            <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee.</p>
                                        </div>
                                        <div  id="dropdown_29" class="tab-pane fade " role="tabpanel">
                                            <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
                                        </div>
                                        <div  id="dropdown_30" class="tab-pane fade" role="tabpanel">
                                            <p>Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}





                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 class="text-primary text-center panel-title">Funds transfer and withdrawal</h1>
                            </div>
                            <div class="panel-body">
                                <ul role="tablist" class="nav nav-tabs" id="myTabs_15">

                                    <li role="presentation" class="active">
                                        <a aria-expanded="true"  data-toggle="tab" role="tab"
                                            id="home_tab_15" href="#home_15">Transfer Funds</a>
                                    </li>
                                    <li role="presentation" class="">
                                        <a  data-toggle="tab" id="profile_tab_15" role="tab" href="#profile_15" aria-expanded="false">Withdraw</a>
                                    </li>
                                </ul>
                                <div>
                                    <div class="row">
                                        <div></div>
                                        <div class="col-md-9">

                                            <form id="home_15" class="tab-pane fade active in" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label>From group</label>
                                                        <select class="form-control" name="from_group">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label>From member</label>
                                                        <div class="Select Select--single is-clearable is-searchable">
                                                            <div class="Select-control"><span class="Select-multi-value-wrapper" id="react-select-5--value"><div class="Select-placeholder">Select...</div><div class="Select-input" style="display: inline-block;"><input role="combobox" aria-expanded="false" aria-owns="" aria-haspopup="false" aria-activedescendant="react-select-5--value" style="box-sizing: content-box; width: 5px;"><div style="position: absolute; top: 0px; left: 0px; visibility: hidden; height: 0px; overflow: scroll; white-space: pre; font-size: 14px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 400; font-style: normal; letter-spacing: normal; text-transform: none;"></div></div></span><span class="Select-arrow-zone"><span class="Select-arrow"></span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label>From member account</label>
                                                        <select class="form-control" name="from_all_accounts" id="from_all_accounts">
                                                            <option></option>
                                                            <optgroup label="Accounts"></optgroup>
                                                            <optgroup label="Property accounts"></optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label>To group</label>
                                                        <select class="form-control" name="to_group">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label>To member</label>
                                                        <div class="Select Select--single is-clearable is-searchable">
                                                            <div class="Select-control"><span class="Select-multi-value-wrapper" id="react-select-6--value"><div class="Select-placeholder">Select...</div><div class="Select-input" style="display: inline-block;"><input role="combobox" aria-expanded="false" aria-owns="" aria-haspopup="false" aria-activedescendant="react-select-6--value" style="box-sizing: content-box; width: 5px;"><div style="position: absolute; top: 0px; left: 0px; visibility: hidden; height: 0px; overflow: scroll; white-space: pre; font-size: 14px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 400; font-style: normal; letter-spacing: normal; text-transform: none;"></div></div></span><span class="Select-arrow-zone"><span class="Select-arrow"></span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label>To member account</label>
                                                        <select class="form-control" name="to_all_accounts" id="to_all_accounts">
                                                            <option></option>
                                                            <optgroup label="Accounts"></optgroup>
                                                            <optgroup label="Loans"></optgroup>
                                                            <optgroup label="Property accounts"></optgroup>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label>Use other accounts</label>
                                                        <select class="form-control" name="use_other_account">
                                                            <option value="no">No</option>
                                                            <option value="yes">Yes</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label>Debit account</label>
                                                        <select class="form-control" name="debit_gl_account" disabled="">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <label>Credit account</label>
                                                        <select class="form-control" name="credit_gl_account" disabled="">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label>Amount</label>
                                                        <input type="number" class="form-control" required="" name="amount">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Date</label>
                                                        <div id="sandbox-container">
                                                            <div class="input-group date">
                                                                <input type="text" readonly="" class="form-control" name="date" required=""><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 form-group">
                                                            <label>Comment</label>
                                                            <textarea type="text" class="form-control" name="comment" style="resize: none;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <label>Create standing order</label>
                                                        <select class="form-control" name="create_standing_order">
                                                            <option value="no">No</option>
                                                            <option value="yes">Yes</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 form-group" style="display: none;">
                                                        <label>Standing order frequency(every)</label>
                                                        <div class="input-group">
                                                            <div class="col-md-8" style="padding-left: 0px; padding-right: 0px;">
                                                                <input type="number" class="form-control" name="standing_order_frequency_every">
                                                            </div>
                                                            <div class="col-md-4" style="padding-left: 0px; padding-right: 0px;">
                                                                <select class="form-control" name="standing_order_frequency_type">
                                                                    <option value="days">Days</option>
                                                                    <option value="weeks">Weeks</option>
                                                                    <option value="months">Months</option>
                                                                    <option value="years">Years</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4" style="display: none;">
                                                        <label>No of times to run</label>
                                                        <input type="number" class="form-control" name="run_n_times">
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="panel panel-default card-view">

                           <div class="panel-wrapper collapse in">

                              <div class="panel-body">

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Create New Transfer</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <!-- @if (session('message'))
                                      <div class="alert alert-success text-center">
                                          {{ session('message') }}
                                      </div>
                                    @endif

                                    @if (session('error'))
                                      <div class="alert alert-danger text-center">
                                          {{ session('error') }}
                                      </div>
                                    @endif -->

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('transfers.store') }}">

                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('company_user_id') ? ' has-error' : '' }}">

                                            <label for="company_user_id" class="col-sm-3 control-label">
                                            Company User
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                            <select class="selectpicker form-control"
                                                name="company_user_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($companyusers as $company_user)

                                                    @if($company_user->user)

                                                        <li class="mb-10">
                                                            <option value="{{ $company_user->id }}"
                                                        @if ($company_user->id == old('company_user_id', $company_user->id))
                                                            selected="selected"
                                                        @endif
                                                                >

                                                                    {{ $company_user->user->first_name }}
                                                                    {{ $company_user->user->last_name }}


                                                                    @if(($company_user->company) && (Auth::user()->hasRole('superadministrator')))
                                                                    &nbsp; ({{ $company_user->company->name }})
                                                                    @endif

                                                                </option>
                                                        </li>

                                                    @endif

                                                @endforeach

                                            </select>

                                            @if ($errors->has('company_user_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('company_user_id') }}</strong>
                                                    </span>
                                            @endif

                                            </div>

                                        </div>

                                       <div  class="form-group{{ $errors->has('company_branch_id') ? ' has-error' : '' }}">

                                            <label for="company_branch_id" class="col-sm-3 control-label">
                                            Branch Name
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                            <select class="selectpicker form-control"
                                                name="company_branch_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($companybranches as $company_branch)
                                                <li class="mb-10">
                                                <option value="{{ $company_branch->id }}"
                                            @if ($company_branch->id == old('company_branch_id', $company_branch->id))
                                                selected="selected"
                                            @endif
                                                    >
                                                        {{ $company_branch->name }}

                                                        @if(($company_branch->company) && (Auth::user()->hasRole('superadministrator')))
                                                        &nbsp; ({{ $company_branch->company->name }})
                                                        @endif

                                                    </option>
                                                </li>
                                                @endforeach

                                            </select>

                                            @if ($errors->has('company_branch_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('company_branch_id') }}</strong>
                                                    </span>
                                            @endif

                                            </div>

                                        </div>


                                       <br/>

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
