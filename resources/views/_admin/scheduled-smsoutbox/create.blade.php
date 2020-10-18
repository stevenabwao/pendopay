@extends('_admin.layouts.master')


@section('title')

    Send SMS

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

<style type="text/css">
  .user_options{ max-height: 350px; overflow: scroll;max-width: 100%;
    overflow-x: hidden;}
</style>

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Row -->
       <div class="table-struct full-width full-height">

          <div class="table-cell">
             <div class=" ml-auto mr-auto no-float">


                  <form class="form-horizontal" method="POST" action="{{ route('smsoutbox.store') }}">

                  <!-- <form class="form-horizontal" @submit.prevent="handleSubmit()">  -->

                     {{ csrf_field() }}

                      <div class="row">

                            <div  class="col-sm-12">

                                <div class="panel panel-default border-panel card-view">

                                    <div  class="col-sm-12 col-md-6">

                                        <div class="panel panel-default border-panel card-view">

                                           <div class="panel-heading">

                                             <div class="text-left">
                                                <h5 class="panel-title txt-dark">
                                                  <strong class="pull-left">Send SMS</strong>
                                                  <span class="pull-right">
                                                      SMS Bal:
                                                      <span class="text-success">3,000</span>
                                                  </span>
                                                </h5>
                                             </div>
                                             <div class="clearfix"></div>
                                           </div>

                                           <div class="panel-wrapper collapse in">

                                              <div class="panel-body">

                                                 <div class="form-wrap">

                                                    @if (session('message'))
                                                      <div class="alert alert-success text-center">
                                                          {{ session('message') }}
                                                      </div>
                                                    @endif


                                                       <div  class="form-group{{ $errors->has('sms_message') ? ' has-error' : '' }}">

                                                          <label for="sms_message" class="col-sm-12 control-label text-left">
                                                             Message
                                                             <span class="text-danger"> *</span>
                                                          </label>
                                                          <div class="col-sm-12">
                                                                <textarea
                                                                    class="form-control"
                                                                    id="sms_message"
                                                                    name="sms_message"
                                                                    v-model="message"
                                                                    rows="7"
                                                                    @keyup="onTextKeyPress"
                                                                    required autofocus>
                                                                </textarea>

                                                             @if ($errors->has('sms_message'))
                                                                  <span class="help-block">
                                                                      <strong>{{ $errors->first('sms_message') }}</strong>
                                                                  </span>
                                                             @endif
                                                          </div>

                                                       </div>

                                                       <div  class="form-group">

                                                           <div class="col-sm-12">
                                                                <span class="pull-left"><strong id="remaining">160</strong> characters remaining</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <span class="pull-right"><strong id="messages">1</strong> message(s)</span>
                                                                <div class="clearfix"></div>
                                                            </div>

                                                        </div>

                                                       <hr>

                                                       <div class="form-group">

                                                          <div class="col-sm-12">
                                                             <div class="col-sm-6">
                                                                <div class="radio">
                                                                   <input
                                                                      type="radio"
                                                                      name="sendSmsCheckBox"
                                                                      id="sendSmsCheckBox"
                                                                      value="now"
                                                                      v-model="sendSmsCheck"
                                                                      @change="sendSmsCheckToggle"
                                                                      >
                                                                   <label for="m">Send SMS NOW</label>
                                                                </div>
                                                             </div>
                                                             <div class="col-sm-6">
                                                                <div class="radio">
                                                                   <input
                                                                      type="radio"
                                                                      name="sendSmsCheckBox"
                                                                      id="sendSmsCheckBox"
                                                                      value="schedule"
                                                                      v-model="sendSmsCheck"
                                                                      @change="sendSmsCheckToggle"
                                                                      >
                                                                   <label for="f">Schedule SMS</label>
                                                                </div>
                                                             </div>
                                                          </div>



                                                       </div>

                                                       <transition name="fade" mode="out-in">

                                                         <div class="form-group" v-show="showDateBox">
                                                            <div class="col-sm-12">
                                                               <label class="control-label mb-10 text-left">
                                                                  Please select date and time
                                                               </label>
                                                               <div class='input-group date' id='smsdate'>
                                                                  <input
                                                                      type='text'
                                                                      class="form-control"
                                                                      :value="smsScheduleDateTime"
                                                                      v-model="smsScheduleDateTime"
                                                                       />
                                                                  <span class="input-group-addon">
                                                                     <span class="fa fa-calendar"></span>
                                                                  </span>
                                                               </div>
                                                            </div>
                                                         </div>

                                                       </transition>

                                                       <hr>


                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                              <button
                                                                type="submit"
                                                                class="btn btn-primary btn-lg btn-block mr-10"
                                                                 id="submit-btn"
                                                                 :disabled="textLength < 1 ? true : false">
                                                                 <span v-if="addLoading">
                                                                    <i class='fa fa-spinner fa-spin'></i>
                                                                 </span> &nbsp;
                                                                 Send SMS
                                                              </button>
                                                            </div>
                                                       </div>



                                                 </div>

                                              </div>

                                           </div>

                                        </div>

                                    </div>

                                    <div  class="col-sm-12 col-md-6">


                                        <input type="hidden" name="usersSelected" :value="usersSelected">

                                         <div class="panel panel-default border-panel card-view">

                                            <div class="panel-heading">

                                                <div class="text-left">
                                                    <h5 class="panel-title txt-dark">
                                                      <strong class="pull-left">
                                                        Select Users To Send SMS To
                                                      </strong>
                                                      <span class="pull-right">
                                                          Selected:
                                                          <span
                                                              class="text-info"
                                                              v-text="usersSelectedCount">
                                                          </span>
                                                      </span>
                                                    </h5>
                                                </div>
                                                <div class="clearfix"></div>

                                            </div>

                                            <div  class="form-group mt-10">

                                              <div class="col-sm-12">

                                                 <select
                                                    class="selectpicker form-control"
                                                    name="group_id"
                                                    data-style="form-control btn-default btn-outline"
                                                    @change="getSelectedGroup()"
                                                    v-model="selectedGroup">

                                                    <li class="mb-10">
                                                        <option value="">
                                                          Filter By Group
                                                        </option>
                                                    </li>

                                                    @foreach ($groups as $group)
                                                    <li class="mb-10">
                                                        <option value="{{ $group->id }}">
                                                          {{ $group->name }}
                                                        </option>
                                                    </li>
                                                    @endforeach

                                                 </select>

                                              </div>

                                           </div>

                                            <!-- <hr> -->

                                            <div  class="panel-wrapper collapse in">
                                               <div  class="panel-body pt-0">


                                                  <!-- Row -->
                                                  <div class="row">
                                                    <div class="col-lg-12 col-sm-12">
                                                        <div  class="tab-struct custom-tab-1 mt-0">


                                                            <div class="user_options slimScrollDiv">

                                                              <p>
                                                                  <ul>
                                                                      @foreach ($users as $user)
                                                                      <li>
                                                                         <div class="checkbox">
                                                                            <input
                                                                                id="{{ $user->id }}"
                                                                                type="checkbox"
                                                                                @change="userSelectedToggle"
                                                                                :value="{{ $user->id }}"
                                                                                v-model="usersSelected">
                                                                            <label for="{{ $user->id }}">
                                                                                <strong>
                                                                                    {{ $user->phone_number }}
                                                                                </strong>
                                                                                &nbsp; - &nbsp;
                                                                                <em>
                                                                                ({{ $user->first_name }}
                                                                                &nbsp;
                                                                                {{ $user->last_name }})
                                                                                </em>
                                                                                &nbsp;&nbsp;

                                                                            </label>
                                                                         </div>
                                                                      </li>
                                                                      @endforeach
                                                                  </ul>
                                                              </p>


                                                            </div>

                                                            <hr>
                                                              <div class="row">
                                                                <div class="col-sm-12">
                                                                  <a
                                                                      @click="selectAll()"
                                                                      class="btn btn-outline btn-primary pull-left">
                                                                      Select All
                                                                  </a>

                                                                  <a
                                                                      @click="deselectAll()"
                                                                      class="btn btn-outline btn-danger pull-right">
                                                                      Deselect All
                                                                  </a>
                                                                </div>
                                                              </div>


                                                        </div>

                                                    </div>

                                                  </div>
                                                  <!-- /Row -->




                                               </div>
                                            </div>

                                         </div>

                                    </div>

                                    <div class="clearfix"></div>

                                </div>

                            </div>

                      </div>

                  </form>


             </div>
          </div>

       </div>
       <!-- /Row -->

    </div>

@endsection


@section('page_scripts')

  <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  <script>
    $( document ).ready(function() {

        //HANDLE SMS MESSAGES
        var $remaining = $('#remaining'),
        $messages = $('#messages');

        //bulk sms
        $('#sms_message').keyup(function(){
          var chars = this.value.length,
            messages = Math.ceil(chars / 160),
            remaining = messages * 160 - (chars % (messages * 160) || messages * 160);
          $remaining.text(remaining);
          $messages.text(messages);
        });
        //END HANDLE SMS MESSAGES

        /* Datetimepicker Init*/
        $('#smsdate').datetimepicker({
            useCurrent: false,
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

    });

  </script>

  <script type="text/javascript">

      var app = new Vue({
        el: "#app",

        data() {
            return {
                usersSelected: {!! $users->pluck('id') !!},
                usersSelectedCount: {!! $users->pluck('id')->count() !!},
                message: '',
                sendSmsCheck: 'now',
                smsScheduleDateTime: '',
                textLength:'',
                enteredContactsNumbers: '',
                selectedGroup: '',
                showDateBox: false,
                addLoading: false,
                userListLoading: false
            }
        },

        methods : {

            /*handle  form submit*/
            handleSubmit(){

                this.addLoading = true;

                if (this.message !== null) {

                  let postData = {
                    'message': this.message,
                    'usersSelected': this.usersSelected,
                    'sendSmsCheck': this.sendSmsCheck,
                    'smsScheduleDateTime': this.smsScheduleDateTime
                  }

                  console.log(postData)

                  //post form data
                  sendMessageUrl = "{{ $send_message_url }}"
                  axios.post(sendMessageUrl, postData)
                  .then(response => {

                      this.addLoading = false;

                      console.log(postData)
                      console.log(response)

                  })
                  .catch(error => {
                      console.log(error)
                  })

                }

            },

            getSelectedGroup(){

                this.userListLoading = true;
                selectedGroup = this.selectedGroup
                get_users_url = "{{ $get_users_url }}"
                passport_client_id = "{{ $passport_client_id }}"
                passport_client_secret = "{{ $passport_client_secret }}"
                passport_login_url = "{{ $passport_login_url }}"
                passport_user_url = "{{ $passport_user_url }}"


                //if (this.message !== null) {

                  let postData = {
                    'group_id': this.selectedGroup
                  }

                  //post form data
                  axios.get(get_users_url, postData)
                  .then(response => {

                      this.userListLoading = false;

                      console.log(postData)
                      console.log(response)

                  })
                  .catch(error => {
                      console.log(error)
                  })

                //}

            },

            onTextKeyPress() {
                this.textLength = this.message.length
            },

            onEnteredPhoneNumbersPress() {
                //get users count
            },

            userSelectedToggle() {
                //update selected items count on checkbox change
                this.usersSelectedCount = this.usersSelected.length
            },

            sendSmsCheckToggle() {

              sendSmsCheck = this.sendSmsCheck
              if (sendSmsCheck == 'schedule'){
                  //show date box
                  this.showDateBox = true
                  //console.log('show date box')
              } else {
                  //show date box
                  this.showDateBox = false
                  //console.log('hide date box')
              }

            },

            selectAll: function() {

                allUsers = {!! $users->pluck('id') !!}
                //unselect all
                this.usersSelected = []
                this.usersSelected = allUsers
                //update selected items count on checkbox change
                this.usersSelectedCount = this.usersSelected.length

            },

            deselectAll: function() {

                //unselect all
                this.usersSelected = []
                //update selected items count on checkbox change
                this.usersSelectedCount = this.usersSelected.length

            }

        }

      });
  </script>

@endsection
