@extends('_admin.layouts.master')

@section('title')

    Showing Role - {{ $role->display_name }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing Role - {{ $role->display_name }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('roles.show', $role->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell">
             <div class="ml-auto mr-auto no-float">

                    <div class="row">
                      <div class="col-sm-12">
                         <div class="panel panel-default border-panel card-view">
                            <div class="panel-heading">
                               <div class="pull-left">
                                  <h5 class="panel-title txt-dark">
                                    <strong>{{ $role->display_name }}</strong> &nbsp;&nbsp; (<em>{{ $role->name }}</em>)
                                  </h5>
                               </div>
                               <div class="clearfix"></div>
                            </div>
                            <div  class="panel-wrapper collapse in">
                               <div  class="panel-body">
                                  <p>
                                      {{ $role->description }}
                                  </p>
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

                                      <ul class="list-icons">
                                          @foreach ($role->permissions as $r)
                                            <li class="mb-10">
                                                <i class="fa fa-genderless text-success mr-5"></i>
                                                {{ $r->display_name }}
                                                <em class="ml-15"> ({{ $r->description }})</em>
                                            </li>
                                          @endforeach
                                      </ul>

                                  </p>
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

