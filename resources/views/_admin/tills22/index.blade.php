@extends('_admin.layouts.master')

@section('title')

    Manage Mpesa Paybills

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
                Manage Mpesa Paybills
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('mpesa-paybills') !!}
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

                            <form action="{{ route('mpesa-paybills.index') }}">
                                <table class="table table-search">
                                  <tr>

                                  <td>

                                    <div class="pull-left col-sm-12 col-sm-6 col-md-2">

                                      <a
                                        href="{{ route('mpesa-paybills.create') }}"
                                        class="btn btn-primary btn-icon right-icon mr-5">
                                        <span>New</span>
                                        <i class="fa fa-plus"></i>
                                      </a>

                                      @if (count($mpesapaybills))
                                          {{-- <div class="btn-group">
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
                                                      <a href="{{ route('excel.deposit-accounts-summary',
                                                                  ['xls',
                                                                  'start_date' => app('request')->input('start_date'),
                                                                  'end_date' => app('request')->input('end_date'),
                                                                  'account_search' => app('request')->input('account_search'),
                                                                  'limit' => app('request')->input('limit'),
                                                                  ])
                                                              }}"
                                                      >As Excel</a>
                                                  </li>
                                                  <li><a href="{{ route('excel.deposit-accounts-summary',
                                                                  ['csv',
                                                                  'start_date' => app('request')->input('start_date'),
                                                                  'end_date' => app('request')->input('end_date'),
                                                                  'account_search' => app('request')->input('account_search'),
                                                                  'limit' => app('request')->input('limit'),
                                                                  ]) }}">As CSV</a></li>
                                                  <li><a href="{{ route('excel.deposit-accounts-summary',
                                                                  ['pdf',
                                                                  'start_date' => app('request')->input('start_date'),
                                                                  'end_date' => app('request')->input('end_date'),
                                                                  'account_search' => app('request')->input('account_search'),
                                                                  'limit' => app('request')->input('limit'),
                                                                  ]) }}">As PDF</a></li>

                                                    </ul>
                                                </div>
                                          </div> --}}
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

                          </div>
                          <div class="clearfix"></div>



                       </div>


                     @if (!count($mpesapaybills))

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
                                              <th width="10%">Paybill No.</th>
                                              <th width="10%">Till No.</th>
                                              <th width="10%">Paybill Type</th>
                                              <th width="15%">Name</th>
                                              <th width="15%">Company</th>
                                              <th width="15%">Created At</th>
                                              <th width="20%">Actions</th>
                                           </tr>
                                        </thead>
                                        <tbody>

                                           @foreach ($mpesapaybills as $mpesapaybill)
                                             <tr>

                                                <td>
                                                  <span class="txt-dark weight-500">
                                                    {{ $mpesapaybill->id }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark weight-500">
                                                    {{ $mpesapaybill->paybill_number }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark weight-500">
                                                    {{ $mpesapaybill->till_number }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark weight-500">
                                                    {{ $mpesapaybill->type }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark weight-500">
                                                    {{ $mpesapaybill->name }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark weight-500">
                                                    @if ($mpesapaybill->company)
                                                      {{ $mpesapaybill->company->name }}
                                                    @endif
                                                  </span>
                                                </td>

                                                <td>
                                                   <span class="txt-dark weight-500">
                                                     @if ($mpesapaybill->created_at)
                                                        {{ formatFriendlyDate($mpesapaybill->created_at) }}
                                                     @endif
                                                   </span>
                                                </td>

                                                <td>

                                                   <a href="{{ route('mpesa-paybills.show', $mpesapaybill->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-eye"></i>
                                                   </a>

                                                   @if (Auth::user()->can('update-paybill'))
                                                     <a href="{{ route('mpesa-paybills.edit', $mpesapaybill->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                        <i class="zmdi zmdi-edit"></i>
                                                     </a>
                                                   @endif

                                                   @if (Auth::user()->can('delete-paybill'))
                                                     <a href="{{ route('mpesa-paybills.destroy', $mpesapaybill->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
                                                        <i class="zmdi zmdi-delete"></i>
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
                               <div class="text-center">
                                   {{ $mpesapaybills->links() }}
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

@endsection

