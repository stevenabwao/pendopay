@extends('_admin.layouts.master')

@section('title')

    Manage SMS Outbox

@endsection

@section('css_header')

    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

		   <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Manage SMS Outbox</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

              {!! Breadcrumbs::render('smsoutbox') !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

       @if (session('success'))
        <div class="row">
          <div class="col-sm-12 col-xs-12">
            <div class="alert alert-success text-center">
                {!! session('success') !!}
            </div>
          </div>
        </div>
      @endif

       <!-- Row -->
        <div class="row">
           <div class="col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading panel-heading-dark">

                    {{-- <div class="pull-left col-sm-4">

                       <a
                          href="{{ route('smsoutbox.create') }}"
                          class="btn btn-sm btn-primary  btn-icon right-icon mr-5">
                          <span>New</span>
                          <i class="fa fa-plus"></i>
                        </a>

                        <div class="btn-group">

                            @if (count($smsoutboxes))
                              <div class="dropdown">
                                 <button
                                    aria-expanded="false"
                                    data-toggle="dropdown"
                                    class="btn btn-sm btn-success  dropdown-toggle "
                                    type="button">
                                    Download
                                    <span class="caret ml-10"></span>
                                 </button>
                                 <ul role="menu" class="dropdown-menu">
                                    <li><a href="{{ route('excel.export-smsoutbox', 'xls') }}">As Excel</a></li>
                                    <li><a href="{{ route('excel.export-smsoutbox', 'csv') }}">As CSV</a></li>
                                    <li><a href="{{ route('excel.export-smsoutbox', 'pdf') }}">As PDF</a></li>
                                 </ul>
                              </div>
                            @endif

                        </div>

                    </div> --}}

                    <div>

                        <form action="{{ route('smsoutbox.index') }}">
                          <table class="table table-search">
                            <tr>

                                <td>

                                  <div class="pull-left col-sm-12 col-sm-6 col-md-2">

                                    @if (count($smsoutboxes))
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
                                                    <a href="{{ route('excel.export-smsoutbox',
                                                                ['xls',
                                                                'start_date' => app('request')->input('start_date'),
                                                                'end_date' => app('request')->input('end_date'),
                                                                'account_search' => app('request')->input('account_search'),
                                                                'limit' => app('request')->input('limit'),
                                                                ])
                                                            }}"
                                                    >As Excel</a>
                                                </li>
                                                <li><a href="{{ route('excel.export-smsoutbox',
                                                                ['csv',
                                                                'start_date' => app('request')->input('start_date'),
                                                                'end_date' => app('request')->input('end_date'),
                                                                'account_search' => app('request')->input('account_search'),
                                                                'limit' => app('request')->input('limit'),
                                                                ]) }}">As CSV</a></li>
                                                <li><a href="{{ route('excel.export-smsoutbox',
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

                                      <select class="selectpicker form-control" name="companies"
                                        data-style="form-control btn-default btn-outline">

                                          <li class="mb-10">
                                              <option value=""
                                                @if (!(app('request')->input('companies')) ||
                                                      checkCharExists(',', (app('request')->input('companies')))
                                                    )
                                                    selected="selected"
                                                @endif
                                              >Select company
                                              </option>
                                          </li>

                                          @foreach ($companies as $company)

                                            <li class="mb-10">

                                              <option value="{{ $company->id }}"

                                                  @if (($company->id == app('request')->input('companies')) &&
                                                      !(checkCharExists(',', (app('request')->input('companies'))))
                                                      )
                                                      selected="selected"
                                                  @endif

                                                >

                                                {{ $company->name }}

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

                                  <div class="col-sm-12 col-sm-12 col-md-1">
                                      <button class="btn btn-primary btn-block">Filter</button>
                                  </div>

                                </td>

                            </tr>
                          </table>
                        </form>

                       {{-- <form action="{{ route('smsoutbox.index') }}">
                            <table class="table table-search">
                              <tr>

                                <td>
                                  <input type="hidden" value="1" name="search">

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

                                </td>

                                <td>

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

                                </td>

                                <td>

                                    <a class="btn btn-default btn-icon-anim btn-circle"
                                    data-toggle="tooltip" data-placement="top"
                                    title="Clear dates" id="clear_date">
                                      <i class="zmdi zmdi-chart-donut"></i>
                                    </a>

                                </td>

                                <td>

                                  <select class="selectpicker form-control" name="limit"
                                    data-style="form-control btn-default btn-outline">

                                        <li class="mb-10">

                                          <option value="10"
                                              @if (app('request')->input('limit') == 10)
                                                  selected="selected"
                                              @endif
                                            >
                                            10
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

                                </td>

                                @if (Auth::user()->hasRole('superadministrator'))
                                <td>

                                  <select class="selectpicker form-control" name="companies"
                                    data-style="form-control btn-default btn-outline">

                                    <li class="mb-10"><option value="">Select Company</option></li>

                                      @foreach ($companies as $company)
                                        <li class="mb-10">

                                          <option value="{{ $company->id }}"

                                              @if ($company->id == app('request')->input('companies'))
                                                  selected="selected"
                                              @endif

                                            >

                                            {{ $company->name }}

                                          </option>

                                        </li>
                                      @endforeach



                                    </select>

                                </td>
                                @endif

                                <td>
                                  <button class="btn btn-primary">Filter</button>
                                </td>
                              </tr>
                            </table>
                       </form> --}}

                    </div>
                    <div class="clearfix"></div>
                 </div>


                 @if (!count($smsoutboxes))

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
                                          <th width="35%">Message</th>

                                          @if (Auth::user()->hasRole('superadministrator'))
                                            <th width="10%">Phone</th>
                                            <th width="10%">Status</th>
                                            <th width="10%">Bulk SMS Name</th>
                                          @else
                                            <th width="15%">Phone</th>
                                            <th width="15%">Status</th>
                                          @endif

                                          <th width="15%">Created</th>
                                          <th width="15%">Actions</th>

                                       </tr>

                                    </thead>
                                    <tbody>

                                       @foreach ($smsoutboxes as $smsoutbox)
    	                                   <tr>
    	                                      <td>
    	                                      	<span class="txt-dark weight-500">
    	                                      		{{ $smsoutbox->id }}
    	                                      	</span>
    	                                      </td>
    	                                      <td>
                                              <span class="txt-dark weight-500">
                                                {{ $smsoutbox->msg_text }}
                                              </span>
                                            </td>
    	                                      <td>
                                               <span class="txt-dark weight-500">
                                                {{ $smsoutbox->dest }}
                                               </span>
                                            </td>
                                            <td>
                                               <span class="txt-dark weight-500">

                                                  @if ($smsoutbox->status == "DeliveredToTerminal")
                                                    <span class="txt-dark text-success">
                                                        Delivered
                                                    </span>
                                                  @elseif ($smsoutbox->status == "failed")
                                                    <span class="txt-dark text-warning">
                                                        Pending
                                                    </span>
                                                  @else
                                                    <span class="txt-dark text-danger">
                                                      {{ $smsoutbox->status }}
                                                    </span>
                                                  @endif

                                               </span>
                                            </td>

                                            @if (Auth::user()->hasRole('superadministrator'))

                                                <td>
                                                  <span class="txt-dark weight-500">
                                                    {{ $smsoutbox->category }}
                                                  </span>
                                                </td>

                                            @endif

    	                                      <td>
    	                                         <span class="txt-dark weight-500">
                                                  {{ formatFriendlyDate($smsoutbox->finish_time) }}
    	                                         </span>
    	                                      </td>
    	                                      <td>

                  								             <a href="{{ route('smsoutbox.show', $smsoutbox->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
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
                           <div class="text-center">
    							             {{ $smsoutboxes->links() }}
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
