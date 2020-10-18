@extends('_admin.layouts.master')

@section('title')

    Create Permission

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Create New Permission</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('permissions.create') !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell">
             <div class="ml-auto mr-auto no-float">
                <div class="row">
                   <div class="col-sm-12 col-xs-12">

                      <div class="panel panel-default card-view">

                         <div class="panel-wrapper collapse in">

                            <div class="panel-body">

                               <div class="mb-30">
                                  <h3 class="text-center txt-dark mb-10">Create Permission</h3>
                               </div>

                               <hr>

                               <div class="form-wrap">

                                  @if (session('message'))
                                    <div class="alert alert-success text-center">
                                        {{ session('message') }}
                                    </div>
                                  @endif

                                  <form class="form-horizontal" method="POST" action="{{ route('permissions.store') }}">

                                     {{ csrf_field() }}

                                     <div class="form-group mt-20">

                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9">
                                           <div class="row">
                                             <div class="col-sm-6">
                                                <div class="radio">
                                                   <input type="radio"
                                                      name="permission_type"
                                                      id="permission_type"
                                                      value="basic"
                                                      checked=""
                                                      v-model="permissionType">
                                                   <label for="basic">Basic Permission</label>
                                                </div>
                                             </div>
                                             <div class="col-sm-6">
                                                <div class="radio">
                                                   <input
                                                      type="radio"
                                                      name="permission_type"
                                                      id="permission_type"
                                                      value="crud"
                                                      v-model="permissionType">
                                                   <label for="crud">CRUD Permission</label>
                                                </div>
                                             </div>
                                           </div>
                                        </div>

                                     </div>

                                     <hr>

                                     <div v-if="permissionType=='basic'">

                                       <div  class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">

                                          <label for="display_name" class="col-sm-12 control-label text-left">
                                             Name (Display Name) e.g. Create Post
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-12">
                                              <input
                                                  type="text"
                                                  class="form-control"
                                                  id="display_name"
                                                  name="display_name"
                                                  value="{{ old('display_name') }}" required autofocus>
                                               @if ($errors->has('display_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('display_name') }}</strong>
                                                    </span>
                                               @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                          <label for="name" class="col-sm-12 control-label text-left">
                                             Slug e.g. create-post
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-12">
                                              <input
                                                  type="text"
                                                  class="form-control"
                                                  id="name"
                                                  name="name"
                                                  value="{{ old('name') }}" required>
                                               @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                               @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                          <label for="description" class="col-sm-12 control-label text-left">
                                             Description e.g. Allows User To Create a Post
                                          </label>
                                          <div class="col-sm-12">
                                              <input
                                                  type="text"
                                                  class="form-control"
                                                  id="description"
                                                  name="description"
                                                  value="{{ old('description') }}" required autofocus>
                                               @if ($errors->has('description'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('description') }}</strong>
                                                    </span>
                                               @endif
                                          </div>

                                       </div>

                                     </div>


                                     <div v-if="permissionType=='crud'">

                                         <div  class="form-group{{ $errors->has('resource') ? ' has-error' : '' }}">

                                            <label for="resource" class="col-sm-12 control-label text-left">
                                               Resource e.g. post
                                               <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-12">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="resource"
                                                    name="resource"
                                                    value="{{ old('resource') }}"
                                                    v-model="resource">
                                                 @if ($errors->has('resource'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('resource') }}</strong>
                                                      </span>
                                                 @endif
                                            </div>

                                         </div>

                                        <div class="row">

                                            <div class="col-sm-6 col-md-3">

                                               <div class="form-group">


                                                  <div class="col-sm-12">
                                                     <div class="checkbox">
                                                        <input id="create"
                                                            type="checkbox"
                                                            name="crudCheck"
                                                            value="create"
                                                            v-model="crudSelected"
                                                          {{ old('create') ? 'checked' : '' }}>
                                                        <label for="create"> Create</label>
                                                     </div>
                                                  </div>

                                                  <div class="col-sm-12">
                                                     <div class="checkbox">
                                                        <input id="read"
                                                            type="checkbox"
                                                            name="crudCheck"
                                                            value="read"
                                                            v-model="crudSelected"
                                                          {{ old('read') ? 'checked' : '' }}>
                                                        <label for="read"> Read</label>
                                                     </div>
                                                  </div>

                                                  <div class="col-sm-12">
                                                     <div class="checkbox">
                                                        <input id="update"
                                                            type="checkbox"
                                                            name="crudCheck"
                                                            value="update"
                                                            v-model="crudSelected"
                                                          {{ old('update') ? 'checked' : '' }}>
                                                        <label for="update"> Update</label>
                                                     </div>
                                                  </div>

                                                  <div class="col-sm-12">
                                                     <div class="checkbox">
                                                        <input id="delete"
                                                            type="checkbox"
                                                            name="crudCheck"
                                                            value="delete"
                                                            v-model="crudSelected"
                                                          {{ old('delete') ? 'checked' : '' }}>
                                                        <label for="delete"> Delete</label>
                                                     </div>
                                                  </div>

                                                  <input type="hidden" name="crud_selected" :value="crudSelected">

                                               </div>

                                            </div>

                                            <div class="col-sm-6 col-md-9">

                                              <div class="table-wrap">
                                                <div class="table-responsive">
                                                   <table class="table table-hover mb-0">
                                                      <thead>
                                                         <tr>
                                                            <th>Name</th>
                                                            <th>Slug</th>
                                                            <th>Description</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody v-if="resource.length >= 3">

                                                           <tr v-for="item in crudSelected">
                                                              <td v-text="crudName(item)"></td>
                                                              <td v-text="crudSlug(item)"></td>
                                                              <td v-text="crudDescription(item)"></td>
                                                           </tr>

                                                      </tbody>
                                                   </table>
                                                </div>
                                             </div>

                                            </div>

                                        </div>

                                     </div>

                                     <br/>

                                     <hr>

                                     <div class="form-group">
                                        <div class="col-sm-12">
                                            <button
                                              type="submit"
                                              class="btn btn-primary btn-block mr-10"
                                               id="submit-btn">
                                               Create Permission
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
       <!-- /Row -->


    </div>


@endsection


@section('page_scripts')

  <script>

      var app = new Vue({
        el: "#app",

        data() {
            return {
                permissionType: 'basic',
                resource: '',
                crudSelected: ['create', 'read', 'update', 'delete']
            }
        },

        methods : {

            handleSubmit() {
                $("#submit-btn").LoadingOverlay("show")
            },
            crudName: function(item){
              return item.substr(0,1).toUpperCase() + item.substr(1) + " "
                  + app.resource.substr(0,1).toUpperCase() + app.resource.substr(1)
            },
            crudSlug: function(item){
              return item.toLowerCase() + "-" + app.resource.toLowerCase()
            },
            crudDescription: function(item){
              return "Allow a user to " + item.toUpperCase() + " a "
                  + app.resource.substr(0,1).toUpperCase() + app.resource.substr(1)
            }

        }

      });

 </script>

@endsection
