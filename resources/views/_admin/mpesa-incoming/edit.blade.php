@extends('_admin.layouts.master')


@section('title')

    Edit Mpesa Paybill - {{ $mpesapaybill->paybill_number }}

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Edit Mpesa Paybill - {{ $mpesapaybill->paybill_number }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              {!! Breadcrumbs::render('mpesa-paybills.edit', $mpesapaybill->id) !!}
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
                                        Edit Mpesa Paybill - {{ $mpesapaybill->paybill_number }}
                                    </h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('mpesa-paybills.update', $mpesapaybill->id) }}">

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('paybill_number') ? ' has-error' : '' }}">

                                          <label for="paybill_number" class="col-sm-3 control-label">
                                             Paybill Number
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="paybill_number"
                                                name="paybill_number"
                                                value="{{ old('paybill_number', $mpesapaybill->paybill_number)}}"
                                                required autofocus>

                                             @if ($errors->has('paybill_number'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('paybill_number') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

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

                                          @if ($company->id == old('company_id', $mpesapaybill->company->id))
                                              selected="selected"
                                          @endif
                                                    >
                                                      {{ $company->name }}
                                                    </option>
                                                </li>
                                                @endforeach

                                             </select>

                                             @if ($errors->has('company_name'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('company_name') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div>


                                       <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                          <label for="name" class="col-sm-3 control-label">
                                             Name
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                name="name"
                                                value="{{ old('name', $mpesapaybill->name)}}"
                                                required
                                                autofocus>

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
                                                name="description">{{ old('description', $mpesapaybill->description)}}</textarea>

                                             @if ($errors->has('description'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('description') }}</strong>
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
