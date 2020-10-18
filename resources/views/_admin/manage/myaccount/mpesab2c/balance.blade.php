@extends('_admin.layouts.master')

@section('title')

    Showing MpesaB2c Balance - {{ $mpesashortcodedata->shortcode_number }}

@endsection


@section('content')

    <div class="container-fluid">

       <!-- Title -->
       <div class="row heading-bg">
          <div class="col-sm-6 col-xs-12">
            <h5 class="txt-dark">Showing MpesaB2c Balance - {{ $mpesashortcodedata->shortcode_number }}</h5>
          </div>
          <!-- Breadcrumb -->
          <div class="col-sm-6 col-xs-12">
              {!! Breadcrumbs::render('loansettings.show', $mpesabalancedata->id) !!}
          </div>
          <!-- /Breadcrumb -->
       </div>
       <!-- /Title -->

    </div>

    <div class="container-fluid">


      <!-- Row -->
       <div class="table-struct full-width full-height">
          <div class="table-cell auth-form-wrap-inner">
             <div class="ml-auto mr-auto no-float">

                <div  class="col-sm-12">

                  <div class="row">
                     <div class="col-sm-12 col-xs-12">

                        <div class="panel panel-default card-view">

                           <div class="panel-wrapper collapse in">

                              <div class="panel-body">

                                 <div class="form-wrap">

                                        <br/>

                                        <div class="row">

                                            <div class="col-lg-8 col-md-offset-2">

                                                <div class="uppercase-font weight-500 font-14 block text-center txt-dark mb-10">
                                                    <span class="text-primaryk">{{ $mpesacompanydata->name }}</span>
                                                </div>

                                                <div class="uppercase-font weight-400 font-14 block text-center txt-dark mb-10">
                                                    Shortcode: {{ $mpesashortcodedata->shortcode_number }}
                                                </div>

                                                <div class="uppercase-font weight-400 font-14 block text-center txt-dark">
                                                    Phone: {{ $mpesacompanydata->phone }}
                                                </div>

                                            </div>

                                        </div>

                                        <hr>

                                        <div class="row">

                                            <div class="col-lg-8 col-md-offset-2">

                                                <div class="panel panel-default card-view">
                                                    <div class="panel-wrapper collapse in">
                                                        <div class="panel-body sm-data-box-1">
                                                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">Mpesa B2C Balance</span>
                                                            <div class="cus-sat-stat weight-500 txt-success text-center mt-5">
                                                                <span>{{ formatCurrency($mpesabalancedata->utility_bal) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>


                                        <hr>

                                          {{-- <div class="box-footer">
                                            <a href="{{ route('mpesabalancedatas.edit', $mpesabalancedata->id) }}" class="btn btn-primary pull-right">
                                              <i class="zmdi zmdi-edit"></i> &nbsp;&nbsp; Edit Settings
                                           </a>
                                          </div> --}}

                                      </div>
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

