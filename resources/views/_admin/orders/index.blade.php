@extends('_admin.layouts.master')

@section('title')
    Manage Orders
@endsection

<?php
   $data = [
        'parent' => $orders,
        'companies' => $companies,
        'statuses' => $statuses
   ]
?>

@section('post_page'){!! route('admin.orders.index') !!}@endsection

@section('excel_xls_url')
   {{ route('excel.orders',
      ['xls',
      'start_date' => app('request')->input('start_date'),
      'end_date' => app('request')->input('end_date'),
      'account_search' => app('request')->input('account_search'),
      'status_id' => app('request')->input('status_id'),
      'companies' => app('request')->input('companies'),
      'limit' => app('request')->input('limit'),
      ])
   }}
@endsection

@section('excel_csv_url')
   {{ route('excel.orders',
      ['csv',
      'start_date' => app('request')->input('start_date'),
      'end_date' => app('request')->input('end_date'),
      'account_search' => app('request')->input('account_search'),
      'status_id' => app('request')->input('status_id'),
      'companies' => app('request')->input('companies'),
      'limit' => app('request')->input('limit'),
      ])
   }}
@endsection

@section('excel_pdf_url')
   {{ route('excel.orders',
      ['pdf',
      'start_date' => app('request')->input('start_date'),
      'end_date' => app('request')->input('end_date'),
      'account_search' => app('request')->input('account_search'),
      'status_id' => app('request')->input('status_id'),
      'companies' => app('request')->input('companies'),
      'limit' => app('request')->input('limit'),
      ])
   }}
@endsection

@section('page_breadcrumbs')
   {!! Breadcrumbs::render('admin.orders') !!}
@endsection

@section('css_header')

    <link href="{{ asset('_admin/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('_admin/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

		   <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
          <h5 class="txt-dark">
                Manage Orders
            </h5>
          </div>

          <!-- Breadcrumb -->
          @include('_admin.layouts.partials.breadcrumbs')
          <!-- /Breadcrumb -->

       </div>
       <!-- /Title -->

       <!-- Row -->
        <div class="row">
           <div class="col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">

                  <div class="refresh-container">
                     <div class="la-anim-1"></div>
                  </div>
                  <div class="panel-heading panel-heading-dark">

                     <!-- searchbar -->
                     @include('_admin.layouts.partials.searchbar', $data)
                     <!-- /searchbar -->

                  </div>


                  @if (!count($orders))

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
                                          <th width="5%">ID</th>
                                          <th width="10%">Est. Name</th>
                                          <th width="15%">Client Name</th>
                                          <th width="25%">Offer Name</th>
                                          <th class="text-right" width="10%">Total</th>
                                          <th width="10%">Status</th>
                                          <th width="15%">Created</th>
                                          <th width="10%">Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($orders as $order)
                                          <tr>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   {{ $order->id }}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                    {!! showStatusText($order->status_id, "", "", $order->company->name) !!}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                    {!! showStatusText($order->status_id, "", "", $order->client->fullName) !!}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   @if($order->offer)
                                                      {{ $order->offer->name }}
                                                   @endif
                                                </span>
                                             </td>
                                             <td align="right">
                                                <span class="txt-dark weight-500">
                                                   @if($order->total)
                                                      {{ formatCurrency($order->total) }}
                                                   @endif
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   @if($order->status)
                                                        {!! showStatusText($order->status_id, "", "", $order->status->name) !!}
                                                   @endif
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                {{ formatFriendlyDate($order->created_at) }}
                                                </span>
                                             </td>
                                             <td>

                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                   <i class="zmdi zmdi-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                   <i class="zmdi zmdi-edit"></i>
                                                </a>

                                                   {{--<a href="{{ route('admin.orders.destroy', $order->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
                                                      <i class="zmdi zmdi-delete"></i>
                                                   </a>--}}

                                             </td>
                                          </tr>
                                       @endforeach

                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <hr>
                           <div class="text-center">
                                       {{ $orders->links() }}
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

  <script src="{{ asset('_admin/js/bootstrap-datetimepicker.min.js') }}"></script>
  <script src="{{ asset('_admin/js/bootstrap-select.min.js') }}"></script>

  <!-- search scripts -->
  @include('_admin.layouts.searchScripts')
  <!-- /search scripts -->

@endsection
