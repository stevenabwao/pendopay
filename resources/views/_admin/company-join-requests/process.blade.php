@extends('_admin.layouts.master')

@section('title')

    Process Join Request - {{ $companyjoinrequest->id }}

@endsection

@section('css_header')

    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css">

@endsection

@section('page_css')

    <link href="{{ asset('css/parsley.css') }}" rel="stylesheet">

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Process Company Join Request - {{ $companyjoinrequest->id }}</h5>
          </div>
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('company-join-requests.process', $companyjoinrequest->id) !!}
          </div>
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
                                    <h3 class="text-center txt-dark mb-10">Process Company Join Request - {{ $companyjoinrequest->id }}</h3>
                                 </div>

                                 <hr>

                                 <div class="form-wrap">

                                    <form class="form-horizontal" method="POST"
                                        action="{{ route('company-join-requests.process', $companyjoinrequest->id) }}"  data-parsley-validate>

                                       {{ method_field('PUT') }}
                                       {{ csrf_field() }}

                                       <div  class="form-group">

                                          <label for="user_id" class="col-sm-4 control-label">
                                             Full Name
                                          </label>
                                          <div class="col-sm-8">
                                             <input class="form-control"
                                             value="{{ $companyjoinrequest->user->first_name }}  {{ $companyjoinrequest->user->last_name }}"
                                             readonly>
                                          </div>

                                       </div>

                                       <div  class="form-group">

                                          <label for="phone" class="col-sm-4 control-label">
                                             Phone
                                          </label>
                                          <div class="col-sm-8">
                                             <input class="form-control"
                                             value="{{ $companyjoinrequest->user->phone }}"
                                             readonly>
                                          </div>

                                       </div>

                                       <div  class="form-group">

                                          <label for="company_id" class="col-sm-4 control-label">
                                             Company Name
                                          </label>
                                          <div class="col-sm-8">
                                             <input class="form-control" value="{{ $companyjoinrequest->company->name }}" readonly>
                                          </div>

                                       </div>

                                       <div  class="form-group">

                                          <label for="company_id" class="col-sm-4 control-label">
                                             Created At
                                          </label>
                                          <div class="col-sm-8">
                                             <input class="form-control" value="{{ formatFriendlyDate($companyjoinrequest->created_at) }}" readonly>
                                          </div>

                                       </div>

                                       <div  class="form-group">

                                          <label for="status_id" class="col-sm-4 control-label">
                                             Status
                                          </label>
                                          <div class="col-sm-8">
                                             <input class="form-control" value="{{ $companyjoinrequest->status->name }}" readonly>
                                          </div>

                                       </div>

                                       <hr>

                                       <div  class="form-group{{ $errors->has('comments') ? ' has-error' : '' }}">

                                          <label for="comments" class="col-sm-4 control-label">
                                             Comments
                                          </label>
                                          <div class="col-sm-8">
                                            <textarea
                                                rows="4"
                                                class="form-control"
                                                id="comments"
                                                name="comments">{{ old('comments') }}</textarea>

                                             @if ($errors->has('comments'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('comments') }}</strong>
                                                  </span>
                                             @endif
                                          </div>

                                       </div>

                                       <hr/>

                                       <div class="form-group">
                                          <div class="col-sm-4"></div>
                                          <div class="col-sm-8">
                                              <div class="col-sm-6">
                                                <button
                                                  type="submit"
                                                  class="btn btn-lg btn-success btn-block mr-10"
                                                   id="submit-btn">
                                                   Approve Request
                                                </button>
                                              </div>
                                              <div class="col-sm-6">
                                                <button
                                                  type="submit"
                                                  class="btn btn-lg btn-danger btn-block mr-10"
                                                   id="submit-btn2">
                                                   Decline Request
                                                </button>
                                              </div>

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
  <script src="{{ asset('js/parsley.js') }}"></script>

@endsection
