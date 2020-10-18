@extends('_admin.layouts.master')

@section('title')

    Manage Loan Applications

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
          <h5 class="txt-dark">
                Manage Loan Applications
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('loan-applications') !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

       <!-- Row -->
        <div class="row mt-15">


               @include('_admin.layouts.partials.error_text')


               <div class="col-sm-12 col-xs-12">

                  <div class="panel panel-default card-view panel-refresh">

                       <div class="refresh-container">
                          <div class="la-anim-1"></div>
                       </div>
                       <div class="panel-heading panel-heading-dark">

                          <div>

                            <form action="{{ route('loan-applications.index') }}">
                               <table class="table table-search">
                                 <tr>

                                    <td>
                                      <div class="pull-left col-sm-12 col-sm-6 col-md-2">
                                          @if (count($loanapplications))
                                            <div class="btn-group">
                                                <div class="dropdown">
                                                  <button
                                                      aria-expanded="false"
                                                      data-toggle="dropdown"
                                                      class="btn btn-success dropdown-toggle "
                                                      type="button">
                                                      Download
                                                      <span class="caret ml-10"></span>
                                                  </button>
                                                  <ul role="menu" class="dropdown-menu">

                                                      <li>
                                                        <a href="{{ route('excel.loan-applications',
                                                                    ['xls',
                                                                      'start_date' => app('request')->input('start_date'),
                                                                      'end_date' => app('request')->input('end_date'),
                                                                      'paybills' => app('request')->input('paybills'),
                                                                      'limit' => app('request')->input('limit'),
                                                                    ])
                                                                }}"
                                                        >As Excel</a>
                                                      </li>
                                                      <li><a href="{{ route('excel.loan-applications', 'csv') }}">As CSV</a></li>
                                                      <li><a href="{{ route('excel.loan-applications', 'pdf') }}">As PDF</a></li>

                                                  </ul>
                                                </div>
                                            </div>
                                          @endif
                                      </div>

                                      <div class="col-sm-12 col-sm-6 col-md-2">

                                          <input type="hidden" value="1" name="search">

                                          <input
                                              type='text'
                                              class="form-control"
                                              placeholder="Enter Search Term"
                                              id='account_search'
                                              name="account_search"

                                              @if (app('request')->input('account_search'))
                                                  value="{{ app('request')->input('account_search') }}"
                                              @endif

                                          />

                                      </div>

                                      <div class="col-sm-12 col-sm-6 col-md-2">

                                          <div class='input-group date' id='start_date_group'>
                                              <input
                                                  type='text'
                                                  class="form-control"
                                                  placeholder="Start Date"
                                                  id='start_date'
                                                  name="start_date"

                                                  @if (app('request')->input('start_date'))
                                                      value="{{ app('request')->input('start_date') }}"
                                                  @endif

                                              />
                                              <span class="input-group-addon">
                                                  <span class="fa fa-calendar"></span>
                                              </span>
                                          </div>

                                      </div>

                                      <div class="col-sm-12 col-sm-6 col-md-2">

                                          <div class='input-group date' id='end_date_group'>
                                              <input
                                                  type='text'
                                                  class="form-control"
                                                  placeholder="End Date"
                                                  id='end_date'
                                                  name="end_date"

                                                  @if (app('request')->input('end_date'))
                                                      value="{{ app('request')->input('end_date') }}"
                                                  @endif

                                              />
                                              <span class="input-group-addon">
                                                  <span class="fa fa-calendar"></span>
                                              </span>
                                          </div>

                                      </div>

                                      <div class="col-sm-12 col-sm-6 col-md-1">
                                          <a class="btn btn-default btn-icon-anim btn-circle"
                                          data-toggle="tooltip" data-placement="top"
                                          title="Clear dates" id="clear_date">
                                          <i class="zmdi zmdi-chart-donut"></i>
                                          </a>
                                      </div>

                                      <div class="col-sm-12 col-sm-6 col-md-1">
                                          <select class="selectpicker form-control" name="limit"
                                          data-style="form-control btn-default btn-outline">

                                              <li class="mb-10">

                                              <option value="20"
                                                  @if (app('request')->input('limit') == 20)
                                                      selected="selected"
                                                  @endif
                                                  >
                                                  20
                                              </option>

                                              </li>

                                              <li class="mb-10">

                                              <option value="50"
                                                  @if (app('request')->input('limit') == 50)
                                                      selected="selected"
                                                  @endif
                                                  >
                                                  50
                                              </option>

                                              </li>

                                              <li class="mb-10">

                                              <option value="100"
                                                  @if (app('request')->input('limit') == 100)
                                                      selected="selected"
                                                  @endif
                                                  >
                                                  100
                                              </option>

                                              </li>

                                          </select>
                                      </div>

                                      <div class="col-sm-12 col-sm-12 col-md-1">
                                          <button class="btn btn-primary btn-block text-center">Filter</button>
                                      </div>

                                    </td>

                                 </tr>
                               </table>
                            </form>

                          </div>
                          <div class="clearfix"></div>

                       </div>


                     @if (!count($loanapplications))

                         <hr>

                         <div class="panel-heading panel-heading-dark">
                              <div class="alert alert-danger text-center">
                                  No records found
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
                                              <th width="5%">id</th>

                                              @if (Auth::user()->hasRole('superadministrator'))
                                                <th width="10%">Company</th>
                                                <th width="10%">Dep. Account</th>
                                                <th width="10%">Acct. Name</th>
                                                <th width="10%">Phone</th>
                                                <th width="10%" align="right">Loan Amount</th>
                                                <th width="10%">Loan Type</th>
                                                <th width="10%">Status</th>
                                              @else
                                                <th width="15%">Dep. Account</th>
                                                <th width="15%">Account Name</th>
                                                <th width="15%">Phone</th>
                                                <th width="10%" align="right">Loan Amount</th>
                                                <th width="10%">Loan Type</th>
                                                <th width="10%">Status</th>
                                              @endif

                                              <th width="15%">Created At</th>
                                              <th width="5%">Actions</th>
                                           </tr>
                                        </thead>
                                        <tbody>

                                           @foreach ($loanapplications as $loanapplication)
                                             <tr>

                                                <td>
                                                  <span class="txt-dark weight-500">
                                                    {{ $loanapplication->id }}
                                                  </span>
                                                </td>

                                                @if (Auth::user()->hasRole('superadministrator'))
                                                <td>
                                                  <span class="txt-dark weight-500">
                                                    {{ titlecase($loanapplication->company->name) }}
                                                  </span>
                                                </td>
                                                @endif

                                                <td>
                                                  <span class="txt-dark weight-500">
                                                  @if ($loanapplication->depositaccount)
                                                    {{ $loanapplication->depositaccount->account_no }}
                                                  @endif
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark weight-500">
                                                  @if ($loanapplication->depositaccount)
                                                    {{ titlecase($loanapplication->depositaccount->account_name) }}
                                                  @endif
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark weight-500">
                                                    @if ($loanapplication->user)
                                                      {{ getDatabasePhoneNumber($loanapplication->user->phone) }}
                                                    @endif
                                                  </span>
                                                </td>

                                                <td align="right">
                                                  <span class="txt-dark weight-500 text-right">
                                                    {{ format_num($loanapplication->loan_amt) }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark weight-500">
                                                    @if ($loanapplication->companyproduct)
                                                      @if ($loanapplication->companyproduct->product)
                                                        {{ $loanapplication->companyproduct->product->name }}
                                                      @endif
                                                    @endif
                                                  </span>
                                                </td>

                                                <td>
                                                    @if ($loanapplication->status)
                                                        @if ($loanapplication->status->id == 10 ||
                                                             $loanapplication->status->id == 12)
                                                          <span class="txt-dark text-success">
                                                              {{ $loanapplication->status->name }}
                                                          </span>
                                                        @elseif ($loanapplication->status->id == 5)
                                                          <span class="txt-dark text-primary">
                                                              {{ $loanapplication->status->name }}
                                                          </span>
                                                        @elseif ($loanapplication->status->id == 16)
                                                          <span class="txt-dark text-warning">
                                                              {{ $loanapplication->status->name }}
                                                          </span>
                                                        @else
                                                          <span class="txt-dark text-danger">
                                                              {{ $loanapplication->status->name }}
                                                          </span>
                                                        @endif
                                                    @endif
                                                </td>

                                                <td>
                                                   <span class="txt-dark weight-500">
                                                    {{ formatFriendlyDate($loanapplication->created_at) }}
                                                   </span>
                                                </td>

                                                <td>

                                                   <a href="{{ route('loan-applications.show', $loanapplication->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-eye"></i>
                                                   </a>

                                                </td>
                                             </tr>
                                           @endforeach

                                        </tbody>
                                     </table>
                                  </div>
                               </div>
                               <hr>
                               <div class="text-center mb-20">

                                   {{ $loanapplications->links() }}

                               </div>
                            </div>
                         </div>

                     @endif

                  </div>

               </div>

        </div>
        <!-- Row -->

    </div>


@endsection


@section('page_scripts')

  <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  <!-- search scripts -->
  @include('_admin.layouts.searchScripts')
  <!-- /search scripts -->

@endsection



