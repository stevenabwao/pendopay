@extends('_admin.layouts.master')

@section('title')

    Manage USSD Events

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
                Manage USSD Events
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('ussd-events') !!}
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

                          <div class="pull-left col-sm-3">

                              @if (count($ussdevents))
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
                                            <a href="{{ route('excel.ussd-events',
                                                        ['xls',
                                                          'start_date' => app('request')->input('start_date'),
                                                          'end_date' => app('request')->input('end_date'),
                                                          'paybills' => app('request')->input('paybills'),
                                                          'limit' => app('request')->input('limit'),
                                                        ])
                                                     }}"
                                            >As Excel</a>
                                          </li>
                                          <li><a href="{{ route('excel.ussd-events', 'csv') }}">As CSV</a></li>
                                          <li><a href="{{ route('excel.ussd-events', 'pdf') }}">As PDF</a></li>

                                       </ul>
                                    </div>
                                </div>
                              @endif

                          </div>

                          <div class="pull-right col-sm-9">

                            <form action="{{ route('ussd-events.index') }}">
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

                                    </td>


                                    <td>
                                      <button class="btn btn-primary">Filter</button>
                                    </td>
                                 </tr>
                               </table>
                            </form>

                          </div>
                          <div class="clearfix"></div>

                       </div>


                     @if (!count($ussdevents))

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
                                                <th width="10%">Event Name</th>
                                              @else
                                                <th width="20%">Event Name</th>
                                              @endif

                                              @if (Auth::user()->hasRole('superadministrator'))
                                                <th width="10%">Company</th>
                                              @endif

                                              <th width="10%">Event Type</th>
                                              <th width="10%">Event Cost</th>
                                              <th width="10%">Status</th>
                                              <th width="10%">Start At</th>
                                              <th width="10%">End At</th>
                                              <th width="15%">Created At</th>
                                              <th width="10%">Actions</th>
                                           </tr>
                                        </thead>
                                        <tbody>

                                           @foreach ($ussdevents as $ussdevt)
                                             <tr>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $ussdevt->id }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $ussdevt->name }}
                                                  </span>
                                                </td>

                                                @if (Auth::user()->hasRole('superadministrator'))
                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $ussdevt->company->name }}
                                                  </span>
                                                </td>
                                                @endif

                                                <td>
                                                  <span class="txt-dark">
                                                  @if ($ussdevt->ussdeventmap)
                                                     {{ $ussdevt->ussdeventmap->ussdeventtype->name }}
                                                  @endif
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                  {{ format_num($ussdevt->amount) }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $ussdevt->eventstatus->name }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ formatFriendlyDate($ussdevt->start_at) }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ formatFriendlyDate($ussdevt->end_at) }}
                                                  </span>
                                                </td>

                                                <td>
                                                   <span class="txt-dark">
                                                    {{ formatFriendlyDate($ussdevt->created_at) }}
                                                   </span>
                                                </td>

                                                <td>

                                                   <a href="{{ route('ussd-events.show', $ussdevt->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-eye"></i>
                                                   </a>

                                                   <a href="{{ route('ussd-events.edit', $ussdevt->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-edit"></i>
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

                                   {{ $ussdevents->links() }}

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



