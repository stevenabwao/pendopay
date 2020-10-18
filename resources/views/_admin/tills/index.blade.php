@extends('_admin.layouts.master')

@section('title')
    Manage Tills
@endsection

<?php
   $data = [
        'parent' => $tills,
        'companies' => $companies,
        'show_create_link' => 1
   ]
?>

@section('post_page'){!! route('admin.tills.index') !!}@endsection

@section('create_page_link_title') Create New Till @endsection

@section('create_page')
   {{ route('admin.tills.create') }}
@endsection

@section('excel_xls_url')
   {{ route('excel.admin.tills',
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
   {{ route('excel.admin.tills',
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
   {{ route('excel.admin.tills',
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
   {!! Breadcrumbs::render('admin.tills') !!}
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
               Manage Tills
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


                  @if (!count($tills))

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
                                          <th width="5%">Till No</th>
                                          <th width="10%">Phone</th>
                                          <th width="10%">Till Name</th>
                                          <th width="10%">Establishment</th>
                                          <th width="10%">Till Status</th>
                                          <th width="15%">Confirmed At</th>
                                          <th width="10%">Active</th>
                                          <th width="15%">Created</th>
                                          <th width="10%">Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>

                                       @foreach ($tills as $till)

                                          <tr>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   {{ $till->id }}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   {{ $till->till_number }}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                    {{ $till->phone_number }}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                    {{ $till->till_name }}
                                                </span>
                                             </td>
                                             <td>
                                                <span class="txt-dark weight-500">
                                                   @if($till->company)
                                                      {{ $till->company->name }}
                                                   @endif
                                                </span>
                                             </td>

                                             <td>
                                                <span class="txt-dark weight-500">

                                                    @if($till->status)
                                                        {!! showStatusText($till->status->id)  !!}
                                                    @endif

                                                </span>
                                             </td>

                                             <td>
                                                <span class="txt-dark weight-500">
                                                {{ formatFriendlyDate($till->confirmed_at) }}
                                                </span>
                                             </td>

                                             <td>
                                                <span class="txt-dark weight-500">

                                                    @if($till->active)
                                                        {!! showActiveStatusText($till->active)  !!}
                                                    @endif

                                                </span>
                                             </td>

                                             <td>
                                                <span class="txt-dark weight-500">
                                                {{ formatFriendlyDate($till->created_at) }}
                                                </span>
                                             </td>
                                             <td>

                                                <a href="{{ route('admin.tills.show', $till->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                   <i class="zmdi zmdi-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.tills.edit', $till->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                   <i class="zmdi zmdi-edit"></i>
                                                </a>

                                                   {{--<a href="{{ route('admin.tills.destroy', $till->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
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
                                       {{ $tills->links() }}
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
