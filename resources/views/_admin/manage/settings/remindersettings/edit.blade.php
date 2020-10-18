@extends('_admin.layouts.master')


@section('title')

    Edit Reminder Settings - {{ $remindersetting->id }}

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Edit Reminder Settings - {{ $remindersetting->id }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
              {!! Breadcrumbs::render('remindersettings.edit', $remindersetting->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

    </div>




    <div class="container-fluid">


        <!-- Row -->
         <div class="table-struct full-width full-height">
            <div class="table-cell auth-form-wrap-inner">
               <div class="ml-auto mr-auto no-float">

                  <div  class="col-sm-12">

                    <div class="row">
                       <div class="col-sm-12 col-xs-12">

                          <div class="panel panel-default card-view">

                             <div class="panel-wrapper collapse in">

                                <div class="panel-body">

                                   <div class="form-wrap">

                                        <br/>

                                        <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                                            action="{{ route('remindersettings.update', $remindersetting->id) }}" id="form" data-select2-id="form">

                                                {{ method_field('PUT') }}
                                                {{ csrf_field() }}

                                                <div class="form-group">

                                                    <label for="name" class="col-sm-3 control-label">
                                                    Reminder Section
                                                    </label>
                                                    <div class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="name"
                                                        name="name"
                                                        value="{{ $remindersetting->remindermessagetypesection->name }}">
                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label for="name" class="col-sm-3 control-label">
                                                    Reminder Type
                                                    </label>
                                                    <div class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        name="name"
                                                        value="{{ $remindersetting->remindermessagetype->name }}">

                                                    </div>

                                                    <input type="hidden" name="id"  value="{{ $remindersetting->id }}">
                                                    <input type="hidden" name="company_id"  value="{{ $remindersetting->company->id }}">
                                                    <input type="hidden" name="company_product_id"  value="{{ $remindersetting->remindermessagetype->id }}">

                                                </div>

                                                <div class="form-group">

                                                    <label for="name" class="col-sm-3 control-label">
                                                    Product
                                                    </label>
                                                    <div class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        value="{{ $remindersetting->product->name }}">
                                                    </div>

                                                </div>

                                                <div class="form-group">

                                                    <label for="name" class="col-sm-3 control-label">
                                                        Company
                                                    </label>
                                                    <div class="col-sm-6">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="name"
                                                        name="name"
                                                        value="{{ $remindersetting->company->name }}">
                                                    </div>

                                                </div>

                                                <hr>
                                                <h5 class="text-red text-bold">Activate/ Deactivate Reminder:</h5>
                                                <div  class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">
                                                    <label for="status_id" class="col-sm-3 control-label">Reminder Status</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio">
                                                            <input type="radio" name="status_id" id="status_id" value="1"
                                                            @if(old('status_id', $remindersetting->status_id)=="1") checked @endif>
                                                            <label for="1">Enable Reminder</label>
                                                        </div>
                                                        <div class="radio">
                                                            <input type="radio" name="status_id" id="status_id" value="99"
                                                            @if(old('status_id', $remindersetting->status_id)=="99") checked @endif>
                                                            <label for="99">Disable Reminder</label>
                                                        </div>
                                                        @if ($errors->has('status_id'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('status_id') }}</strong>
                                                            </span>
                                                        @endif

                                                    </div>
                                                </div>

                                                <hr>
                                                <h5 class="text-red text-bold">Reminder Message Timing:</h5>

                                                @if ($remindersetting->reminder_message_type_section_id == config('constants.reminder_type_sections.almost_expiring_loans'))

                                                    <div  class="form-group{{ $errors->has('reminder_message_send_to_expiry_cycle_id') ? ' has-error' : '' }}">

                                                            <label for="reminder_message_send_to_expiry_cycle_id" class="col-sm-3 control-label">Duration Before Loan Expiry Cycle</label>

                                                            <div class="col-sm-6">
                                                                <select class="form-control" name="reminder_message_send_to_expiry_cycle_id">
                                                                        @foreach ($terms as $term)
                                                                            <li class="mb-10">
                                                                            <option value="{{ $term->id }}"

                                                                        @if ($term->id == old('reminder_message_send_to_expiry_cycle_id', $remindersetting->reminder_message_send_to_expiry_cycle_id))
                                                                            selected="selected"
                                                                        @endif
                                                                                >
                                                                                    {{ $term->name }}
                                                                                </option>
                                                                            </li>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3">

                                                            </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="reminder_message_send_to_expiry_value" class="col-sm-3 control-label">Duration Before Loan Expiry Value</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="reminder_message_send_to_expiry_value" class="form-control digitsOnly"
                                                            value="{{ $remindersetting->reminder_message_send_to_expiry_value }}">
                                                        </div>
                                                        <div class="col-sm-3">

                                                        </div>
                                                    </div>

                                                @endif

                                                @if ($remindersetting->reminder_message_type_section_id == config('constants.reminder_type_sections.active_loans'))

                                                    <div  class="form-group{{ $errors->has('reminder_message_send_on_each_schedule') ? ' has-error' : '' }}">

                                                            <label for="reminder_message_send_on_each_schedule" class="col-sm-3 control-label">Send On Each Loan Schedule Date</label>

                                                            <div class="col-sm-6">
                                                                <select class="form-control" name="reminder_message_send_on_each_schedule">
                                                                        @foreach ($terms as $term)
                                                                            <li class="mb-10">
                                                                            <option value="{{ $term->id }}"

                                                                        @if ($term->id == old('reminder_message_send_on_each_schedule', $remindersetting->reminder_message_send_on_each_schedule))
                                                                            selected="selected"
                                                                        @endif
                                                                                >
                                                                                    {{ $term->name }}
                                                                                </option>
                                                                            </li>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3">

                                                            </div>
                                                    </div>

                                                @endif

                                                <hr>
                                                <h5 class="text-red text-bold">Messages Count:</h5>

                                                @if (($remindersetting->reminder_message_type_section_id == config('constants.reminder_type_sections.almost_expiring_loans')) ||
                                                    ($remindersetting->reminder_message_type_section_id == config('constants.reminder_type_sections.overdue_loans')))

                                                <div class="form-group">
                                                    <label for="max_reminder_messages" class="col-sm-3 control-label">Max No. of Messages</label>
                                                    <div class="col-sm-6">
                                                    <input type="text" name="max_reminder_messages" class="form-control digitsOnly" value="{{ $remindersetting->max_reminder_messages }}">
                                                    </div>
                                                    <div class="col-sm-3">

                                                    </div>
                                                </div>

                                                @endif

                                                @if ($remindersetting->reminder_message_type_section_id == config('constants.reminder_type_sections.active_loans'))

                                                <div  class="form-group{{ $errors->has('reminder_message_send_repeat_schedule') ? ' has-error' : '' }}">
                                                    <label for="reminder_message_send_repeat_schedule" class="col-sm-3 control-label">Reminder Message Repeat</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio">
                                                            <input type="radio" name="reminder_message_send_repeat_schedule" id="all" value="decline"
                                                            @if(old('reminder_message_send_repeat_schedule', $remindersetting->reminder_message_send_repeat_schedule)=="all") checked @endif>
                                                            <label for="all">Send Message On Each Schedule</label>
                                                        </div>
                                                        <div class="radio">
                                                            <input type="radio" name="reminder_message_send_repeat_schedule" id="first_last" value="queue"
                                                            @if(old('reminder_message_send_repeat_schedule', $remindersetting->reminder_message_send_repeat_schedule)=="first_last") checked @endif>
                                                            <label for="first_last">Send Message On First And Last Schedule</label>
                                                        </div>
                                                        @if ($errors->has('reminder_message_send_repeat_schedule'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('reminder_message_send_repeat_schedule') }}</strong>
                                                            </span>
                                                        @endif

                                                    </div>
                                                </div>

                                                @endif

                                                <hr>

                                                <h5 class="text-red text-bold">Message Type:</h5>

                                                <div class="form-group">
                                                    <label for="interest_type" class="col-sm-3 control-label">Send This Type Of Message</label>
                                                    <div class="col-sm-6">

                                                        <div class="checkbox checkbox-primary">
                                                            <input id="send_sms" type="checkbox"  name="send_sms" value="send_sms"
                                                            @if($remindersetting->send_sms=="1") checked @endif >
                                                            <label for="send_sms">
                                                                    Sms
                                                            </label>
                                                        </div>
                                                        <div class="checkbox checkbox-primary">
                                                            <input id="send_email" type="checkbox"  name="send_email" value="send_email"
                                                            @if($remindersetting->send_email=="1") checked @endif >
                                                            <label for="send_email">
                                                                    Email
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <hr>

                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary pull-right"><i class="zmdi zmdi-save"></i> &nbsp;&nbsp; Submit</button>
                                            </div><!-- /.box-footer -->

                                        </div>
                                    </form>


                                   </div>

                                </div>

                             </div>

                          </div>
                       </div>
                    </div>

                  </div>

               </div>
            </div>
         </div>
         <!-- /Row -->


      </div>



        @endsection





        @section('page_scripts')



        <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('js/jquery.bootstrap-touchspin.min.js') }}"></script>

        <script type="text/javascript">

            var app = new Vue({
              el: "#app",

              data() {
                  return {
                    borrow_criteria_mod: 'contributions'
                  }
              }

            });
        </script>

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

            $("input[name='tch3_22']").TouchSpin({
                initval: 1
            });

        </script>

  @include('_admin.layouts.partials.error_messages')

@endsection
