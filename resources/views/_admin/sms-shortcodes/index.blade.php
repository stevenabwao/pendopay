@extends('_admin.layouts.master')

@section('title')

    Manage Sms Shortcodes

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
                Manage Sms Shortcodes
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('sms-shortcodes') !!}
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

                          <div class="pull-left col-sm-4">

                              <a
                                href="{{ route('sms-shortcodes.create') }}"
                                class="btn btn-primary btn-icon right-icon mr-5">
                                <span>New</span>
                                <i class="fa fa-plus"></i>
                              </a>

                              @if (count($smsshortcodes))
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
                                          <li><a href="#">As Excel</a></li>
                                          <li><a href="#">As CSV</a></li>
                                          <li><a href="#">As PDF</a></li>
                                       </ul>
                                    </div>
                                </div>
                              @endif

                          </div>

                          <div class="pull-right col-sm-8">

                            @if (count($smsshortcodes))

                            <form action="{{ route('sms-shortcodes.index') }}">
                               <table class="table table-search">
                                 <tr>

                                    <td>
                                      <input type="hidden" value="1" name="search">

                                      <div class='input-group date' id='start_at_group'>
                                          <input
                                              type='text'
                                              class="form-control"
                                              placeholder="Start Date"
                                              id='start_at'
                                              name="start_at"

                                              @if (app('request')->input('start_at'))
                                                  value="{{ app('request')->input('start_at') }}"
                                              @endif

                                          />
                                          <span class="input-group-addon">
                                             <span class="fa fa-calendar"></span>
                                          </span>
                                       </div>

                                    </td>

                                    <td>

                                      <div class='input-group date' id='end_at_group'>
                                          <input
                                              type='text'
                                              class="form-control"
                                              placeholder="End Date"
                                              id='end_at'
                                              name="end_at"

                                              @if (app('request')->input('end_at'))
                                                  value="{{ app('request')->input('end_at') }}"
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

                                      <select class="selectpicker form-control" name="user_id"
                                        data-style="form-control btn-default btn-outline">

                                          <li class="mb-10"><option value="">Select User</option></li>

                                          @foreach ($users as $user)
                                            <li class="mb-10">

                                              <option value="{{ $user->id }}"

                                                  @if ($user->id == app('request')->input('user_id'))
                                                      selected="selected"
                                                  @endif

                                                >

                                                {{ $user->first_name }}
                                                {{ $user->last_name }} -

                                              </option>

                                            </li>
                                          @endforeach

                                       </select>

                                    </td>
                                    <td>
                                      <button class="btn btn-primary">Filter</button>
                                    </td>
                                 </tr>
                               </table>
                            </form>

                            @endif

                          </div>
                          <div class="clearfix"></div>

                       </div>


                     @if (!count($smsshortcodes))

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
                                              <th width="10%">Shortcode No</th>
                                              <th width="15%">Name</th>
                                              <th width="20%">Company</th>
                                              <th width="20%">Created At</th>
                                              <th width="20%">Actions</th>
                                           </tr>
                                        </thead>
                                        <tbody>

                                           @foreach ($smsshortcodes as $smsshortcode)
                                             <tr>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $smsshortcode->id }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $smsshortcode->shortcode_number }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    {{ $smsshortcode->name }}
                                                  </span>
                                                </td>

                                                <td>
                                                  <span class="txt-dark">
                                                    @if ($smsshortcode->company)
                                                      {{ $smsshortcode->company->name }}
                                                    @endif
                                                  </span>
                                                </td>

                                                <td>
                                                   <span class="txt-dark">
                                                   {{ formatFriendlyDate($smsshortcode->created_at) }}
                                                   </span>
                                                </td>

                                                <td>

                                                   <a href="{{ route('sms-shortcodes.show', $smsshortcode->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                    <i class="zmdi zmdi-eye"></i>
                                                   </a>

                                                   @if (Auth::user()->can('update-paybill'))
                                                     <a href="{{ route('sms-shortcodes.edit', $smsshortcode->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                        <i class="zmdi zmdi-edit"></i>
                                                     </a>
                                                   @endif

                                                   @if (Auth::user()->can('delete-paybill'))
                                                     <a href="{{ route('sms-shortcodes.destroy', $smsshortcode->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
                                                        <i class="zmdi zmdi-delete"></i>
                                                     </a>
                                                   @endif

                                                </td>
                                             </tr>
                                           @endforeach

                                        </tbody>
                                     </table>
                                  </div>
                               </div>
                               <hr>
                               <div class="text-center">
                                   {{ $smsshortcodes->links() }}
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

  <script type="text/javascript">
      /* Start Datetimepicker Init*/
      $('#start_at_group').datetimepicker({
          useCurrent: false,
          format: 'DD-MM-YYYY',
          icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
        }).on('dp.show', function() {
        if($(this).data("DateTimePicker").date() === null)
          $(this).data("DateTimePicker").date(moment());
      });

      /* End Datetimepicker Init*/
      $('#end_at_group').datetimepicker({
          useCurrent: false,
          format: 'DD-MM-YYYY',
          icons: {
                        time: "fa fa-clock-o",
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
        }).on('dp.show', function() {
        if($(this).data("DateTimePicker").date() === null)
          $(this).data("DateTimePicker").date(moment());
      });

      //clear date
      $("#clear_date").click(function(e){
          e.preventDefault();
          $('#start_at').val("");
          $('#end_at').val("");
      });


</script>

@endsection

