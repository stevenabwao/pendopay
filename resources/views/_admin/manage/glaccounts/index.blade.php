@extends('_admin.layouts.master')

@section('title')
    Manage Gl Accounts
@endsection

<?php
   $data = [
        'parent' => $glaccounts,
        'glaccounts' => $glaccounts,
        'show_create_link' => 1
   ]
?>

@section('post_page'){!! route('admin.manage.glaccounts.index') !!}@endsection

@section('create_page_link_title') Create New GL Account @endsection

@section('create_page')
   {{ route('admin.manage.glaccounts.create') }}
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
   {!! Breadcrumbs::render('admin.manage.glaccounts') !!}
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
                Manage GL Accounts
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


                  @if (!count($glaccounts))

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
                                          <th width="25%">Description</th>
                                          <th width="15%">GL Account No</th>
                                          <th width="15%">Account Type</th>
                                          <th width="15%">Company</th>
                                          <th width="15%">Created At</th>
                                          <th width="10%">Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($glaccounts as $glaccount)
                                         <tr>

                                            <td>
                                              <span class="txt-dark">
                                                {{ $glaccount->id }}
                                              </span>
                                            </td>

                                            <td>
                                                {{ $glaccount->description }}
                                            </td>

                                            <td>
                                              <span class="txt-dark">
                                                {{ $glaccount->gl_account_no }}
                                              </span>
                                            </td>

                                            <td>
                                                <span class="txt-dark">
                                                    @if ($glaccount->glaccounttype)
                                                    {{ $glaccount->glaccounttype->description }}
                                                    @endif
                                                </span>
                                              </td>

                                            <td>
                                              <span class="txt-dark">
                                                @if ($glaccount->company)
                                                  {{ $glaccount->company->name }}
                                                @endif
                                              </span>
                                            </td>

                                            <td>
                                               <span class="txt-dark">
                                                {{ formatFriendlyDate($glaccount->created_at) }}
                                               </span>
                                            </td>

                                            <td>

                                               <a href="{{ route('admin.manage.glaccounts.show', $glaccount->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                <i class="zmdi zmdi-eye"></i>
                                               </a>

                                               <a href="{{ route('admin.manage.glaccounts.edit', $glaccount->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
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
                           <div class="text-center">
                                       {{ $glaccounts->links() }}
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
