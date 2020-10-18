@extends('_admin.layouts.master')

@section('title')
    Manage Products
@endsection

<?php
   $data = [
        'parent' => $products,
        'categories' => $categories,
        'show_create_link' => 1
   ]
?>

@section('post_page'){!! route('admin.products.index') !!}@endsection

@section('create_page_link_title') Create New Product @endsection

@section('create_page')
   {{ route('admin.products.create') }}
@endsection

@section('excel_xls_url')
   {{ route('excel.products',
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
   {{ route('excel.products',
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
   {{ route('excel.products',
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
   {!! Breadcrumbs::render('admin.products') !!}
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
                Manage Products
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


                  @if (!count($products))

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
                                          <th class="text-right">Rec. Price</th>
                                          <th>Status</th>
                                          <th>Created</th>
                                          <th>Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($products as $product)
                                          <tr>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   {{ $product->id }}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                {{ $product->name }}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   @if($product->productcategory)
                                                      {{ $product->productcategory->name }}
                                                   @endif
                                                </span>
                                             </td>
                                             <td align="right">
                                                <span class="txt-dark weight-500">
                                                   @if($product->recommended_price)
                                                      {{ formatCurrency($product->recommended_price) }}
                                                   @endif
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   @if($product->status)

                                                      @if(($product->status->id) == config('constants.status.inactive'))
                                                         <span class="text-danger">
                                                      @else
                                                         <span class="text-success">
                                                      @endif

                                                            {{ $product->status->name }}

                                                         </span>

                                                   @endif
                                                </span>
                                             </td>

                                             <td>
                                                <span class="txt-dark weight-500">
                                                {{ formatFriendlyDate($product->created_at) }}
                                                </span>
                                             </td>
                                             <td>

                                                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                   <i class="zmdi zmdi-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                   <i class="zmdi zmdi-edit"></i>
                                                </a>

                                                   {{--<a href="{{ route('admin.products.destroy', $product->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
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
                                       {{ $products->links() }}
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
