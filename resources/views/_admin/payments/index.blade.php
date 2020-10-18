@extends('_admin.layouts.master')

@section('title')

    Manage Payments

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
                Manage Payments
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('payments') !!}
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

                            <form action="{{ route('payments.index') }}">
                               <table class="table table-search">
                                 <tr>

                                    <td>

                                        <div class="pull-left col-sm-12 col-sm-6 col-md-2">

                                            @if (count($payments))
                                              <div class="btn-group btn-block">
                                                  <div class="dropdown">
                                                     <button
                                                        aria-expanded="false"
                                                        data-toggle="dropdown"
                                                        class="btn btn-success dropdown-toggle"
                                                        type="button">
                                                        Download
                                                        <span class="caret ml-10"></span>
                                                     </button>
                                                     <ul role="menu" class="dropdown-menu">

                                                        <li>
                                                          <a href="{{ route('excel.payments',
                                                                      ['xls',
                                                                        'start_date' => app('request')->input('start_date'),
                                                                        'end_date' => app('request')->input('end_date'),
                                                                        'paybills' => app('request')->input('paybills'),
                                                                        'account_search' => app('request')->input('account_search'),
                                                                        'limit' => app('request')->input('limit'),
                                                                        'report' => '1',
                                                                      ])
                                                                   }}"
                                                          >As Excel</a>
                                                        </li>
                                                        <li><a href="{{ route('excel.payments',
                                                                      ['csv',
                                                                        'start_date' => app('request')->input('start_date'),
                                                                        'end_date' => app('request')->input('end_date'),
                                                                        'paybills' => app('request')->input('paybills'),
                                                                        'account_search' => app('request')->input('account_search'),
                                                                        'limit' => app('request')->input('limit'),
                                                                        'report' => '1',
                                                                      ])
                                                                  }}"
                                                          >As CSV</a>
                                                        </li>
                                                        <li><a href="{{ route('excel.payments',
                                                                      ['pdf',
                                                                        'start_date' => app('request')->input('start_date'),
                                                                        'end_date' => app('request')->input('end_date'),
                                                                        'paybills' => app('request')->input('paybills'),
                                                                        'account_search' => app('request')->input('account_search'),
                                                                        'limit' => app('request')->input('limit'),
                                                                        'report' => '1',
                                                                      ])
                                                                  }}"
                                                          >As PDF</a>
                                                        </li>

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
                                            <select class="selectpicker form-control" name="processed"
                                            data-style="form-control btn-default btn-outline">

                                                <li class="mb-10">

                                                <option value=""
                                                    @if (app('request')->input('processed') == "")
                                                        selected="selected"
                                                    @endif
                                                    >
                                                    Processed - All
                                                </option>

                                                </li>

                                                <li class="mb-10">

                                                <option value="1"
                                                    @if (app('request')->input('processed') == 1)
                                                        selected="selected"
                                                    @endif
                                                    >
                                                    <span class="text-success">Processed - True</span>
                                                </option>

                                                </li>

                                                <li class="mb-10">

                                                <option value="99"
                                                    @if (app('request')->input('processed') == 99)
                                                        selected="selected"
                                                    @endif
                                                    >
                                                    <span class="text-danger">Processed - False</span>
                                                </option>

                                                </li>

                                            </select>
                                        </div>

                                        @if (Auth::user()->hasRole('superadministrator'))

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

                                            <div class="col-sm-12 col-sm-6 col-md-1">

                                                <select class="selectpicker form-control" name="paybills"
                                                data-style="form-control btn-default btn-outline">

                                                    <li class="mb-10">
                                                        <option value=""
                                                        @if (!(app('request')->input('paybills')) ||
                                                                checkCharExists(',', (app('request')->input('paybills')))
                                                            )
                                                            selected="selected"
                                                        @endif
                                                        >Select Paybill
                                                        </option>
                                                    </li>

                                                    @foreach ($mpesapaybills as $mpesapaybill)

                                                    <li class="mb-10">

                                                        <option value="{{ $mpesapaybill->paybill_number }}"

                                                            @if (($mpesapaybill->paybill_number == app('request')->input('paybills')) &&
                                                                !(checkCharExists(',', (app('request')->input('paybills'))))
                                                                )
                                                                selected="selected"
                                                            @endif

                                                        >

                                                        {{ $mpesapaybill->paybill_number }} -
                                                        {{ $mpesapaybill->name }}

                                                        </option>

                                                    </li>

                                                    @endforeach

                                                </select>

                                            </div>

                                        @else

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

                                        @endif

                                        <div class="col-sm-12 mt-5">
                                            <button class="btn btn-primary btn-block">Filter</button>
                                        </div>

                                    </td>

                                 </tr>
                               </table>
                            </form>

                          </div>
                          <div class="clearfix"></div>

                       </div>


                     @if (!count($payments))

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
                                              <th width="10%">Company</th>
                                              <th width="8%">Account No</th>
                                              <th width="9%">Account Name</th>
                                              <th width="8%">Phone</th>
                                              <th width="5%">Trans Id</th>
                                              <th width="8%">Full Name</th>
                                              <th width="7%" class="text-right">Amount</th>
                                              <th width="5%">Paybill</th>
                                              <th width="5%">Processed</th>
                                              <th width="10%">Created At</th>
                                              <th width="20%">Actions</th>
                                           </tr>
                                        </thead>
                                        <tbody>

                                           @foreach ($payments as $payment)
                                             <tr>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $payment->id }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    @if ($payment->company)
                                                    {{ $payment->company->name }}
                                                    @endif
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $payment->account_no }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ titlecase($payment->account_name) }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $payment->phone }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $payment->trans_id }}
                                                  </span>
                                                </td>

                                                <td>
                                                    <span class="txt-dark">
                                                      {{ $payment->full_name }}
                                                    </span>
                                                </td>

                                                <td align="right">
                                                  <span class="txt-dark weight-600">
                                                      @if ($payment->amount)
                                                        {{ format_num($payment->amount) }}
                                                      @endif
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $payment->paybill_number }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark ">
                                                     @if (($payment->processed) && (!$payment->modified))
                                                       <span class="text-success">True</span>
                                                     @elseif (($payment->processed) && ($payment->modified))
                                                       <span class="text-primary">True</span>
                                                     @else
                                                       <span class="text-danger">False</span>
                                                     @endif
                                                  </span>
                                               </td>

                                                <td>
                                                   <span class="txt-dark">
                                                   {{ formatFriendlyDate($payment->created_at) }}
                                                   </span>
                                                </td>

                                                <td>

                                                   <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square" title="View">
                                                    <i class="zmdi zmdi-eye"></i>
                                                   </a>

                                                   @if (!$payment->processed)

                                                   <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square" title="Edit">
                                                      <i class="zmdi zmdi-edit"></i>
                                                   </a>

                                                   <a href="{{ route('payments.repost', $payment->id) }}" class="btn btn-success btn-sm btn-icon-anim btn-square" title="Repost - ID - {{ $payment->id }}">
                                                      <i class="zmdi zmdi-refresh-sync"></i>
                                                   </a>

                                                   @endif

                                                </td>
                                             </tr>
                                           @endforeach

                                        </tbody>
                                     </table>
                                  </div>
                               </div>
                               <hr>
                               <div class="text-center mb-20">

                                   {{ $payments->links() }}

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



