@extends('_admin.layouts.master')

@section('title')

    Create Mpesa Paybill

@endsection

@section('css_header')

    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create Mpesa Paybill</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('mpesa-paybills.create') !!}
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
                                    <h3 class="text-center txt-dark mb-10">Create Mpesa Paybill</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('mpesa-paybills.store') }}">

                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">

                                          <label for="company_id" class="col-sm-3 control-label">
                                             Company Name
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
                                          @if ($company->id == old('company_id', $company->id))
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


                                       <div  class="form-group{{ $errors->has('company_branch_id') ? ' has-error' : '' }}">

                                          <label for="company_branch_id" class="col-sm-3 control-label">
                                             Company Branch ID
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="company_branch_id"
                                                name="company_branch_id"
                                                value="{{ old('company_branch_id') }}" autofocus>

                                             @if ($errors->has('company_branch_id'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('company_branch_id') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">

                                          <label for="type" class="col-sm-3 control-label">
                                             Paybill Type
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="type"
                                                name="type"
                                                value="{{ old('type', 'paybill') }}" required>

                                             @if ($errors->has('type'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('type') }}</strong>
                                                  </span>
                                             @endif
                                          </div>
                                       </div>

                                       <div  class="form-group{{ $errors->has('paybill_number') ? ' has-error' : '' }}">

                                          <label for="paybill_number" class="col-sm-3 control-label">
                                             Paybill No./ Store No.
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="paybill_number"
                                                name="paybill_number"
                                                value="{{ old('paybill_number') }}">

                                             @if ($errors->has('paybill_number'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('paybill_number') }}</strong>
                                                  </span>
                                             @endif
                                          </div>
                                       </div>

                                       <div  class="form-group{{ $errors->has('till_number') ? ' has-error' : '' }}">

                                          <label for="till_number" class="col-sm-3 control-label">
                                             Till No.
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="till_number"
                                                name="till_number"
                                                value="{{ old('till_number') }}">

                                             @if ($errors->has('till_number'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('till_number') }}</strong>
                                                  </span>
                                             @endif
                                          </div>
                                       </div>

                                       <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                          <label for="name" class="col-sm-3 control-label">
                                             Paybill Name
                                             <a href="#" title="For example Branch Name, Product Name or any Unique Paybill Identifier" data-toggle="tooltip" class="ml-10">
                                               <i class="zmdi zmdi-info"  style="font-size: 20px"></i>
                                             </a>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                name="name"
                                                value="{{ old('name') }}">

                                             @if ($errors->has('name'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('name') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                          <label for="description" class="col-sm-3 control-label">
                                             Paybill Description
                                          </label>

                                          <div class="col-sm-9">

                                            <textarea
                                                class="form-control"
                                                rows="5"
                                                id="description"
                                                name="description">{{ old('description') }}</textarea>

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

@endsection
