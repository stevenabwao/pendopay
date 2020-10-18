@extends('_admin.layouts.master')

@section('title')

    Admin Home

@endsection


@section('content')

    <div class="container-fluid pt-25">
        <!-- Row -->
        <div class="row">
           <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <div class="panel panel-default card-view pa-0">
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                       <div class="sm-data-box bg-primary">
                          <div class="container-fluid">
                             <div class="row">
                                <div class="col-xs-8 text-center pl-0 pr-0 data-wrap-left">
                                   <span class="txt-light block counter">
                                      <span class="counter-anim">
                                        {{ $establishmentscount }}
                                      </span>
                                   </span>
                                   <span class="weight-500 uppercase-font txt-light block font-13">
                                        Transactions
                                   </span>
                                </div>
                                <div class="col-xs-4 text-center  pl-0 pr-0 data-wrap-right">
                                   <i class="zmdi zmdi-store txt-light data-right-rep-icon"></i>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <div class="panel panel-default card-view pa-0">
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                       <div class="sm-data-box bg-green">
                          <div class="container-fluid">
                             <div class="row">
                                <div class="col-xs-8 text-center pl-0 pr-0 data-wrap-left">
                                   <span class="txt-light block counter">
                                      <span class="counter-anim">
                                      {{ $completedorderscount }}
                                      </span>
                                   </span>
                                   <span class="weight-500 uppercase-font txt-light block">
                                      Completed Transactions
                                   </span>
                                </div>
                                <div class="col-xs-4 text-center  pl-0 pr-0 data-wrap-right">
                                   <i class="zmdi zmdi-shopping-cart txt-light data-right-rep-icon"></i>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <div class="panel panel-default card-view pa-0">
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                       <div class="sm-data-box bg-yellow">
                          <div class="container-fluid">
                             <div class="row">
                                <div class="col-xs-8 text-center pl-0 pr-0 data-wrap-left">
                                    <span class="txt-light block counter">
                                      <span class="counter-anim">
                                        {{ $activeorderscount }}
                                      </span>
                                    </span>
                                    <span class="weight-500 uppercase-font txt-light block">
                                      Active Transactions
                                    </span>
                                </div>
                                <div class="col-xs-4 text-center  pl-0 pr-0 data-wrap-right">
                                   <i class="zmdi zmdi-shopping-cart-plus txt-light data-right-rep-icon"></i>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
              <div class="panel panel-default card-view pa-0">
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body pa-0">
                       <div class="sm-data-box bg-red">
                          <div class="container-fluid">
                             <div class="row">
                                <div class="col-xs-8 text-center pl-0 pr-0 data-wrap-left">
                                    <span class="txt-light block counter">
                                      <span class="counter-anim">
                                        {{ $pendingorderscount }}
                                      </span>
                                    </span>
                                    <span class="weight-500 uppercase-font txt-light block">
                                       Pending Orders
                                    </span>
                                </div>
                                <div class="col-xs-4 text-center  pl-0 pr-0 data-wrap-right">
                                   <i class="zmdi zmdi-shopping-cart txt-light data-right-rep-icon"></i>
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

        <!-- Row -->
        <div class="row">
           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
               <div class="panel panel-default card-view equalheight">
                  <div class="panel-heading">
                     <div class="pull-left">
                        <h6 class="panel-title txt-dark">Cash Out</h6>
                     </div>
                     <div class="pull-right">
                        {{-- <span class="no-margin-switcher">
                           <input type="checkbox" id="morris_switch"  class="js-switch" data-color="#ff2a00" data-secondary-color="#2879ff" data-size="small"/>
                        </span> --}}
                     </div>
                     <div class="clearfix"></div>
                  </div>
                  <div class="panel-wrapper collapse in">
                              <div class="panel-body">
                        <div id="morris_extra_line_chart" class="morris-chart" style="height:293px;"></div>
                        <ul class="flex-stat mt-40">
                           <li>
                              <span class="block">Avg Monthly</span>
                              <span class="block txt-dark weight-500 font-18"><span class="counter-anim">3,24,222</span></span>
                           </li>
                           <li>
                              <span class="block">Avg Weekly</span>
                              <span class="block txt-dark weight-500 font-18"><span class="counter-anim">1,23,432</span></span>
                           </li>
                           <li>
                              <span class="block">Trend</span>
                              <span class="block">
                                 <i class="zmdi zmdi-trending-up txt-success font-24"></i>
                              </span>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
           </div>

           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                   <div class="panel panel-default card-view panel-refresh equalheight">
                     <div class="refresh-container">
                        <div class="la-anim-1"></div>
                     </div>
                     <div class="panel-heading">
                        <div class="pull-left">
                           <h6 class="panel-title txt-dark">Orders</h6>
                        </div>
                        <div class="pull-right">

                        </div>
                        <div class="clearfix"></div>
                     </div>
                     <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                           <div>
                              <canvas id="chart_orders" height="191"></canvas>
                           </div>
                           <hr class="light-grey-hr row mt-10 mb-15"/>
                           <div class="label-chatrs">
                              <div class="">
                                 <span class="clabels clabels-lg inline-block bg-yellow mr-10 pull-left"></span>
                                 <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                    <span class="block font-15 weight-500 mb-5">{{ $activeorderscountpercent }}% Active Orders</span>
                                    <span class="block txt-grey">{{ $activeorderscount }} order(s)</span>
                                 </span>
                                 <div id="sparkline_active" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;"></div>
                                 <div class="clearfix"></div>
                              </div>
                           </div>
                           <hr class="light-grey-hr row mt-10 mb-15"/>
                           <div class="label-chatrs">
                              <div class="">
                                 <span class="clabels clabels-lg inline-block bg-red mr-10 pull-left"></span>
                                 <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left">
                                    <span class="block font-15 weight-500 mb-5">{{ $pendingorderscountpercent }}% Pending Orders</span>
                                    <span class="block txt-grey">{{ $pendingorderscount }} order(s)</span>
                                 </span>
                                 <div id="sparkline_pending" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;"></div>
                                 <div class="clearfix"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
           </div>
        </div>
        <!-- /Row -->

        <!-- Row -->
        <div class="row">
           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh equalheight">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading">
                    <div class="pull-left">
                       <h6 class="panel-title txt-dark">Recent Offers</h6>
                    </div>
                    <div class="pull-right">
                       {{-- <a href="#" class="pull-left inline-block refresh mr-15">
                          <i class="zmdi zmdi-replay"></i>
                       </a>
                       <a href="#" class="pull-left inline-block full-screen mr-15">
                          <i class="zmdi zmdi-fullscreen"></i>
                       </a>
                       <div class="pull-left inline-block dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                          <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Edit</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Delete</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>New</a></li>
                          </ul>
                       </div> --}}
                    </div>
                    <div class="clearfix"></div>
                 </div>
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body row pa-0">
                       <div class="table-wrap">
                          <div class="table-responsive">

                              @if(count($offers))

                                 <table class="table table-hover mb-0">

                                    <thead>
                                          <tr>

                                             @if (isSuperAdmin())
                                                <th width="30%">Name</th>
                                                <th width="25%">Establishment</th>
                                                <th width="25%">Offer Date</th>
                                                <th width="20%">Created</th>
                                             @else
                                                <th width="40%">Name</th>
                                                <th width="3%">Offer Date</th>
                                                <th width="30%">Created</th>
                                             @endif

                                          </tr>
                                    </thead>

                                    <tbody>

                                          @foreach ($offers as $offer)
                                             <tr>
                                                <td>
                                                   <span class="txt-dark weight-500">
                                                      @if($offer->name)
                                                      <a href="{{ route('admin.offers.show', $offer->id) }}">
                                                         {{ titlecase($offer->name) }}
                                                      </a>
                                                      @endif
                                                   </span>
                                                </td>

                                                @if (isSuperAdmin())
                                                   <td>
                                                      @if ($offer->company)
                                                      <span class="txt-dark weight-500">
                                                         {{ $offer->company->name }}
                                                      </span>
                                                      @endif
                                                   </td>

                                                @endif

                                                <td>
                                                   <span class="txt-dark weight-500">
                                                      {{ formatFriendlyDate($offer->start_at) }}
                                                   </span>
                                                </td>

                                                <td>
                                                      <span class="txt-dark weight-500">
                                                      {{ formatFriendlyDate($offer->created_at) }}
                                                      </span>
                                                   </td>

                                             </tr>
                                          @endforeach

                                    </tbody>
                                 </table>

                             @else

                                 <div class="panel panel-danger text-center">
                                    <div class="panel-body">
                                    <br>
                                    <h5 class="text-danger">No records</h5>
                                    </div>
                                 </div>

                             @endif

                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
           <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh equalheight">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading">
                    <div class="pull-left">
                       <h6 class="panel-title txt-dark">Recent Orders</h6>
                    </div>
                    <div class="pull-right">
                       {{-- <a href="#" class="pull-left inline-block refresh mr-15">
                          <i class="zmdi zmdi-replay"></i>
                       </a>
                       <a href="#" class="pull-left inline-block full-screen mr-15">
                          <i class="zmdi zmdi-fullscreen"></i>
                       </a> --}}
                       {{-- <div class="pull-left inline-block dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                          <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Edit</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Delete</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>New</a></li>
                          </ul>
                       </div> --}}
                    </div>
                    <div class="clearfix"></div>
                 </div>
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body row pa-0">
                       <div class="table-wrap">
                          <div class="table-responsive">

                              @if (count($orders))

                                 <table class="table table-hover mb-0">

                                       <thead>
                                          <tr>

                                             @if (isSuperAdmin())
                                                <th width="25%">Client Name</th>
                                                <th width="15%" class="text-right">Amount</th>
                                                <th width="15%">Status</th>
                                                <th width="25%">Establishment</th>
                                             @else
                                                <th width="35%">Client Name</th>
                                                <th width="25%" align="right">Amount</th>
                                                <th width="20%">Status</th>
                                             @endif

                                             <th width="20%">Created</th>

                                          </tr>
                                       </thead>

                                    <tbody>

                                          @foreach ($orders as $order)

                                          <tr>

                                             <td>
                                                <span class="txt-dark weight-500">
                                                    @if($order->client)
                                                        <a href="{{ route('admin.orders.show', $order->id) }}">
                                                            {!! showStatusText($order->status_id, "", "", $order->client->fullName) !!}
                                                        </a>
                                                    @endif
                                                </span>
                                             </td>

                                             <td align="right">
                                                <span class="txt-dark weight-500 text-right">
                                                   {{ format_num($order->total) }}
                                                </span>
                                             </td>

                                             <td>
                                                <span class="txt-dark weight-500">
                                                    @if($order->status)
                                                            {!! showStatusText($order->status_id, "", "", $order->status->name) !!}
                                                    @endif
                                                </span>
                                             </td>

                                             @if (isSuperAdmin())
                                                <td>
                                                   @if ($order->company)
                                                   {{ $order->company->name }}
                                                   @endif
                                                </td>
                                             @endif

                                             <td>
                                                <span class="txt-dark weight-500">
                                                   {{ formatFriendlyDate($order->created_at) }}
                                                </span>
                                             </td>

                                          </tr>
                                          @endforeach


                                    </tbody>
                                 </table>

                             @else

                                 <div class="panel panel-danger text-center">
                                    <div class="panel-body">
                                       <br>
                                       <h5 class="text-danger">No records</h5>
                                    </div>
                                 </div>

                             @endif

                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </div>
        <!-- Row -->

    </div>

@endsection


@section('page_scripts')

   @include('_admin.layouts.partials.dashboard-data.dashboard-data')

   <script src="{{ asset('_admin/js/bootstrap-datetimepicker.min.js') }}"></script>

@endsection
