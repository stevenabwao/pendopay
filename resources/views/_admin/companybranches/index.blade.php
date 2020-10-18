@extends('_admin.layouts.master')

@section('title')

    Manage Company Branches

@endsection


@section('content')

    <div class="container-fluid">

		   <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
          <h5 class="txt-dark">
                Manage Company Branches
            </h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('companybranches') !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

       <!-- Row -->
        <div class="row">
           <div class="col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading panel-heading-dark">
                    <div class="pull-left">

                        <a
                          href="{{ route('companybranches.create') }}"
                          class="btn btn-sm btn-primary btn-icon right-icon mr-5">
                          <span>New</span>
                          <i class="fa fa-plus"></i>
                        </a>

                        <div class="btn-group">
                            <div class="dropdown">
                               <button
                                  aria-expanded="false"
                                  data-toggle="dropdown"
                                  class="btn btn-sm btn-success dropdown-toggle "
                                  type="button">
                                  Download
                                  <span class="caret ml-10"></span>
                               </button>
                               <ul role="menu" class="dropdown-menu">
                                  <li><a href="#">As Excel</a></li>
                                  <li><a href="#">As CSV</a></li>
                                  <li><a href="#">As PDF</a></li>
                                  <!-- <li class="divider"></li>
                                  <li><a href="#">Separated link</a></li> -->
                               </ul>
                            </div>
                        </div>

                    </div>
                    <div class="pull-right">
                       <a href="#" class="pull-left inline-block refresh mr-15">
                          <i class="zmdi zmdi-replay"></i>
                       </a>
                       <a href="#" class="pull-left inline-block full-screen mr-15">
                          <i class="zmdi zmdi-fullscreen"></i>
                       </a>
                       <div class="pull-left inline-block dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                          <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Edit</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Delete</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>New</a></li>
                          </ul>
                       </div>
                    </div>
                    <div class="clearfix"></div>
                 </div>

                 @if (!count($companybranches))

                    <hr>

                    <div class="panel-heading panel-heading-dark">
                        <div class="alert alert-danger text-center">
                            No records found
                        </div>
                    </div>

                 @else

                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row pa-0">
                          <div class="table-wrap">
                              <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                      <tr>
                                          <th width="5%">id</th>
                                          <th width="15%">Branch Name</th>
                                          <th width="15%">Company Name</th>
                                          <th width="10%">Manager</th>
                                          <th width="10%">Phone</th>
                                          <th width="15%">Email</th>
                                          <th width="15%">Created</th>
                                          <th width="15%">Actions</th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                      @foreach ($companybranches as $companybranch)
                                        <tr>
                                            <td>
                                              <span class="txt-dark weight-500">
                                                {{ $companybranch->id }}
                                              </span>
                                            </td>
                                            <td>
                                              <span class="txt-dark weight-500">
                                                {{ $companybranch->name }}
                                              </span>
                                            </td>
                                            <td>
                                              <span class="txt-dark weight-500">
                                                {{ $companybranch->company->name }}
                                              </span>
                                            </td>
                                            <td>
                                              <span class="txt-dark weight-500">
                                                @if ($companybranch->manager)
                                                  {{ $companybranch->manager->first_name }}
                                                  {{ $companybranch->manager->last_name }}
                                                @endif
                                              </span>
                                            </td>
                                            <td>
                                              <span class="txt-dark weight-500">
                                                {{ $companybranch->phone }}
                                              </span>
                                            </td>
                                            <td>
                                              <span class="txt-dark weight-500">
                                                {{ $companybranch->email }}
                                              </span>
                                            </td>
                                            <td>
                                              <span class="txt-dark weight-500">
                                              {{ formatFriendlyDate($companybranch->created_at) }}
                                              </span>
                                            </td>
                                            <td>

                                              <a href="{{ route('companybranches.show', $companybranch->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                                                <i class="zmdi zmdi-eye"></i>
                                              </a>

                                              <a href="{{ route('companybranches.edit', $companybranch->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                                                <i class="zmdi zmdi-edit"></i>
                                              </a>

                                              <a href="{{ route('companybranches.destroy', $companybranch->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
                                                <i class="zmdi zmdi-delete"></i>
                                              </a>

                                            </td>
                                        </tr>
                                      @endforeach

                                    </tbody>
                                </table>
                              </div>
                          </div>
                          <hr>
                          <div class="text-center">
                              {{ $companybranches->links() }}
                          </div>
                        </div>
                    </div>

                 @endif

              </div>
           </div>

        </div>
        <!-- Row -->

    </div>


@endsection
