@extends('_admin.layouts.master')

@section('title')
    Confirm Till - {{ $till->id }}
@endsection

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('admin.tills.confirm-till-create', $till->id) !!}
@endsection

@section('css_header')
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">
@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Confirm Till - {{ $till->id }}</h5>
          </div>

          @include('_admin.layouts.partials.breadcrumbs')

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
                                    <h3 class="text-center txt-dark mb-10">Confirm Till</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('admin.tills.confirm-till-store') }}">

                                       {{ csrf_field() }}

                                        <div  class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">

                                            <label for="id" class="col-sm-3 control-label">
                                                ID
                                            </label>
                                            <div class="col-sm-9">
                                            <input
                                                type="text" readonly
                                                class="form-control"
                                                id="id"
                                                name="id"
                                                value="{{ $till->id }}">
                                            </div>
                                        </div>

                                        <div  class="form-group{{ $errors->has('till_number') ? ' has-error' : '' }}">

                                            <label for="till_number" class="col-sm-3 control-label">
                                                Till No.
                                            </label>
                                            <div class="col-sm-9">
                                            <input
                                                type="text" readonly
                                                class="form-control"
                                                id="till_number"
                                                name="till_number"
                                                value="{{ $till->till_number }}">
                                            </div>
                                        </div>

                                        <div  class="form-group{{ $errors->has('till_name') ? ' has-error' : '' }}">

                                            <label for="till_name" class="col-sm-3 control-label">
                                                Till Name
                                            </label>
                                            <div class="col-sm-9">
                                            <input
                                                type="text" readonly
                                                class="form-control"
                                                id="till_name"
                                                name="till_name"
                                                value="{{ $till->till_name }}">
                                            </div>
                                        </div>

                                        <div  class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                            <label for="phone_number" class="col-sm-3 control-label">
                                                Phone Number
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">
                                            <input
                                                type="text" readonly
                                                class="form-control"
                                                id="phone_number"
                                                name="phone_number"
                                                value="{{ $till->phone_number }}">
                                            </div>
                                        </div>

                                        <div  class="form-group{{ $errors->has('confirm_code') ? ' has-error' : '' }}">

                                            <label for="confirm_code" class="col-sm-3 control-label">
                                                Confirm Code
                                            <span class="text-danger"> *</span>
                                            </label>
                                            <div class="col-sm-9">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="confirm_code"
                                                name="confirm_code"
                                                value="{{ old('confirm_code') }}">
                                            </div>
                                        </div>

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

@endsection
