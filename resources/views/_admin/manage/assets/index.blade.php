@extends('_admin.layouts.master')

@section('title')

    Manage Assets

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
                Manage Assets
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('assets') !!}
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

                              @if (count($assets))
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
                                            <a href="{{ route('excel.assets',
                                                        ['xls',
                                                          'start_date' => app('request')->input('start_date'),
                                                          'end_date' => app('request')->input('end_date'),
                                                          'companies' => app('request')->input('companies'),
                                                          'limit' => app('request')->input('limit'),
                                                        ])
                                                     }}"
                                            >As Excel</a>
                                          </li>
                                          <li>
                                            <a href="{{ route('excel.assets',
                                                        ['csv',
                                                          'start_date' => app('request')->input('start_date'),
                                                          'end_date' => app('request')->input('end_date'),
                                                          'companies' => app('request')->input('companies'),
                                                          'limit' => app('request')->input('limit'),
                                                        ])
                                                     }}"
                                            >As CSV</a>
                                          </li>
                                          <li>
                                            <a href="{{ route('excel.assets',
                                                        ['pdf',
                                                          'start_date' => app('request')->input('start_date'),
                                                          'end_date' => app('request')->input('end_date'),
                                                          'companies' => app('request')->input('companies'),
                                                          'limit' => app('request')->input('limit'),
                                                        ])
                                                     }}"
                                            >As PDF</a>
                                          </li>
                                       </ul>
                                    </div>
                                </div>
                              @endif

                          </div>

                          <div class="pull-right col-sm-9">

                            <form action="{{ route('assets.index') }}">
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


                                    @if (Auth::user()->hasRole('superadministrator'))
                                    <td>

                                        <select class="selectpicker form-control" name="companies"
                                          data-style="form-control btn-default btn-outline">

                                            <li class="mb-10">
                                                <option value=""
                                                  @if (!(app('request')->input('companies')) ||
                                                        checkCharExists(',', (app('request')->input('companies')))
                                                      )
                                                      selected="selected"
                                                  @endif
                                                >Select company
                                                </option>
                                            </li>

                                            @foreach ($companies as $company)

                                              <li class="mb-10">

                                                <option value="{{ $company->id }}"

                                                    @if (($company->id == app('request')->input('companies')) &&
                                                        !(checkCharExists(',', (app('request')->input('companies'))))
                                                        )
                                                        selected="selected"
                                                    @endif

                                                  >

                                                  {{ $company->name }}

                                                </option>

                                              </li>

                                            @endforeach

                                         </select>

                                      </td>

                                    @endif


                                    <td>
                                      <button class="btn btn-primary">Filter</button>
                                    </td>
                                 </tr>
                               </table>
                            </form>

                          </div>
                          <div class="clearfix"></div>

                       </div>


                     @if (!count($assets))

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
                                              <th width="15%">Name</th>
                                              <th width="15%">Company</th>
                                              <th width="15%">Event</th>
                                              <th width="10%">Asset Type</th>
                                              <th width="10%">Asset Link</th>
                                              <th width="5%">Status</th>
                                              <th width="10%">Created At</th>
                                              <th width="15%">Actions</th>
                                           </tr>
                                        </thead>
                                        <tbody>

                                           @foreach ($assets as $asset)
                                             <tr>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $asset->id }}
                                                  </span>
                                                </td>

                                                <td>
                                                    @if ($asset->status->id != 1)
                                                      <span class="txt-dark text-danger">
                                                          {{ $asset->name }}
                                                      </span>
                                                    @else
                                                      <span class="txt-dark">
                                                          {{ $asset->name }}
                                                      </span>
                                                    @endif
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    @if ($asset->company)
                                                      @if ($asset->company->name)
                                                        {{ $asset->company->name }}
                                                      @endif
                                                    @endif
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    @if ($asset->ussdeventmap)
                                                      @if ($asset->ussdeventmap->ussdevent)
                                                        {{ $asset->ussdeventmap->ussdevent->name }}
                                                      @endif
                                                    @endif
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    @if ($asset->assettype)
                                                      @if ($asset->assettype->name)
                                                        {{ $asset->assettype->name }}
                                                      @endif
                                                    @endif
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    <a
                                                      target="_blank"
                                                      href="{{ config('constants.site.url') }}{{ $asset->asset_url }}"
                                                      title="View {{ $asset->name }}">
                                                      View
                                                    </a>

                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    @if ($asset->status)

                                                        @if ($asset->status->id != 1)
                                                          <span class="txt-dark text-danger">
                                                              {{ $asset->status->name }}
                                                          </span>
                                                        @else
                                                          <span class="txt-dark text-success">
                                                              {{ $asset->status->name }}
                                                          </span>
                                                        @endif

                                                    @endif
                                                  </span>
                                                </td>

                                                <td>
                                                   <span class="txt-dark">
                                                    {{ formatFriendlyDate($asset->created_at) }}
                                                   </span>
                                                </td>

                                                <td>

                                                   <a href="{{ route('assets.show', $asset->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-eye"></i>
                                                   </a>

                                                   <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-edit"></i>
                                                   </a>

                                                   <a href="{{ route('assets.destroy', $asset->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-delete"></i>
                                                   </a>

                                                </td>
                                             </tr>
                                           @endforeach

                                        </tbody>
                                     </table>
                                  </div>
                               </div>
                               <hr>
                               <div class="text-center mb-20">

                                   {{ $assets->links() }}

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

