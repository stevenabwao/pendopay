@extends('_admin.layouts.master')


@section('title')

    Edit Branch Member
    @if($branchmember->companyuser)
      - {{ $branchmember->companyuser->user->first_name }}
        {{ $branchmember->companyuser->user->last_name }}
    @endif

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Edit Branch Member
            @if($branchmember->companyuser)
            - {{ $branchmember->companyuser->user->first_name }}
              {{ $branchmember->companyuser->user->last_name }}
            @endif
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              {!! Breadcrumbs::render('branchmembers.edit', $branchmember->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell vertical-align-middle auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                <div  class="col-sm-12 col-md-8 col-md-offset-2">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">

                        <div class="panel panel-default card-view">

                           <div class="panel-wrapper collapse in">

                              <div class="panel-body">

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">
                                        Edit Branch Member
                                        @if($branchmember->companyuser)
                                          - {{ $branchmember->companyuser->user->first_name }}
                                            {{ $branchmember->companyuser->user->last_name }}
                                        @endif
                                    </h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('branchmembers.update', $branchmember->id) }}">

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                          <label for="name" class="col-sm-3 control-label">
                                             Member Name
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                name="name"
                                                value="{{ old('name', $branchmember->name)}}"
                                                required
                                                autofocus>

                                             @if ($errors->has('first_name'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('first_name') }}</strong>
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

                                                         @if ($company_branch->id == old('company_branch_id', $branchmember->id))
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

                                       <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                          <label for="description" class="col-sm-3 control-label">
                                             Group Description
                                          </label>

                                          <div class="col-sm-9">

                                            <textarea
                                                class="form-control"
                                                rows="5"
                                                id="description"
                                                name="description">{{ old('description', $branchmember->description)}}</textarea>

                                             @if ($errors->has('description'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('description') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div>



                                       <div  class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                          <label for="email" class="col-sm-3 control-label">
                                                Group Email Address
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="email"
                                                class="form-control"
                                                id="email"
                                                name="email"
                                                value="{{ old('email', $branchmember->email)}}">

                                             @if ($errors->has('email'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('email') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>



                                       <div  class="form-group{{ $errors->has('physical_address') ? ' has-error' : '' }}">

                                          <label for="physical_address" class="col-sm-3 control-label">
                                                Group Physical Address
                                          </label>
                                          <div class="col-sm-9">

                                            <input
                                                type="text"
                                                class="form-control"
                                                id="physical_address"
                                                name="physical_address"
                                                value="{{ old('physical_address', $branchmember->physical_address)}}">

                                             @if ($errors->has('physical_address'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('physical_address') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('box') ? ' has-error' : '' }}">

                                          <label for="box" class="col-sm-3 control-label">
                                                Group Box Number
                                          </label>
                                          <div class="col-sm-9">

                                            <input
                                                type="text"
                                                class="form-control"
                                                id="box"
                                                name="box"
                                                value="{{ old('box', $branchmember->box)}}">

                                             @if ($errors->has('box'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('box') }}</strong>
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
