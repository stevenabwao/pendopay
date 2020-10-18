@extends('_admin.layouts.master')

@section('title')
    Manage Establishment Products
@endsection

<?php
   $data = [
        'parent' => $companyproducts,
        'categories' => $categories,
        'companies' => $companies,
        'show_create_link' => 1,
   ]
?>

@section('post_page'){!! route('admin.companyproducts.index') !!}@endsection

@section('create_page_link_title') Create New Establishment Product @endsection

@section('create_page')
   {{ route('admin.companyproducts.create') }}
@endsection

@section('excel_xls_url')
   {{ route('excel.companyproducts',
      ['xls',
      'start_date' => app('request')->input('start_date'),
      'end_date' => app('request')->input('end_date'),
      'account_search' => app('request')->input('account_search'),
      'status_id' => app('request')->input('status_id'),
      'limit' => app('request')->input('limit'),
      ])
   }}
@endsection

@section('excel_csv_url')
   {{ route('excel.companyproducts',
      ['csv',
      'start_date' => app('request')->input('start_date'),
      'end_date' => app('request')->input('end_date'),
      'account_search' => app('request')->input('account_search'),
      'status_id' => app('request')->input('status_id'),
      'limit' => app('request')->input('limit'),
      ])
   }}
@endsection

@section('excel_pdf_url')
   {{ route('excel.companyproducts',
      ['pdf',
      'start_date' => app('request')->input('start_date'),
      'end_date' => app('request')->input('end_date'),
      'account_search' => app('request')->input('account_search'),
      'status_id' => app('request')->input('status_id'),
      'limit' => app('request')->input('limit'),
      ])
   }}
@endsection

@section('page_breadcrumbs')
   {!! Breadcrumbs::render('admin.companyproducts') !!}
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
               Manage Establishment Products
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

                     <!-- searchbar, pass data -->
                     @include('_admin.layouts.partials.searchbar', $data)
                     <!-- /searchbar -->

                  </div>

                  @if (!count($companyproducts))

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
                                          <th>ID</th>
                                          <th>Name</th>
                                          <th>Category</th>
                                          <th>Establishment</th>
                                          <th class="text-right">Price</th>
                                          <th>Status</th>
                                          <th>Created</th>
                                          <th>Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($companyproducts as $companyproduct)

                                       {{-- {{ dd($companyproduct->product->productcategory) }} --}}

                                          <tr>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   {{ $companyproduct->id }}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   @if($companyproduct->product)
                                                      {{ $companyproduct->product->name }}
                                                   @endif
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   @if($companyproduct->product->productcategory)
                                                      {{ $companyproduct->product->productcategory->name }}
                                                   @endif
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   @if($companyproduct->establishment)
                                                      {{ $companyproduct->establishment->name }}
                                                   @endif
                                                </span>
                                             </td>
                                             <td align="right">
                                                <span class="txt-dark weight-500">
                                                   @if($companyproduct->price)
                                                      {{ formatCurrency($companyproduct->price) }}
                                                   @endif
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   @if($companyproduct->status)
                                                        {!! showStatusText($companyproduct->status_id, "", "", $companyproduct->status->name) !!}
                                                   @endif
                                                </span>
                                             </td>

                                             <td>
                                                <span class="txt-dark weight-500">
                                                {{ formatFriendlyDate($companyproduct->created_at) }}
                                                </span>
                                             </td>
                                             <td>

                                                <a href="{{ route('admin.companyproducts.show', $companyproduct->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                   <i class="zmdi zmdi-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.companyproducts.edit', $companyproduct->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                   <i class="zmdi zmdi-edit"></i>
                                                </a>

                                                   {{--<a href="{{ route('admin.companyproducts.destroy', $companyproduct->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
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
                                       {{ $companyproducts->links() }}
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
