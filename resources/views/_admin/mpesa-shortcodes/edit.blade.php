@extends('_admin.layouts.master')


@section('title')

    Edit Mpesa Shortcode - {{ $mpesashortcode->shortcode_number }}

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Edit Mpesa Shortcode - {{ $mpesashortcode->shortcode_number }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              {!! Breadcrumbs::render('mpesa-shortcodes.edit', $mpesashortcode->id) !!}
          </div>
          <!-- /Breadcrumb -->
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
                                    <h3 class="text-center txt-dark mb-10">
                                        Edit Mpesa Shortcode - {{ $mpesashortcode->shortcode_number }}
                                    </h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('mpesa-shortcodes.update', $mpesashortcode->id) }}">

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">

                                          <label for="company_id" class="col-sm-3 control-label">
                                             Company
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">

                                             <select class="selectpicker form-control"
                                                name="company_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($companies as $company)
                                                <li class="mb-10">
                                                <option value="{{ $company->id }}"

                                          @if ($company->id == old('company_id', $mpesashortcode->company->id))
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

                                       <div  class="form-group{{ $errors->has('shortcode_number') ? ' has-error' : '' }}">

                                          <label for="shortcode_number" class="col-sm-3 control-label">
                                             Shortcode No.
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="shortcode_number"
                                                name="shortcode_number"
                                                value="{{ old('shortcode_number', $mpesashortcode->shortcode_number)}}"
                                                required autofocus>

                                             @if ($errors->has('shortcode_number'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('shortcode_number') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                          <label for="name" class="col-sm-3 control-label">
                                             Shortcode Name
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                name="name"
                                                value="{{ old('name', $mpesashortcode->name)}}"
                                                >

                                             @if ($errors->has('name'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('name') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                            <label for="description" class="col-sm-3 control-label">
                                                Description
                                            </label>

                                            <div class="col-sm-9">

                                              <textarea
                                                  class="form-control"
                                                  rows="5"
                                                  id="description"
                                                  name="description">{{ old('description', $mpesashortcode->description)}}</textarea>

                                               @if ($errors->has('description'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('description') }}</strong>
                                                    </span>
                                               @endif

                                            </div>

                                         </div>


                                         <div  class="form-group{{ $errors->has('shortcode_user') ? ' has-error' : '' }}">

                                            <label for="shortcode_user" class="col-sm-3 control-label">
                                                Shortcode User
                                            </label>

                                            <div class="col-sm-9">

                                                <input
                                                    class="form-control"
                                                    type="text"
                                                    id="shortcode_user"
                                                    name="shortcode_user"
                                                    value="{{ old('shortcode_user', $mpesashortcode->shortcode_user) }}">

                                                @if ($errors->has('shortcode_user'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('shortcode_user') }}</strong>
                                                    </span>
                                                @endif

                                            </div>

                                         </div>

                                         <div  class="form-group{{ $errors->has('shortcode_password') ? ' has-error' : '' }}">

                                                <label for="shortcode_password" class="col-sm-3 control-label">
                                                    Shortcode Password
                                                </label>

                                                <div class="col-sm-9">

                                                    <input
                                                        class="form-control"
                                                        type="text"
                                                        id="shortcode_password"
                                                        name="shortcode_password"
                                                        value="{{ old('shortcode_password', $mpesashortcode->shortcode_password) }}">

                                                    @if ($errors->has('shortcode_password'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('shortcode_password') }}</strong>
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

  @include('_admin.layouts.partials.error_messages')

@endsection
