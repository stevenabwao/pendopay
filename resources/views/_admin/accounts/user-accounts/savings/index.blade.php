@extends('_admin.layouts.master')

@section('title')

    Manage User Savings Accounts

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
                Manage User Savings Accounts
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('user-savings-accounts') !!}
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

                            <form action="{{ route('user-savings-accounts.index') }}">
                               <table class="table table-search">
                                 <tr>

                                    <td>

                                        <div class="pull-left col-sm-12 col-sm-6 col-md-2">

                                            @if (count($accounts))
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
                                                            <a href="{{ route('excel.user-savings-accounts',
                                                                        ['xls',
                                                                        'start_date' => app('request')->input('start_date'),
                                                                        'end_date' => app('request')->input('end_date'),
                                                                        'account_search' => app('request')->input('account_search'),
                                                                        'limit' => app('request')->input('limit'),
                                                                        ])
                                                                    }}"
                                                            >As Excel</a>
                                                        </li>
                                                        <li><a href="{{ route('excel.user-savings-accounts',
                                                                        ['csv',
                                                                        'start_date' => app('request')->input('start_date'),
                                                                        'end_date' => app('request')->input('end_date'),
                                                                        'account_search' => app('request')->input('account_search'),
                                                                        'limit' => app('request')->input('limit'),
                                                                        ]) }}">As CSV</a></li>
                                                        <li><a href="{{ route('excel.user-savings-accounts',
                                                                        ['pdf',
                                                                        'start_date' => app('request')->input('start_date'),
                                                                        'end_date' => app('request')->input('end_date'),
                                                                        'account_search' => app('request')->input('account_search'),
                                                                        'limit' => app('request')->input('limit'),
                                                                        ]) }}">As PDF</a></li>

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

                                        <div class="col-sm-12 col-sm-6 col-md-2">
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
                                            <button class="btn btn-primary btn-block">Filter</button>
                                        </div>

                                    </td>
                                 </tr>

                               </table>
                            </form>

                          </div>
                          <div class="clearfix"></div>

                       </div>


                     @if (!count($accounts))

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
                                              <th width="10%">Acct No.</th>
                                              <th width="10%">Phone</th>
                                              <th width="15%">Acct Name</th>
                                              <th width="10%">Acct Type</th>
                                              <th width="15%">Company/ Sacco</th>
                                              <th width="5%">Status</th>
                                              <th width="15%">Created At</th>
                                              <th width="15%">Actions</th>
                                           </tr>
                                        </thead>
                                        <tbody>

                                           @foreach ($accounts as $account)
                                             <tr>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $account->id }}
                                                  </span>
                                                </td>

                                                <td>
                                                    @if ($account->status->id != 1)
                                                      <span class="txt-dark text-danger">
                                                          {{ $account->account_no }}
                                                      </span>
                                                    @else
                                                      <span class="txt-dark">
                                                          {{ $account->account_no }}
                                                      </span>
                                                    @endif
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ titlecase($account->phone) }}
                                                  </span>
                                                </td>

                                                <td>
                                                    <span class="txt-dark">
                                                        {{ titlecase($account->account_name) }}
                                                    </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                      @if ($account->product)
                                                        {{ $account->product->name }}
                                                      @endif
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                      @if ($account->company)
                                                        {{ titlecase($account->company->name) }}
                                                      @endif
                                                  </span>
                                                </td>

                                                <td>

                                                    @if ($account->status->id == 1)
                                                      <span class="txt-dark text-success">
                                                          {{ $account->status->name }}
                                                      </span>
                                                    @else
                                                      <span class="txt-dark text-danger">
                                                          {{ $account->status->name }}
                                                      </span>
                                                    @endif

                                                </td>

                                                <td>
                                                   <span class="txt-dark">
                                                    {{ formatFriendlyDate($account->created_at) }}
                                                   </span>
                                                </td>

                                                <td>

                                                   <a href="{{ route('user-savings-accounts.show', $account->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-eye"></i>
                                                   </a>

                                                   <a href="{{ route('user-savings-accounts.edit', $account->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-edit"></i>
                                                   </a>

                                                   <a href="{{ route('user-savings-accounts.destroy', $account->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-delete"></i>
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

                                   {{ $accounts->links() }}

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
