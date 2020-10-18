@extends('_admin.layouts.master')

@section('title')
    Manage Offer Products
@endsection

<?php
   $data = [
        'parent' => $offerproducts,
        'companies' => $companies,
        'show_create_link' => 1
   ]
?>

@section('post_page')
   {!! route('admin.offerproducts.index') !!}
@endsection

@section('create_page_link_title') Create New Offer Product @endsection

@section('create_page')
   {{ route('admin.offerproducts.create') }}
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
    {!! Breadcrumbs::render('admin.offerproducts') !!}
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
                Manage Offer Products
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


                     @if (!count($offerproducts))

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
                                                <th width="10%">Product Name</th>
                                                <th width="15%">Offer Name</th>
                                                <th width="10%" class="text-right">Normal Price</th>
                                                <th width="10%" class="text-right">Offer Price</th>
                                                <th width="10%" class="text-right">Discount</th>
                                                <th width="10%">Establishment</th>
                                              <th width="5%">Status</th>
                                              <th width="15%">Created At</th>
                                              <th width="10%">Actions</th>
                                           </tr>
                                        </thead>
                                        <tbody>

                                           @foreach ($offerproducts as $offerproduct)
                                             <tr>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $offerproduct->id }}
                                                  </span>
                                                </td>

                                                <td>
                                                    <span class="txt-dark">
                                                        @if ($offerproduct->companyproduct)
                                                            {!! showStatusText($offerproduct->status_id, "", "", $offerproduct->companyproduct->product->name) !!}
                                                        @endif
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="txt-dark">
                                                        @if ($offerproduct->offer)
                                                            {!! $offerproduct->offer->name !!}
                                                        @endif
                                                    </span>
                                                </td>

                                                 <td align="right">
                                                    <span class="txt-dark">
                                                        @if ($offerproduct->companyproduct)
                                                            {{ format_num($offerproduct->companyproduct->price)  }}
                                                        @endif
                                                    </span>
                                                </td>

                                                <td align="right">
                                                    <span class="txt-dark">
                                                        {{ format_num($offerproduct->offer_price)  }}
                                                    </span>
                                                </td>

                                                <td align="right">
                                                    <span class="txt-dark">
                                                        {{ $offerproduct->discount_percent }}%
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="txt-dark">
                                                        {{ $offerproduct->company->name }}
                                                    </span>
                                                </td>

                                                <td>
                                                    @if ($offerproduct->status)
                                                        {!! showStatusText($offerproduct->status_id, "", "", $offerproduct->status->name) !!}
                                                    @endif
                                                </td>

                                                <td>
                                                   <span class="txt-dark">
                                                    {{ formatFriendlyDate($offerproduct->created_at) }}
                                                   </span>
                                                </td>

                                                <td>

                                                   <a href="{{ route('admin.offerproducts.show', $offerproduct->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-eye"></i>
                                                   </a>

                                                   <a href="{{ route('admin.offerproducts.edit', $offerproduct->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-edit"></i>
                                                   </a>

                                                   {{-- <a href="{{ route('admin.offerproducts.destroy', $offerproduct->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
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

                                   {{ $offerproducts->links() }}

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
