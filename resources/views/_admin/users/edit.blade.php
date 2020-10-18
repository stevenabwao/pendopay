@extends('_admin.layouts.master')

@section('title')

    Edit User - {{ $user->first_name }}

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6">
            <h5 class="txt-dark">Edit User - {{ $user->first_name }} {{ $user->last_name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6">
              {!! Breadcrumbs::render('users.edit', $user->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">

          <div class="table-cell">
             <div class=" ml-auto mr-auto no-float">

                  @if (session('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                  @endif

                  @if (session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                  @endif

                  <form class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}">

                     {{ method_field('PUT') }}
                     {{ csrf_field() }}

                      <div class="row">

                            <div  class="col-sm-12">

                                <div class="panel panel-default border-panel card-view">

                                    <div  class="col-sm-12 col-md-6">

                                        <div class="panel panel-default border-panel card-view">

                                           <div class="panel-heading">

                                             <div class="pull-left">
                                                <h5 class="panel-title txt-dark">
                                                  <strong>Account Details</strong>
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

                                                    @if (session('error'))
                                                      <div class="alert alert-danger text-center">
                                                          {{ session('error') }}
                                                      </div>
                                                    @endif



                                                      {{-- <div  class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">

                                                        <label for="account_number" class="col-sm-3 control-label">
                                                           Account Number
                                                        </label>
                                                        <div class="col-sm-9">
                                                           <div class="input-group">
                                                              <input
                                                                  type="text"
                                                                  class="form-control"
                                                                  id="account_number"
                                                                  name="account_number"
                                                                  value="{{ $user->account_number }}"
                                                                   autofocus>
                                                              <div class="input-group-addon"><i class="icon-plus"></i></div>
                                                           </div>
                                                           @if ($errors->has('account_number'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('account_number') }}</strong>
                                                                </span>
                                                           @endif
                                                        </div>

                                                     </div> --}}

                                                       <div  class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">

                                                          <label for="first_name" class="col-sm-3 control-label">
                                                             First Name
                                                             <span class="text-danger"> *</span>
                                                          </label>
                                                          <div class="col-sm-9">
                                                             <div class="input-group">
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="first_name"
                                                                    name="first_name"
                                                                    value="{{ $user->first_name }}" required>
                                                                <div class="input-group-addon"><i class="icon-user"></i></div>
                                                             </div>
                                                             @if ($errors->has('first_name'))
                                                                  <span class="help-block">
                                                                      <strong>{{ $errors->first('first_name') }}</strong>
                                                                  </span>
                                                             @endif
                                                          </div>

                                                       </div>

                                                       <div  class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">

                                                          <label for="last_name" class="col-sm-3 control-label">
                                                             Last Name
                                                             <span class="text-danger"> *</span>
                                                          </label>
                                                          <div class="col-sm-9">
                                                             <div class="input-group">
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="last_name"
                                                                    name="last_name"
                                                                    value="{{ $user->last_name }}" required>
                                                                <div class="input-group-addon"><i class="icon-user"></i></div>
                                                             </div>
                                                             @if ($errors->has('last_name'))
                                                                  <span class="help-block">
                                                                      <strong>{{ $errors->first('last_name') }}</strong>
                                                                  </span>
                                                             @endif
                                                          </div>

                                                       </div>

                                                       <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                                          <label for="email" class="col-sm-3 control-label">
                                                             Email Address
                                                             <span class="text-danger"> *</span>
                                                          </label>
                                                          <div class="col-sm-9">
                                                             <div class="input-group">
                                                                <input
                                                                    type="email"
                                                                    class="form-control"
                                                                    id="email"
                                                                    name="email"
                                                                    value="{{ $user->email }}" >
                                                                <div class="input-group-addon"><i class="icon-envelope-open"></i></div>
                                                             </div>
                                                             @if ($errors->has('email'))
                                                                  <span class="help-block">
                                                                      <strong>{{ $errors->first('email') }}</strong>
                                                                  </span>
                                                             @endif
                                                          </div>

                                                       </div>

                                                       <div  class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">

                                                          <label for="phone" class="col-sm-3 control-label">
                                                             Phone Number
                                                             <span class="text-danger"> *</span>
                                                          </label>
                                                          <div class="col-sm-9">
                                                             <div class="input-group">
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="phone"
                                                                    name="phone"
                                                                    maxlength="13"
                                                                    value="{{ old('phone', $user->phone)}}" required>
                                                                <div class="input-group-addon"><i class="icon-phone"></i></div>
                                                             </div>
                                                             @if ($errors->has('phone'))
                                                                  <span class="help-block">
                                                                      <strong>{{ $errors->first('phone') }}</strong>
                                                                  </span>
                                                             @endif
                                                          </div>

                                                       </div>

                                                       <div class="form-group">
                                                          <label for="gender" class="col-sm-3 control-label">
                                                             Gender
                                                             <span class="text-danger"> *</span>
                                                          </label>
                                                          <div class="col-sm-9">
                                                             <div class="col-sm-6">
                                                                <div class="radio">
                                                                   <input type="radio"
                                                                   name="gender"
                                                                   id="gender" value="m"
                                                                   @if ($user->gender == 'm')
                                                                    checked
                                                                   @endif
                                                                   >
                                                                   <label for="m">Male</label>
                                                                </div>
                                                             </div>
                                                             <div class="col-sm-6">
                                                                <div class="radio">
                                                                   <input type="radio"
                                                                   name="gender"
                                                                   id="gender" value="f"
                                                                   @if ($user->gender == 'f')
                                                                    checked
                                                                   @endif
                                                                   >
                                                                   <label for="f">Female</label>
                                                                </div>
                                                             </div>
                                                          </div>
                                                       </div>

                                                       <hr>

                                                       <div class="form-group">
                                                          <label for="gender" class="col-sm-3 control-label">
                                                             Password
                                                             <span class="text-danger"> *</span>
                                                          </label>
                                                          <div class="col-sm-9">
                                                             <div class="col-sm-12">
                                                                <div class="radio">
                                                                   <input type="radio"
                                                                      name="change_password"
                                                                      id="change_password"
                                                                      v-model="password_option"
                                                                      value="keep">
                                                                   <label for="keep">Don't change Password</label>
                                                                </div>
                                                             </div>
                                                             <div class="col-sm-12">
                                                                <div class="radio">
                                                                   <input type="radio"
                                                                      name="password_option"
                                                                      id="password_option"
                                                                      v-model="password_option"
                                                                      value="auto">
                                                                   <label for="auto">AutoGenerate New Password</label>
                                                                </div>
                                                             </div>
                                                             <div class="col-sm-12">
                                                                <div class="radio">
                                                                   <input type="radio"
                                                                      name="password_option"
                                                                      id="password_option"
                                                                      v-model="password_option"
                                                                      value="manual">
                                                                   <label for="manual">Manually Set New Password</label>
                                                                </div>
                                                                <div class="input-group"
                                                                    v-if="password_option=='manual'">
                                                                    <input
                                                                        type="password"
                                                                        class="form-control"
                                                                        id="password"
                                                                        name="password"
                                                                        >
                                                                    <div class="input-group-addon"><i class="icon-lock"></i></div>
                                                                 </div>
                                                             </div>
                                                          </div>
                                                       </div>

                                                 </div>

                                              </div>

                                           </div>

                                        </div>

                                    </div>


                                    @if (Auth::user()->hasRole('superadministrator'))

                                    <div  class="col-sm-12 col-md-6">

                                           <input type="hidden" name="rolesSelected" :value="rolesSelected">

                                           <div class="panel panel-default border-panel card-view">

                                              <div class="panel-heading">

                                                 <div class="pull-left">
                                                    <h5 class="panel-title txt-dark">
                                                      <strong>User Roles</strong>
                                                    </h5>
                                                 </div>
                                                 <div class="clearfix"></div>
                                              </div>
                                              <div  class="panel-wrapper collapse in">
                                                 <div  class="panel-body">

                                                    <div
                                                        class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}"
                                                        v-show="{{ (Auth::user()->hasRole('superadministrator')) }}">

                                                        <label for="company_id" class="col-sm-3 control-label">
                                                           Company
                                                        </label>
                                                        <div class="col-sm-9">

                                                           <select class="selectpicker form-control"
                                                              name="company_id"
                                                              data-style="form-control btn-default btn-outline"
                                                              >

                                                              <li class="mb-10">
                                                                  <option value="">
                                                                    Select
                                                                  </option>
                                                              </li>

                                                              <?php //var_dump($companies) ?>

                                                              @foreach ($companies as $company)
                                                              <li class="mb-10">
                                                                  <option value="{{ $company->id }}"


                          @if ($user->company)
                              @if (($company->id == old('company_id')) || ($company->id == $user->company->id))
                                  selected="selected"
                              @endif
                          @else
                              @if ($company->id == old('company_id'))
                                selected="selected"
                              @endif
                          @endif
                                                                  >
                                                                    {{ $company->name }}
                                                                  </option>
                                                              </li>
                                                              @endforeach


                                                           </select>

                                                           @if ($errors->has('company_name'))
                                                                <span class="help-block">
                                                                    <strong>
                                                                      {{ $errors->first('company_name') }}
                                                                    </strong>
                                                                </span>
                                                           @endif

                                                        </div>

                                                     </div>

                                                     <hr>

                                                    <p>
                                                        <ul>
                                                            @foreach ($roles as $role)
                                                            <li>
                                                               <div class="checkbox">
                                                                  <input
                                                                      id="{{ $role->id }}"
                                                                      type="checkbox"
                                                                      :value="{{ $role->id }}"
                                                                      v-model="rolesSelected">
                                                                  <label for="{{ $role->id }}">
                                                                      {{ $role->display_name }}
                                                                      &nbsp;&nbsp;
                                                                      <em class="ml-15">
                                                                          ({{ $role->description }})
                                                                      </em>
                                                                  </label>
                                                               </div>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </p>

                                                 </div>
                                              </div>

                                           </div>

                                    </div>

                                    @endif


                                    @if (count($groups))
                                    <div  class="col-sm-12 col-md-6">

                                           <input type="hidden" name="rolesSelected" :value="rolesSelected">

                                           <div class="panel panel-default border-panel card-view">

                                              <div class="panel-heading">

                                                 <div class="pull-left">
                                                    <h5 class="panel-title txt-dark">
                                                      <strong>User Group</strong>
                                                    </h5>
                                                 </div>
                                                 <div class="clearfix"></div>
                                              </div>
                                              <div  class="panel-wrapper collapse in">
                                                 <div  class="panel-body">

                                                    <input type="hidden" name="groupsSelected" :value="groupsSelected">

                                                    <div class="user_options_tall nicescroll-bar">

                                                      <p>
                                                          <ul>
                                                              @foreach ($groups as $group)
                                                              <li>
                                                                 <div class="checkbox">
                                                                    <input
                                                                        id="{{ $group->id }}"
                                                                        type="checkbox"
                                                                        :value="{{ $group->id }}"
                                                                        v-model="groupsSelected">
                                                                    <label for="{{ $group->id }}">
                                                                        {{ $group->name }}
                                                                        &nbsp;&nbsp;
                                                                        <em class="ml-15">
                                                                            ({{ $group->description }})
                                                                        </em>
                                                                    </label>
                                                                 </div>
                                                              </li>
                                                              @endforeach
                                                          </ul>
                                                      </p>

                                                    </div>

                                                 </div>
                                              </div>

                                           </div>

                                    </div>
                                    @endif


                                    <div class="form-group">
                                        <div class="row">
                                          <div class="col-sm-12">
                                            <button
                                              type="submit"
                                              class="btn btn-primary btn-lg btn-block"
                                               id="submit-btn">
                                               Edit User
                                            </button>
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

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  <script type="text/javascript">

      var app = new Vue({
        el: "#app",

        data() {
            return {
              password_option: 'keep',
              rolesSelected: {!!$user->roles->pluck('id')!!},
              groupsSelected: {!!$user->groups->pluck('id')!!}
            }
        }

      });
  </script>

@endsection
