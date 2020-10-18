@extends('_admin.layouts.master')

@section('title')

    Create Role

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create Role</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              <a href="{{ route('roles.index') }}" class="btn btn-primary btn-icon right-icon pull-right">
                <span>View Roles</span>
                <i class="zmdi zmdi-eye"></i>
              </a>
          </div>
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell">
             <div class="ml-auto mr-auto no-float">

                    <form class="form-horizontal" role="form"
                       method="POST" action="{{ route('roles.store') }}">

                        <div class="row">
                          <div class="col-sm-12">
                             <div class="panel panel-default border-panel card-view">
                                <div class="panel-heading">

                                   <div class="form-wrap">

                                         {{ csrf_field() }}

                                         <div  class="form-group">

                                            <label for="display_name" class="col-sm-12 control-label text-left">
                                               Display Name
                                               <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-12">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="display_name"
                                                    name="display_name"
                                                    value="{{old('display_name')}}"
                                                    required>
                                            </div>

                                         </div>

                                         <div  class="form-group">

                                            <label for="name" class="col-sm-12 control-label text-left">
                                              Slug (Cannot be changed)
                                              <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-12">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    value="{{old('name')}}"
                                                    name="name"
                                                    required>
                                            </div>

                                         </div>

                                         <div  class="form-group">

                                            <label for="description" class="col-sm-12 control-label text-left">
                                               Description
                                            </label>

                                            <div class="col-sm-12">
                                               <input
                                                    type="text"
                                                    class="form-control"
                                                    id="description"
                                                    name="description"
                                                    value="{{old('description')}}"
                                                    >
                                            </div>

                                            <input type="hidden" :value="permissionsSelected" name="permissions">

                                         </div>

                                      <!-- </form> -->

                                    </div>

                                 </div>
                              </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-sm-12">
                               <div class="panel panel-default border-panel card-view">

                                  <div class="panel-heading">

                                     <div class="pull-left">
                                        <h5 class="panel-title txt-dark">
                                          <strong>Permissions</strong>
                                        </h5>
                                     </div>
                                     <div class="clearfix"></div>
                                  </div>
                                  <div  class="panel-wrapper collapse in">
                                     <div  class="panel-body">
                                        <p>
                                            <ul>
                                                @foreach ($permissions as $permission)
                                                <li>
                                                   <div class="checkbox">
                                                      <input
                                                          id="{{ $permission->id }}"
                                                          type="checkbox"
                                                          :value="{{ $permission->id }}"
                                                          v-model="permissionsSelected">
                                                      <label for="{{ $permission->id }}">
                                                          {{ $permission->display_name }}
                                                          &nbsp;&nbsp;
                                                          <em class="ml-15">
                                                              ({{ $permission->description }})
                                                          </em>
                                                      </label>
                                                   </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </p>
                                     </div>
                                  </div>

                                  <hr>

                                  <div class="form-group">
                                      <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-block mr-10">
                                            Create Role
                                        </button>
                                      </div>
                                  </div>

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

  <script>

      var app = new Vue({

        el: "#app",

        data() {
            return {
              permissionsSelected: []
            }
        }

      });
  </script>

@endsection
