@extends('_admin.layouts.master')

@section('title')

    Edit Role - {{ $role->display_name }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Edit Role - {{ $role->display_name }}</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('roles.edit', $role->id) !!}
          </div>
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell">
             <div class="ml-auto mr-auto no-float">

                    <form class="form-horizontal" role="form"
                       method="POST" action="{{ route('roles.update', $role->id) }}">

                        <div class="row">
                          <div class="col-sm-12">
                             <div class="panel panel-default border-panel card-view">
                                <div class="panel-heading">

                                   <div class="form-wrap">

                                      <!-- <form class="form-horizontal" role="form" method="POST"
                                          action="{{ route('roles.update', $role->id) }}"> -->

                                         {{ csrf_field() }}
                                         {{ method_field('PUT') }}

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
                                                    value="{{ $role->display_name }}"
                                                    required>
                                            </div>

                                         </div>

                                         <div  class="form-group">

                                            <label for="name" class="col-sm-12 control-label text-left">
                                              Slug (Cannot be changed)
                                            </label>
                                            <div class="col-sm-12">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    value="{{ $role->name }}"
                                                    disabled
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
                                                    value="{{ $role->description }}"
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
                                         <button type="submit" class="btn btn-primary btn-lg btn-block mr-10">Edit Role</button>
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
              permissionsSelected: {!!$role->permissions->pluck('id')!!}
            }
        }

        /*created() {
            console.log("hello there - " + {{$role->permissions->pluck('name') }})
        },

        methods : {

        }*/

      });
  </script>

@endsection
