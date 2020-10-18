@extends('_admin.layouts.master')

@section('title')

    Create Bulk User Accounts

@endsection


@section('css_header')

    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

    <style type="text/css">
      .user_options{ max-height: 350px; overflow: scroll;max-width: 100%;
        overflow-x: hidden;}
    </style>

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create Bulk User Accounts</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('bulk-users.create') !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell">
             <div class="ml-auto mr-auto no-float">

                <div  class="col-sm-12">

                  <div class="row">
                     <div class="col-md-6 col-sm-12 col-xs-12">

                        <div class="panel panel-default card-view">

                           <div class="panel-wrapper collapse in">

                              <div class="panel-body">

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Create Bulk User Accounts</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        enctype="multipart/form-data" action="{{ route('bulk-users.store') }}">

                                       {{ csrf_field() }}

                                       <div
                                          class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}"
                                          v-show="{{ (Auth::user()->hasRole('superadministrator')) }}">

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

                                       <div class="form-group">
                                         <label class="col-sm-3 control-label">
                                            Select File (XLS, XLSX, CSV)
                                         </label>
                                         <div class="col-sm-9">
                                           <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                              <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                              </div>
                                              <span class="input-group-addon fileupload btn btn-info btn-anim btn-file">
                                                <i class="fa fa-upload"></i>
                                                <span class="fileinput-new btn-text">Select file</span>
                                                <span class="fileinput-exists btn-text">Change</span>
                                                <input type="file" name="import_file">
                                              </span>
                                              <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput">
                                                <i class="fa fa-trash"></i>
                                                <span class="btn-text"> Remove</span>
                                              </a>
                                           </div>
                                         </div>
                                      </div>


                                      <div class="form-group">
                                          <div class="col-sm-3"></div>
                                          <div class="col-sm-9">
                                            <a href="{{ asset('templates/new_user_template.xls') }}">
                                              <i class="fa fa-file-excel-o text-success"></i>
                                              Download Sample Excel File
                                            </a>
                                          </div>
                                      </div>

                                       <br/>

                                       <div class="form-group">
                                          <div class="col-sm-3"></div>
                                          <div class="col-sm-9">
                                             <button type="submit" class="btn btn-primary btn-block mr-10">Submit</button>
                                          </div>
                                       </div>

                                       <br/>

                                       <hr>

                                       <div class="text-center">
                                          <a href="{{ route('users.create') }}">
                                          <i class="zmdi zmdi-account-add mr-10"></i> Create Single Account
                                          </a>
                                       </div>

                                    </form>

                                 </div>

                              </div>

                           </div>

                        </div>
                     </div>

                     <div class="col-md-6 col-sm-12 col-xs-12">

                        <div class="panel panel-default card-view">

                           <div class="panel-wrapper collapse in">

                              <div class="panel-body">

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Upload Results</h3>
                                 </div>

                                 <hr>

                                 @if (!session('error_row_id'))
                                    <div class="user_options nicescroll-bar">

                                       @if (session('success'))
                                       <div class="alert alert-success text-center">
                                          Data successfully uploaded {{ session('valid_row_id') }}
                                       </div>
                                       @endif

                                   </div>

                                 @endif

                                 @if ((session('valid_row_id')) && (session('error_row_id')))

                                    <div class="user_options nicescroll-bar">

                                       <div class="alert alert-default text-center">
                                          <div class="text-danger">
                                            Data not uploaded
                                          </div>
                                          <br/><br/>
                                          <a href="{{ route('bulk-users.getincompletedata', session('valid_row_id')) }}" class="btn btn-block btn-success">
                                            <i class="fa fa-download text-white"></i> &nbsp;
                                            Click to create users using valid data
                                          </a>

                                       </div>

                                   </div>

                                   <hr>

                                @endif

                                 @if (session('error_row_id'))

                                   <div class="user_options slimScrollDiv">

                                       <div class="alert alert-default text-center">
                                          <div class="text-danger">
                                            Data not uploaded. Please correct errors and try again.
                                          </div>
                                          <br/><br/>
                                          <a href="{{ route('bulk-users.getimportdata', session('error_row_id')) }}" class="btn btn-block btn-danger">
                                            <i class="fa fa-download text-white"></i>  &nbsp;
                                            Download file with detected errors
                                          </a>

                                       </div>

                                   </div>

                                  @endif

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

