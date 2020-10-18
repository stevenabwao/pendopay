@extends('_admin.layouts.master')

@section('title')
    Manage Establishments
@endsection

<?php
   $data = [
        'parent' => $companies,
        'companies' => $companies,
        'show_create_link' => 1
   ]
?>

@section('post_page'){!! route('admin.establishments.index') !!}@endsection

@section('create_page_link_title') Create New Establishment @endsection

@section('create_page')
   {{ route('admin.establishments.create') }}
@endsection

@section('excel_xls_url')
   {{ route('excel.establishments',
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
   {{ route('excel.establishments',
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
   {{ route('excel.establishments',
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
   {!! Breadcrumbs::render('admin.establishments') !!}
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
                Manage Establishments
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


                  @if (!count($companies))

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
                                          <th>Est. Name</th>
                                          <th>County</th>
                                          <th>Category</th>
                                          <th>Phone</th>
                                          <th>Email</th>
                                          <th>Created</th>
                                          <th>Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($companies as $company)
                                          <tr>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   {{ $company->id }}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                    {!! showStatusText($company->status_id, "", "", $company->display_name) !!}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   @if($company->county)
                                                      {{ $company->county->name }}
                                                   @endif
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   @if($company->category)
                                                      {{ $company->category->name }}
                                                   @endif
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                {{ $company->phone }}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                {{ $company->email }}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                {{ formatFriendlyDate($company->created_at) }}
                                                </span>
                                             </td>
                                             <td>

                                                <a href="{{ route('admin.establishments.show', $company->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                   <i class="zmdi zmdi-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.establishments.edit', $company->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                   <i class="zmdi zmdi-edit"></i>
                                                </a>

                                                   {{--<a href="{{ route('admin.establishments.destroy', $company->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
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
                                       {{ $companies->links() }}
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
