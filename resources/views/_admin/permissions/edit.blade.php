@extends('_admin.layouts.master')

@section('title')

    Edit Permission - {{ $permission->display_name }}

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Edit Permission - {{ $permission->display_name }}</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('permissions.edit', $permission->id) !!}
          </div>
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                <div  class="col-sm-12 col-md-10 col-md-offset-1">

                    <div class="row">
                       <div class="col-sm-12 col-xs-12">

                          <div class="panel panel-default card-view">

                             <div class="panel-wrapper collapse in">

                                <div class="panel-body">

                                   <div class="mb-30">
                                      <h3 class="text-center txt-dark mb-10">
                                          Edit Permission - {{ $permission->display_name }}
                                      </h3>
                                   </div>

                                   <hr>

                                   <div class="form-wrap">

                                      @if (session('message'))
                                        <div class="alert alert-success text-center">
                                            {{ session('message') }}
                                        </div>
                                      @endif


                                      <form class="form-horizontal" method="POST"
                                          action="{{ route('permissions.update', $permission->id) }}">

                                         {{ method_field('PUT') }}
                                         {{ csrf_field() }}

                                         <div  class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">

                                            <label for="display_name" class="col-sm-3 control-label">
                                               Name (Display Name)
                                               <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="display_name"
                                                    name="display_name"
                                                    value="{{ $permission->display_name }}" required autofocus>
                                                 @if ($errors->has('display_name'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('display_name') }}</strong>
                                                      </span>
                                                 @endif
                                            </div>

                                         </div>

                                         <div  class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                            <label for="name" class="col-sm-3 control-label">
                                               Slug  (cannot be changed)
                                            </label>
                                            <div class="col-sm-9">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    disabled
                                                    value="{{ $permission->name }}" required>
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
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="description"
                                                    name="description"
                                                    value="{{ $permission->description }}" required>
                                                 @if ($errors->has('description'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('description') }}</strong>
                                                      </span>
                                                 @endif
                                            </div>

                                         </div>

                                         <hr>

                                         <div class="form-group">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9">
                                                <button
                                                  type="submit"
                                                  class="btn btn-primary btn-block mr-10"
                                                   id="submit-btn"
                                                   @click="handleSubmit()">
                                                   Edit Permission
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

  <script type="text/javascript">

      var app = new Vue({
        el: "#app",

        data() {
            return {
            }
        },

        methods : {

            handleSubmit() {
                $("#submit-btn").LoadingOverlay("show")
            }

        }

      });
  </script>

@endsection
