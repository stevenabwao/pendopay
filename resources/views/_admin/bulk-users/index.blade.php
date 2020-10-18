@extends('_admin.layouts.master')

@section('title')

    Manage Users

@endsection


@section('content')

    <div class="container-fluid">

		<!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Manage Users</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
	            <a href="{{ route('users.create') }}" class="btn btn-primary btn-icon right-icon pull-right">
	            	<span>Create New User</span>
	            	<i class="zmdi zmdi-account-add"></i>
	            </a>
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
                       <h6 class="panel-title txt-dark"></h6>
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
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body row pa-0">
                       <div class="table-wrap">
                          <div class="table-responsive">
                             <table class="table table-hover mb-0">
                                <thead>
                                   <tr>
                                      <th>Acct. No.</th>
                                      <th>Full Names</th>
                                      <th>Role</th>

                                      @if (Auth::user()->hasRole('superadministrator'))
                                      <th>Company</th>
                                      @endif

                                      <th>Phone</th>
                                      <th>Email</th>
                                      <th>Created</th>
                                      <th width="150">Actions</th>
                                   </tr>
                                </thead>
                                <tbody>

                                   @foreach ($users as $user)
	                                   <tr>
	                                      <td>
	                                      	<span class="txt-dark weight-500">
	                                      		{{ $user->account_number }}
	                                      	</span>
	                                      </td>
	                                      <td>
                                          <span class="txt-dark weight-500">
                                            {{ $user->first_name }} &nbsp; {{ $user->last_name }}
                                          </span>
                                        </td>
                                        <td>
                                          <span class="txt-dark weight-500">
                                              @foreach ($user->roles as $role)
                                                <span>{{ $role->name }}</span>
                                              @endforeach
                                          </span>
                                        </td>

                                        @if (Auth::user()->hasRole('superadministrator'))
                                        <td>
                                          @if ($user->company)
                                          <span class="txt-dark weight-500">
                                              {{ $user->company->name }}
                                          </span>
                                          @endif
                                        </td>
                                        @endif

	                                      <td>
                                           <span class="txt-dark weight-500">
                                            {{ $user->phone_number }}
                                           </span>
                                        </td>
                                        <td>
                                           <span class="txt-dark weight-500">
                                            {{ $user->email }}
                                           </span>
                                        </td>
	                                      <td>
	                                         <span class="txt-dark weight-500">
	                                         	{{ $user->created_at->toFormattedDateString() }}
	                                         </span>
	                                      </td>
	                                      <td>
	                                         <!-- <span class="label label-primary">Active</span> -->
	                                         <!-- <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline btn-primary btn-icon right-icon pull-right">
								            	<span>Edit</span>
								            	<i class="zmdi zmdi-account-add"></i>
								             </a> -->

								             <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm btn-icon-anim btn-square">
                              <i class="zmdi zmdi-eye"></i>
                             </a>

                             <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm btn-icon-anim btn-square">
                              <i class="zmdi zmdi-edit"></i>
                             </a>

								             <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm btn-icon-anim btn-square">
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
							{{ $users->links() }}
                       </div>
                    </div>
                 </div>
              </div>
           </div>

           <!-- <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
              <div class="panel panel-default card-view panel-refresh">
                 <div class="refresh-container">
                    <div class="la-anim-1"></div>
                 </div>
                 <div class="panel-heading">
                    <div class="pull-left">
                       <h6 class="panel-title txt-dark">User Statistics</h6>
                    </div>
                    <div class="pull-right">
                       <a href="#" class="pull-left inline-block refresh mr-15">
                          <i class="zmdi zmdi-replay"></i>
                       </a>
                       <div class="pull-left inline-block dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                          <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>option 1</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>option 2</a></li>
                             <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>option 3</a></li>
                          </ul>
                       </div>
                    </div>
                    <div class="clearfix"></div>
                 </div>
                 <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                       <div>
                          <canvas id="chart_2" height="253"></canvas>
                       </div>
                       <div class="label-chatrs mt-30">
                          <div class="inline-block mr-15">
                             <span class="clabels inline-block bg-yellow mr-5"></span>
                             <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Active</span>
                          </div>
                          <div class="inline-block mr-15">
                             <span class="clabels inline-block bg-red mr-5"></span>
                             <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Closed</span>
                          </div>
                          <div class="inline-block">
                             <span class="clabels inline-block bg-green mr-5"></span>
                             <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Hold</span>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>   -->

        </div>
        <!-- Row -->

    </div>


@endsection
