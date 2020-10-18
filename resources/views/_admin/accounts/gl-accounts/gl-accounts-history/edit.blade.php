@extends('_admin.layouts.master')


@section('title')

    Edit User Savings Account - {{ $account->account_no }}

@endsection


@section('css_header')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection


@section('content')

    <div class="container-fluid">

      <!-- Title -->
       <div class="row heading-bg">
          <div class="col-lg-5 col-md-5 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Edit User Savings Account</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-lg-7 col-sm-7 col-md-8 col-xs-12">
              {!! Breadcrumbs::render('user-savings-accounts.edit', $account->account_no) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                <div  class="col-sm-12 col-md-8 col-md-offset-2">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">

                        <div class="panel panel-default card-view">

                           <div class="panel-wrapper collapse in">

                              <div class="panel-body">

                                 <div class="mb-30">
                                    <h3 class="text-center txt-dark mb-10">
                                        Edit User Savings Account - {{ $account->account_no }}
                                    </h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('user-savings-accounts.update', $account->id) }}">

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div  class="form-group{{ $errors->has('account_no') ? ' has-error' : '' }}">

                                          <label for="account_no" class="col-sm-3 control-label">
                                             Account No.
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="account_no"
                                                name="account_no"
                                                value="{{ old('account_no', $account->account_no)}}"
                                                required autofocus>

                                             @if ($errors->has('account_no'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('account_no') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('account_name') ? ' has-error' : '' }}">

                                          <label for="account_name" class="col-sm-3 control-label">
                                             Account Name
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="account_name"
                                                name="account_name"
                                                value="{{ old('account_name', $account->account_name)}}"
                                                required autofocus>

                                             @if ($errors->has('account_name'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('account_name') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <div  class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">

                                          <label for="company_id" class="col-sm-3 control-label">
                                             Company
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">

                                             <select class="selectpicker form-control"
                                                name="company_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($companies as $company)
                                                <li class="mb-10">
                                                <option value="{{ $company->id }}"

                                          @if ($company->id == old('company_id', $account->company->id))
                                              selected="selected"
                                          @endif
                                                    >
                                                      {{ $company->name }}
                                                    </option>
                                                </li>
                                                @endforeach

                                             </select>

                                             @if ($errors->has('company_id'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('company_id') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div>


                                        @if (count($account->company->groups))
                                       <div  class="form-group{{ $errors->has('group_id') ? ' has-error' : '' }}">

                                          <label for="group_id" class="col-sm-3 control-label">
                                             Group
                                          </label>
                                          <div class="col-sm-9">

                                             <select class="selectpicker form-control"
                                                name="group_id"
                                                data-style="form-control btn-default btn-outline"
                                                >

                                                @foreach ($account->company->groups as $group)
                                                <li class="mb-10">
                                                <option value="{{ $group->id }}"

                                          @if ($group->id == old('group_id', $account->group->id))
                                              selected="selected"
                                          @endif
                                                    >
                                                      {{ $group->name }}
                                                    </option>
                                                </li>
                                                @endforeach

                                             </select>

                                             @if ($errors->has('group_id'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('group_id') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div>
                                       @endif


                                       <div  class="form-group{{ $errors->has('product_id') ? ' has-error' : '' }}">

                                          <label for="product_id" class="col-sm-3 control-label">
                                             Product
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">

                                             <select class="selectpicker form-control"
                                                name="product_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($products as $product)
                                                <li class="mb-10">
                                                <option value="{{ $product->id }}"

                                          @if ($product->id == old('product_id', $account->product->id))
                                              selected="selected"
                                          @endif
                                                    >
                                                      {{ $product->name }}
                                                    </option>
                                                </li>
                                                @endforeach

                                             </select>

                                             @if ($errors->has('product_id'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('product_id') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div>


                                       <hr>

                                       <div  class="form-group{{ $errors->has('status_id') ? ' has-error' : '' }}">

                                          <label for="status_id" class="col-sm-3 control-label">
                                             Status
                                             <span class="text-danger"> *</span>
                                          </label>
                                          <div class="col-sm-9">

                                             <select class="selectpicker form-control"
                                                name="status_id"
                                                data-style="form-control btn-default btn-outline"
                                                required>

                                                @foreach ($statuses as $status)
                                                <li class="mb-10">
                                                <option value="{{ $status->id }}"

                                          @if ($status->id == old('status_id', $account->status->id))
                                              selected="selected"
                                          @endif
                                                    >
                                                      {{ $status->name }}
                                                    </option>
                                                </li>
                                                @endforeach

                                             </select>

                                             @if ($errors->has('status_id'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('status_id') }}</strong>
                                                  </span>
                                             @endif

                                          </div>

                                       </div>


                                       <hr>


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
