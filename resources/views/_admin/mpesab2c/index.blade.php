@extends('_admin.layouts.master')

@section('title')

    Manage Mpesa B2C Transactions

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
                Manage Mpesa B2C Transactions
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('mpesab2c') !!}
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

                              @if (count($mpesab2cs))
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
                                            <a href="{{ route('excel.mpesab2c',
                                                        ['xls',
                                                          'start_date' => app('request')->input('start_date'),
                                                          'end_date' => app('request')->input('end_date'),
                                                          'limit' => app('request')->input('limit'),
                                                        ])
                                                     }}"
                                            >As Excel</a>
                                          </li>
                                          <li><a href="{{ route('excel.mpesab2c', 'csv') }}">As CSV</a></li>
                                          <li><a href="{{ route('excel.mpesab2c', 'pdf') }}">As PDF</a></li>

                                       </ul>
                                    </div>
                                </div>
                              @endif

                          </div>

                          <div class="pull-right col-sm-9">

                            <form action="{{ route('mpesab2c.index') }}">
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

                                      <select class="selectpicker form-control" name="paybills"
                                        data-style="form-control btn-default btn-outline">

                                          <li class="mb-10">
                                              <option value=""
                                                @if (!(app('request')->input('paybills')) ||
                                                      checkCharExists(',', (app('request')->input('paybills')))
                                                    )
                                                    selected="selected"
                                                @endif
                                              >Select Shortcode
                                              </option>
                                          </li>

                                          @foreach ($mpesashortcodes as $mpesashortcodes)

                                            <li class="mb-10">

                                              <option value="{{ $mpesashortcodes->shortcode_number }}"

                                                  @if (($mpesashortcodes->shortcode_number == app('request')->input('paybills')) &&
                                                      !(checkCharExists(',', (app('request')->input('paybills'))))
                                                      )
                                                      selected="selected"
                                                  @endif

                                                >

                                                {{ $mpesashortcodes->shortcode_number }} -
                                                {{ $mpesashortcodes->company->name }}

                                              </option>

                                            </li>

                                          @endforeach

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


                     @if (!count($mpesashortcodes))

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

                                              <th width="15%">Full Name</th>
                                              <th width="10%">Mobile</th>
                                              <th width="10%">Shortcode</th>
                                              <th width="10%">Trans Id</th>

                                              <th width="10%" class="text-right">Amount</th>
                                              <th width="15%">Res Desc</th>

                                              <th width="10%">Created At</th>
                                              <th width="15%">Actions</th>


                                              {{-- 'id' => (int)$model->id,
                                              'date_stamp' => $model->date_stamp,
                                              'ini_shortcode' => $model->ini_shortcode,
                                              'orig_con_id' => $model->orig_con_id,
                                              'con_id' => $model->con_id,
                                              'trans_id' => $model->trans_id,
                                              'receiver' => $model->receiver,
                                              'rx_mobile' => $model->rx_mobile,
                                              'rx_fullname' => $model->rx_fullname,
                                              'completed_time' => $model->completed_time,
                                              'utility_bal' => $model->utility_bal,
                                              'working_bal' => $model->working_bal,
                                              'reg_customer' => $model->reg_customer,
                                              'charges_pd_bal' => $model->charges_pd_bal,
                                              'trans_amount' => $model->trans_amount,
                                              'trans_receipt' => $model->trans_receipt,
                                              'occasion' => $model->occasion,
                                              'timeout_url' => $model->timeout_url --}}



                                           </tr>
                                        </thead>
                                        <tbody>

                                           @foreach ($mpesab2cs as $mpesab2c)
                                             <tr>

                                                <td>
                                                  <span class="txt-dark ">
                                                    {{ $mpesab2c->id }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $mpesab2c->rx_fullname }}
                                                  </span>
                                                </td>

                                                <td class="txt-dark">
                                                    {{ $mpesab2c->rx_mobile }}
                                                </td>


                                                <td>
                                                  <span class="txt-dark ">
                                                    {{ $mpesab2c->ini_shortcode }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark ">
                                                    {{ $mpesab2c->trans_id }}
                                                  </span>
                                                </td>


                                                <td align="right">
                                                  <span class="weight-600 txt-dark">
                                                      @if ($mpesab2c->trans_amount)
                                                        {{ format_num($mpesab2c->trans_amount) }}
                                                      @endif
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark ">
                                                    {{ $mpesab2c->res_desc }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark ">
                                                    {{ formatFriendlyDate($mpesab2c->date_stamp) }}
                                                  </span>
                                                </td>

                                                <td>

                                                   <a href="{{ route('mpesab2c.show', $mpesab2c->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square" title="View">
                                                    <i class="zmdi zmdi-eye"></i>
                                                   </a>

                                                   {{-- <a href="{{ route('mpesab2c.edit', $mpesab2c->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square" title="Edit">
                                                      <i class="zmdi zmdi-edit"></i>
                                                   </a>

                                                   <a href="{{ route('mpesab2c.repost', $mpesab2c->id) }}" class="btn btn-success btn-sm btn-icon-anim btn-square" title="Repost - ID - {{ $mpesab2c->id }}">
                                                      <i class="zmdi zmdi-refresh-sync"></i>
                                                   </a> --}}

                                                </td>
                                             </tr>
                                           @endforeach

                                        </tbody>
                                     </table>
                                  </div>
                               </div>
                               <hr>
                               <div class="text-center mb-20">

                                   {{ $mpesab2cs->links() }}

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



