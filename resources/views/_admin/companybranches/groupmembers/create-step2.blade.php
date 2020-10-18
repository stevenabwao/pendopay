@extends('_admin.layouts.master')


@section('title')

    Add Group Member - Step 2

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Add Group Member - Step 2</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

              {!! Breadcrumbs::render('groupmembers.create-step2') !!}

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
                                    <h3 class="text-center txt-dark mb-10">Add Group Member - Step 2</h3>
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
                                        action="{{ route('groupmembers.create-step2-store') }}">

                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('branch_group_id') ? ' has-error' : '' }}">

                                            <label for="branch_group_id" class="col-sm-3 control-label">
                                            Branch
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    value="{{ $companybranch->name }} @if(($companybranch->company) && (Auth::user()->hasRole('superadministrator'))) - &nbsp; ({{ $companybranch->company->name }})
                                                    @endif

                                                    " disabled>

                                                <input
                                                    type="hidden"
                                                    class="form-control"
                                                    id="company_branch_id"
                                                    name="company_branch_id"
                                                    value="{{ $companybranch->id }} " >
                                            </div>
                                        </div>

                                        <div  class="form-group{{ $errors->has('branch_group_id') ? ' has-error' : '' }}">

                                            <label for="branch_group_id" class="col-sm-3 control-label">
                                            Branch Group
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                            <select class="selectpicker form-control"
                                                name="branch_group_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($branchgroups as $branch_group)

                                                    <li class="mb-10">
                                                        <option value="{{ $branch_group->id }}"
                                                    @if ($branch_group->id == old('branch_group_id', $branch_group->id))
                                                        selected="selected"
                                                    @endif
                                                            >

                                                                {{ $branch_group->name }}

                                                                @if(($branch_group->company) && (Auth::user()->hasRole('superadministrator')))
                                                                &nbsp; ({{ $branch_group->company->name }})
                                                                @endif

                                                            </option>
                                                    </li>

                                                @endforeach

                                            </select>

                                            @if ($errors->has('branch_group_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('branch_group_id') }}</strong>
                                                    </span>
                                            @endif

                                            </div>

                                        </div>

                                       <div  class="form-group{{ $errors->has('branch_member_id') ? ' has-error' : '' }}">

                                            <label for="branch_member_id" class="col-sm-3 control-label">
                                            Branch Member
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">

                                            <select class="selectpicker form-control"
                                                name="branch_member_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($branchmembers as $branch_member)
                                                <li class="mb-10">
                                                <option value="{{ $branch_member->id }}"
                                            @if ($branch_member->id == old('branch_member_id', $branch_member->id))
                                                selected="selected"
                                            @endif
                                                    >
                                                        {{ $branch_member->companyuser->user->first_name }}

                                                        @if(($branch_member->company) && (Auth::user()->hasRole('superadministrator')))
                                                        &nbsp; ({{ $branch_member->company->name }})
                                                        @endif

                                                    </option>
                                                </li>
                                                @endforeach

                                            </select>

                                            @if ($errors->has('branch_member_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('branch_member_id') }}</strong>
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
