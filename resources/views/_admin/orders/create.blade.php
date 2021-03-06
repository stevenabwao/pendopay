@extends('_admin.layouts.master')

@section('title')

    Create Offer

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create Offer</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('products.create') !!}
          </div>
       </div>
      <!-- /Title -->


      <!-- Row -->
      <div class="row">

            <form method="POST" enctype="multipart/form-data"
               action="{{ route('offers.store') }}">

               {{ csrf_field() }}

               <div class="col-lg-6 col-xs-12">

                  <div class="panel panel-default card-view  pa-0 equalheight">
                  <div class="panel-wrapper collapse in">
                     <div class="panel-body  pa-0">
                        <div class="profile-box">

                        <div class="social-info">
                           <div class="row">

                              <div class="followers-wrap">
                              <ul class="followers-list-wrap">
                                 <li class="follow-list">
                                    <div class="follo-body">

                                       <div class="follo-data">

                                             <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                                <label for="name" class="col-md-4 control-label">
                                                   Offer Name
                                                   <span class="text-danger"> *</span>
                                                </label>
                                                <div class="col-md-8">
                                                   <input
                                                      type="text"
                                                      class="form-control"
                                                      id="name"
                                                      name="name"
                                                      value="{{ old('name') }}"
                                                      required
                                                      autofocus>

                                                   @if ($errors->has('name'))
                                                         <span class="help-block">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                         </span>
                                                   @endif
                                                </div>

                                             </div>

                                          <div class="clearfix"></div>
                                       </div>

                                       <div class="follo-data">

                                             <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                                <label for="description" class="col-md-4 control-label">
                                                   Offer Description
                                                </label>
                                                <div class="col-md-8">
                                                   <textarea name="description" id="description" rows="3"
                                                      class="form-control">{{ old('description') }}</textarea>

                                                   @if ($errors->has('description'))
                                                         <span class="help-block">
                                                            <strong>{{ $errors->first('description') }}</strong>
                                                         </span>
                                                   @endif
                                                </div>

                                             </div>

                                          <div class="clearfix"></div>
                                       </div>

                                       <div class="follo-data">

                                             <div  class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">

                                                <label for="company_id" class="col-md-4 control-label">
                                                   Establishment
                                                   <span class="text-danger"> *</span>
                                                </label>
                                                <div class="col-md-8">

                                                   <select class="selectpicker form-control"
                                                         name="company_id"
                                                         data-style="form-control btn-default btn-outline"
                                                         required>

                                                         @foreach ($companies as $company)
                                                         <li class="mb-10">
                                                         <option value="{{ $company->id }}"

                                                            @if ($company->id == old('company_id'))
                                                                  selected="selected"
                                                            @endif
                                                            >
                                                            {{ $company->name }}

                                                         </option>
                                                         </li>
                                                         @endforeach

                                                   </select>

                                                   @if ($errors->has('company_id'))
                                                         <span class="help-block">
                                                            <strong>{{ $errors->first('company_id') }}</strong>
                                                         </span>
                                                   @endif

                                                </div>

                                             </div>

                                          <div class="clearfix"></div>
                                       </div>

                                       <div class="follo-data">

                                             <div  class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">

                                                <label for="status_id" class="col-md-4 control-label">
                                                   Offer Status
                                                   <span class="text-danger"> *</span>
                                                </label>
                                                <div class="col-md-8">

                                                   <select class="selectpicker form-control"
                                                         name="status_id"
                                                         data-style="form-control btn-default btn-outline"
                                                         required>

                                                         @foreach ($statuses as $status)
                                                         <li class="mb-10">
                                                         <option value="{{ $status->id }}"

                                                            @if ($status->id == old('status_id'))
                                                                  selected="selected"
                                                            @endif
                                                            >
                                                            {{ $status->name }}

                                                         </option>
                                                         </li>
                                                         @endforeach

                                                   </select>

                                                   @if ($errors->has('status_id'))
                                                         <span class="help-block">
                                                            <strong>{{ $errors->first('status_id') }}</strong>
                                                         </span>
                                                   @endif

                                                </div>

                                             </div>

                                          <div class="clearfix"></div>
                                       </div>

                                       <div class="follo-data">

                                             <div  class="form-group{{ $errors->has('offer_type') ? ' has-error' : '' }}">
                                                <label for="offer_type" class="col-md-4 control-label">Offer Type</label>
                                                <div class="col-md-8">

                                                      <div class="radio no-margin">
                                                         <input type="radio" name="offer_type" value="regular"
                                                         {{ old('offer_type')=="regular" ? 'checked' : '' }}
                                                         v-model="offer_type"
                                                         value="regular"
                                                         >
                                                         <label for="regular">Regular Offer</label>
                                                      </div>
                                                      <div class="radio no-margin">
                                                         <input type="radio" name="offer_type" value="one-time"
                                                         {{ old('offer_type')=="one-time" ? 'checked' : '' }}
                                                         v-model="offer_type"
                                                         value="one-time"
                                                         >
                                                         <label for="event">One Time Offer</label>
                                                      </div>
                                                      @if ($errors->has('offer_type'))
                                                         <span class="help-block">
                                                            <strong>{{ $errors->first('offer_type') }}</strong>
                                                         </span>
                                                      @endif

                                                </div>
                                             </div>

                                          <div class="clearfix"></div>
                                       </div>

                                       <div class="follo-data">

                                          <div  class="form-group{{ ($errors->has('offer_frequency')) ? ' has-error' : '' }}"
                                                >
                                             <label for="offer_frequency" class="col-sm-4 control-label">Offer Frequency</label>

                                             <div class="col-sm-8">

                                                <div v-if="offer_type=='regular'">

                                                   <select class="form-control" name="offer_frequency" v-model="offer_frequency">

                                                      <li class="mb-10">
                                                         <option value="recurring-weekly"

                                                            @if (old('offer_frequency') == 'recurring-weekly')
                                                               selected="selected"
                                                            @endif

                                                         >Weekly</option>
                                                      </li>

                                                      <li class="mb-10">
                                                         <option value="recurring-monthly"

                                                            @if (old('offer_frequency') == 'recurring-monthly')
                                                               selected="selected"
                                                            @endif

                                                         >Monthly</option>
                                                      </li>

                                                      <li class="mb-10">
                                                         <option value="recurring-yearly"

                                                            @if (old('offer_frequency') == 'recurring-yearly')
                                                               selected="selected"
                                                            @endif

                                                         >Yearly</option>
                                                      </li>

                                                   </select>

                                                   <select class="form-control" name="offer_day" v-if="offer_frequency=='recurring-weekly'">

                                                      <li class="mb-10">
                                                         <option value="monday"

                                                            @if (old('offer_day') == 'monday')
                                                               selected="selected"
                                                            @endif

                                                         >Monday</option>
                                                      </li>

                                                      <li class="mb-10">
                                                         <option value="tuesday"

                                                            @if (old('offer_day') == 'tuesday')
                                                               selected="selected"
                                                            @endif

                                                         >Tuesday</option>
                                                      </li>

                                                      <li class="mb-10">
                                                         <option value="wednesday"

                                                            @if (old('offer_day') == 'wednesday')
                                                               selected="selected"
                                                            @endif

                                                         >Wednesday</option>
                                                      </li>

                                                      <li class="mb-10">
                                                         <option value="thursday"

                                                            @if (old('offer_day') == 'thursday')
                                                               selected="selected"
                                                            @endif

                                                         >Thursday</option>
                                                      </li>

                                                      <li class="mb-10">
                                                         <option value="friday"

                                                            @if (old('offer_day') == 'friday')
                                                               selected="selected"
                                                            @endif

                                                         >Friday</option>
                                                      </li>

                                                      <li class="mb-10">
                                                         <option value="saturday"

                                                            @if (old('offer_day') == 'saturday')
                                                               selected="selected"
                                                            @endif

                                                         >Saturday</option>
                                                      </li>

                                                      <li class="mb-10">
                                                         <option value="sunday"

                                                            @if (old('offer_day') == 'sunday')
                                                               selected="selected"
                                                            @endif

                                                         >Sunday</option>
                                                      </li>

                                                   </select>

                                                </div>

                                                <select class="form-control" name="offer_frequency" v-if="offer_type=='one-time'">

                                                   <li class="mb-10">
                                                      <option value="once"

                                                         @if (old('offer_frequency') == 'one-time')
                                                            selected="selected"
                                                         @endif

                                                      >Once</option>
                                                   </li>

                                                </select>


                                                @if ($errors->has('offer_frequency'))
                                                      <span class="help-block">
                                                         <strong>{{ $errors->first('offer_frequency') }}</strong>
                                                      </span>
                                                @endif
                                             </div>
                                          </div>

                                          <div class="clearfix"></div>
                                       </div>

                                       <div class="follo-data">

                                             <div  class="form-group{{ $errors->has('start_at') ? ' has-error' : '' }}">

                                                <label for="start_at" class="col-md-4 control-label">
                                                   Redeem Start Date
                                                   <span class="text-danger"> *</span>
                                                </label>
                                                <div class="col-md-8">

                                                   <div class='input-group date' id='start_date_group'>
                                                      <input
                                                            type='text'
                                                            class="form-control"
                                                            placeholder="Start Date"
                                                            id='start_date'
                                                            name="start_at"
                                                            value="{{ old('start_at') }}"
                                                      />
                                                      <span class="input-group-addon">
                                                         <span class="fa fa-calendar"></span>
                                                      </span>
                                                   </div>

                                                   @if ($errors->has('start_at'))
                                                         <span class="help-block">
                                                            <strong>{{ $errors->first('start_at') }}</strong>
                                                         </span>
                                                   @endif
                                                </div>

                                             </div>

                                          <div class="clearfix"></div>
                                       </div>

                                       <div class="follo-data">

                                             <div  class="form-group{{ $errors->has('end_at') ? ' has-error' : '' }}">

                                                <label for="end_at" class="col-md-4 control-label">
                                                      Redeem End Date
                                                   <span class="text-danger"> *</span>
                                                </label>
                                                <div class="col-md-8">

                                                   <div class='input-group date' id='end_date_group'>
                                                      <input
                                                            type='text'
                                                            class="form-control"
                                                            placeholder="End Date"
                                                            id='end_date'
                                                            name="end_at"
                                                            value="{{ old('end_at') }}"
                                                      />
                                                      <span class="input-group-addon">
                                                         <span class="fa fa-calendar"></span>
                                                      </span>
                                                   </div>

                                                   @if ($errors->has('end_at'))
                                                         <span class="help-block">
                                                            <strong>{{ $errors->first('end_at') }}</strong>
                                                         </span>
                                                   @endif
                                                </div>

                                             </div>

                                          <div class="clearfix"></div>
                                       </div>

                                       <div class="follo-data">

                                             <div  class="form-group{{ $errors->has('offer_expiry_method') ? ' has-error' : '' }}">
                                                <label for="offer_expiry_method" class="col-md-4 control-label">Offer Purchase Expiry</label>
                                                <div class="col-md-8">
                                                      <div class="radio no-margin">
                                                         <input type="radio" name="offer_expiry_method" value="by_date"
                                                         {{ old('offer_expiry_method')=="by_date" ? 'checked' : '' }}
                                                         v-model="offer_expiry_method"
                                                         value="by_date"
                                                         >
                                                         <label for="by_date">By Date</label>
                                                      </div>
                                                      <div class="radio no-margin">
                                                         <input type="radio" name="offer_expiry_method" value="by_sales"
                                                         {{ old('offer_expiry_method')=="by_sales" ? 'checked' : '' }}
                                                         v-model="offer_expiry_method"
                                                         value="by_sales"
                                                         >
                                                         <label for="by_sales">By Sales</label>
                                                      </div>
                                                      @if ($errors->has('offer_expiry_method'))
                                                         <span class="help-block">
                                                            <strong>{{ $errors->first('offer_expiry_method') }}</strong>
                                                         </span>
                                                      @endif

                                                </div>
                                             </div>

                                             <div  class="form-group{{ $errors->has('by_sales') ? ' has-error' : '' }}"
                                                   v-if="offer_expiry_method=='by_sales'">
                                                <label for="by_sales" class="col-md-4 control-label"></label>
                                                <div class="col-md-8 no-gutter">

                                                   <label for="max_sales" class="col-md-6 control-label">
                                                      Max No. of drinks
                                                   </label>
                                                   <div class="col-md-6">
                                                      <input
                                                         type="text"
                                                         class="form-control"
                                                         id="max_sales"
                                                         name="max_sales"
                                                         value="{{ old('max_sales') }}">

                                                      @if ($errors->has('max_sales'))
                                                            <span class="help-block">
                                                               <strong>{{ $errors->first('max_sales') }}</strong>
                                                            </span>
                                                      @endif
                                                   </div>

                                                </div>
                                             </div>

                                          <div class="clearfix"></div>
                                       </div>

                                       <div class="follo-data">

                                             <div  class="form-group{{ $errors->has('min_age') ? ' has-error' : '' }}">

                                                <label for="min_age" class="col-md-4 control-label">
                                                   Restrict By Min Age
                                                </label>
                                                <div class="col-md-8">

                                                   <select class="selectpicker form-control"
                                                         name="min_age"
                                                         data-style="form-control btn-default btn-outline"
                                                         >

                                                         <li class="mb-10">
                                                            <option value="">None</option>
                                                         </li>

                                                         @foreach ($age_ranges as $age_range)
                                                            <li class="mb-10">
                                                               <option value="{{ $age_range['id'] }}"

                                                                  @if ($age_range['id'] == old('min_age'))
                                                                        selected="selected"
                                                                  @endif
                                                                  >
                                                                  {{ $age_range['age'] }}

                                                               </option>
                                                            </li>
                                                         @endforeach

                                                   </select>

                                                   @if ($errors->has('min_age'))
                                                         <span class="help-block">
                                                            <strong>{{ $errors->first('min_age') }}</strong>
                                                         </span>
                                                   @endif

                                                </div>

                                             </div>

                                          <div class="clearfix"></div>
                                       </div>



                                    </div>
                                 </li>
                              </ul>
                              </div>

                           </div>

                        </div>
                        </div>
                     </div>
                  </div>
                  </div>
               </div>

               <div class="col-lg-6 col-xs-12">
                  <div class="panel panel-default card-view pa-0 equalheight">
                  <div class="panel-wrapper collapse in">
                     <div  class="panel-body pb-0 ml-20 mr-20">

                        <p class="mb-20">
                              <h5>Offer Poster (400 X 400 px)</h5>
                        </p>


                        <div class="panel-wrapper collapse in">
                           <div class="panel-body">
                              <div class="mt-0">
                                 <input type="file" id="input-file-now-custom-3" class="dropify" data-height="400"
                                    data-default-file="" name="item_image"/>
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>
                  </div>

               </div>

               <div class="clearfix"></div>

               <div class="col-xs-12">
                  <div class="panel panel-default card-view pa-0">
                  <div class="panel-wrapper collapse in">
                     <div  class="panel-body pb-0 ml-20 mr-20">

                        <button
                        type="submit"
                        class="btn btn-lg btn-info btn-block mt-10 mb-10"
                           id="submit-btn">
                           Submit
                        </button>

                     </div>
                  </div>
                  </div>
               </div>

            </form>

      </div>
      <!-- /Row -->

    </div>

@endsection


@section('page_scripts')

   <script type="text/javascript">

      var app = new Vue({
      el: "#app",

      data() {
            return {
            offer_expiry_method: 'by_date',
            offer_frequency: 'recurring-weekly',
            offer_type: 'regular'
            }
      }

      });
   </script>

  <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  <script src="{{ asset('myjs/dropify.min.js') }}"></script>
  <script src="{{ asset('myjs/form-file-upload-data.js') }}"></script>

  @include('_admin.layouts.partials.error_messages')

  <!-- search scripts -->
  @include('_admin.layouts.searchScripts')
  <!-- /search scripts -->



@endsection

