@extends('_admin.layouts.master')


@section('title')

    Create Branch Member

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Create New Branch Member</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

              {!! Breadcrumbs::render('branchmembers.create') !!}

          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell vertical-align-middlexx auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                <div  class="col-sm-12 col-md-8 col-md-offset-2">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">

                        <div class="panel panel-default card-view">

                           <div class="panel-wrapper collapse in">

                              <div class="panel-body">

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">Create Branch Member</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <!-- @if (session('message'))
                                      <div class="alert alert-success text-center">
                                          {{ session('message') }}
                                      </div>
                                    @endif

                                    @if (session('error'))
                                      <div class="alert alert-danger text-center">
                                          {{ session('error') }}
                                      </div>
                                    @endif -->

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('branchmembers.store') }}">

                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('company_user_id') ? ' has-error' : '' }}">

                                            <label for="company_user_id" class="col-sm-3 control-label">
                                            Company User
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                            <select class="selectpicker form-control"
                                                name="company_user_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($companyusers as $company_user)

                                                    @if($company_user->user)

                                                        <li class="mb-10">
                                                            <option value="{{ $company_user->id }}"
                                                        @if ($company_user->id == old('company_user_id', $company_user->id))
                                                            selected="selected"
                                                        @endif
                                                                >

                                                                    {{ $company_user->user->first_name }}
                                                                    {{ $company_user->user->last_name }}


                                                                    @if(($company_user->company) && (Auth::user()->hasRole('superadministrator')))
                                                                    &nbsp; ({{ $company_user->company->name }})
                                                                    @endif

                                                                </option>
                                                        </li>

                                                    @endif

                                                @endforeach

                                            </select>

                                            @if ($errors->has('company_user_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('company_user_id') }}</strong>
                                                    </span>
                                            @endif

                                            </div>

                                        </div>

                                       <div  class="form-group{{ $errors->has('company_branch_id') ? ' has-error' : '' }}">

                                            <label for="company_branch_id" class="col-sm-3 control-label">
                                            Branch Name
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                            <select class="selectpicker form-control"
                                                name="company_branch_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($companybranches as $company_branch)
                                                <li class="mb-10">
                                                <option value="{{ $company_branch->id }}"
                                            @if ($company_branch->id == old('company_branch_id', $company_branch->id))
                                                selected="selected"
                                            @endif
                                                    >
                                                        {{ $company_branch->name }}

                                                        @if(($company_branch->company) && (Auth::user()->hasRole('superadministrator')))
                                                        &nbsp; ({{ $company_branch->company->name }})
                                                        @endif

                                                    </option>
                                                </li>
                                                @endforeach

                                            </select>

                                            @if ($errors->has('company_branch_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('company_branch_id') }}</strong>
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
