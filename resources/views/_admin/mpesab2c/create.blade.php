@extends('_admin.layouts.master')

@section('title')

    Create New Mpesa B2C Transaction

@endsection

@section('css_header')

    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create New Mpesa B2C Transaction</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('mpesab2c.create') !!}
          </div>
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                <div  class="col-sm-12 col-md-8 col-md-offset-2">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">

                        <div class="panel panel-default card-view">

                           <div class="panel-wrapper collapse in">

                              <div class="panel-body">

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Create New Mpesa B2C Transaction</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('mpesab2c.store') }}">

                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('shortcode') ? ' has-error' : '' }}">

                                          <label for="shortcode" class="col-sm-3 control-label">
                                             Company Shortcode
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">

                                             <select class="selectpicker form-control"
                                                name="shortcode"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($mpesashortcodes as $shortcode)
                                                <li class="mb-10">
                                                <option value="{{ $shortcode->id }}"
                                          @if ($shortcode->id == old('shortcode', $shortcode->id))
                                              selected="selected"
                                          @endif
                                                    >
                                                    {{ $shortcode->shortcode_number }} -
                                                    {{ $shortcode->company->name }}
                                                    </option>
                                                </li>
                                                @endforeach

                                             </select>

                                             @if ($errors->has('shortcode'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('shortcode') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div>

                                       <div class="form-group">

                                            <div class="row">
                                                <label for="phone" class="col-sm-3 control-label">
                                                Phone
                                                <span class="text-danger"> *</span>
                                                </label>
                                                <div class="col-sm-9">

                                                    <div class="col-sm-6 no-padding-right">
                                                        <select id="phone_country" name="phone_country" class="form-control selectpicker" required>

                                                            @foreach ($countries as $country)
                                                            <li class="mb-10">
                                                                <option value="{{ $country->sortname }}"
                                                            @if ($country->sortname == old('phone_country', 'KE'))
                                                                selected="selected"
                                                            @endif
                                                                >
                                                                {{ $country->name }} (+{{ $country->phonecode }})
                                                                </option>
                                                            </li>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    <div class="col-sm-6">

                                                        <input type="text" class="form-control" name="phone"
                                                            data-parsley-trigger="change" placeholder="e.g. 720000000"
                                                            value="{{ old('phone') }}" required>

                                                        @if ($errors->has('phone'))
                                                            <div class="help-block text-danger">
                                                                <strong>{{ $errors->first('phone') }}</strong>
                                                            </div>
                                                        @endif

                                                    </div>




                                                </div>
                                            </div>

                                        </div>

                                       <div  class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">

                                          <label for="amount" class="col-sm-3 control-label">
                                             Amount
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="amount"
                                                name="amount"
                                                value="{{ old('amount') }}">

                                             @if ($errors->has('amount'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('amount') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <br/>

                                       <div class="form-group">
                                          <div class="col-sm-3"></div>
                                          <div class="col-sm-9">
                                              <button
                                                type="submit"
                                                class="btn btn-lg btn-primary btn-block mr-10"
                                                 id="submit-btn">
                                                 Submit
                                              </button>
                                          </div>
                                       </div>

                                       <br/>


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

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

@endsection
