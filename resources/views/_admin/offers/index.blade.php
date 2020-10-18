@extends('_admin.layouts.master')

@section('title')
    Manage Offers
@endsection

<?php
   $data = [
        'parent' => $offers,
        'companies' => $companies,
        'show_create_link' => 1
   ]
?>

@section('post_page')
   {!! route('admin.offers.index') !!}
@endsection

@section('create_page_link_title') Create New Offer @endsection

@section('create_page')
   {{ route('admin.offers.create') }}
@endsection

@section('excel_xls_url')
   {{ route('excel.admin.offers',
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
   {{ route('excel.admin.offers',
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
   {{ route('excel.admin.offers',
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
    {!! Breadcrumbs::render('admin.offers') !!}
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
                Manage Offers
            </h5>
          </div>

          <!-- Breadcrumb -->
          @include('_admin.layouts.partials.breadcrumbs')
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

                            <!-- searchbar -->
                            @include('_admin.layouts.partials.searchbar')
                            <!-- /searchbar -->

                       </div>


                     @if (!count($offers))

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
                                                <th width="20%">Offer Name</th>
                                                <th width="10%">Frequency</th>
                                                <th width="10%">Offer Type</th>
                                                <th width="15%">Establishment</th>
                                              <th width="10%">Status</th>
                                              <th width="15%">Created At</th>
                                              <th width="15%">Actions</th>
                                           </tr>
                                        </thead>
                                        <tbody>

                                           @foreach ($offers as $offer)
                                             <tr>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $offer->id }}
                                                  </span>
                                                </td>

                                                <td>
                                                    <span class="txt-dark">

                                                        @if ($offer->company)
                                                            {!! showStatusText($offer->status_id, "", "", $offer->name) !!}
                                                        @endif

                                                    </span>
                                                </td>

                                                 <td>
                                                  <span class="txt-dark">
                                                    {{ $offer->offer_frequency }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $offer->offer_type }}
                                                  </span>
                                                </td>

                                                <td>
                                                    <span class="txt-dark">
                                                        {{ $offer->company->name }}
                                                    </span>
                                                </td>

                                                <td>
                                                    @if ($offer->status)
                                                        {!! showStatusText($offer->status_id, "", "", $offer->status->name) !!}
                                                    @endif
                                                </td>

                                                <td>
                                                   <span class="txt-dark">
                                                    {{ formatFriendlyDate($offer->created_at) }}
                                                   </span>
                                                </td>

                                                <td>

                                                   <a href="{{ route('admin.offers.show', $offer->id) }}"
                                                            class="btn btn-info btn-sm btn-icon-anim btn-square"
                                                            title="View Offer">
                                                        <i class="zmdi zmdi-eye"></i>
                                                    </a>

                                                    <a href="{{ route('admin.offers.edit', $offer->id) }}"
                                                            class="btn btn-primary btn-sm btn-icon-anim btn-square"
                                                            title="Edit Offer">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </a>

                                                    <a href="{{ route('admin.offers.add-products.create', $offer->id) }}"
                                                            class="btn btn-success btn-sm btn-icon-anim btn-square"
                                                            title="Add Offer Products">
                                                        <i class="zmdi zmdi-plus"></i>
                                                    </a>

                                                   {{-- <a href="{{ route('admin.offers.destroy', $offer->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-delete"></i>
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

                                   {{ $offers->links() }}

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
