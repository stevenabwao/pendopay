@extends('_admin.layouts.master')

@section('title')

    Manage Roles

@endsection


@section('content')

    <div class="container-fluid">

		   <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
          <h5 class="txt-dark">
                Manage Roles
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('roles') !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

       <!-- Row -->
        <div class="row no-gutter">
           <div class="col-sm-12 col-xs-12">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>


                       @foreach ($roles as $role)

                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                           <div class="panel panel-default card-view panel-refresh">

                              <div class="panel-heading">
                                 <div class="pull-left">

                                    <h6 class="panel-title txt-dark">
                                        <a href="{{ route('roles.show', $role->id) }}" class="text-bold">
                                          {{ $role->display_name }}
                                        </a>
                                    </h6>

                                 </div>
                                 <div class="pull-right">

                                    <a
                                      href="{{ route('roles.show', $role->id) }}"
                                      class="pull-left inline-block mr-15"
                                      title="View role - '{{ $role->display_name }}'">
                                       <i class="zmdi zmdi-eye"></i>
                                    </a>

                                    <a
                                      href="{{ route('roles.edit', $role->id) }}"
                                      class="pull-left inline-block mr-15"
                                      title="Edit role - '{{ $role->display_name }}'">
                                       <i class="zmdi zmdi-edit"></i>
                                    </a>

                                    <a
                                      href="#"
                                      class="pull-left inline-block full-screen"
                                      title="Show Fullscreen">
                                       <i class="zmdi zmdi-fullscreen"></i>
                                    </a>

                                 </div>
                                 <div class="clearfix"></div>
                              </div>


                              <div>
                                   <p>
                                      <h7 class="txt-dark">
                                          <em>{{ $role->name }}</em>
                                      </h7>
                                    </p>
                              </div>

                              <div  id="collapse_1" class="panel-wrapper collapse in">
                                 <div  class="panel-body">
                                    <p>{{ $role->description }}</p>
                                 </div>
                              </div>

                              <hr>

                              <div class="row mb-10 ml-10 mr-10">
                                  <a
                                    href="{{ route('roles.show', $role->id) }}"
                                    class="btn  btn-default btn-outline pull-left">
                                    View
                                  </a>
                                  <a
                                    href="{{ route('roles.edit', $role->id) }}"
                                    class="btn  btn-success btn-outline pull-right">
                                    Edit
                                  </a>
                              </div>
                           </div>
                        </div>

                       @endforeach

           </div>

        </div>
        <!-- Row -->

    </div>


@endsection
