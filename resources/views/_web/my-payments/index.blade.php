@extends('_web.layouts.master')

@section('title')
    My payments
@endsection

@section('page_title')
    {!! getLoggedUser()->first_name !!} 
@endsection

@section('page_breadcrumbs')
   {!! Breadcrumbs::render('my-payments.index') !!}
@endsection


@section('content')

    <section class="section-base section-color">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">

                    <div class="fixed-area" data-offset="80">
                        <div class="menu-innerz menu-inner-vertical boxed-area text-center equalheight">

                            <h3 style="margin-bottom: 1rem;">MY WALLET </h3>
                            <hr>

                            <div class="row">
                                {{-- <div class="col-lg-3">
                                    <i class="im-coins text-lg"></i>
                                </div> --}}
                                <div class="col-lg-12">
                                    <div class="text-lg text-amount-big">Ksh 9,999</div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class=" walet">
                                    <a href="#" class="btn btn-sm btn-border full-width btn-block"><i class="fa fa-dollar"></i> Transfer Funds</a>
                                </div>
                                <div class="walet">
                                    <a href="#" class="btn btn-sm btn-border full-width btn-block"  
                                    data-toggle="modal" data-target="#modalSubscriptionForm">
                                        <i class="fa fa-money-bill-wave-alt" data-toggle="modal" data-target="#myModal"></i> Deposit Funds</a>
                                </div>
                                
                            </div>

                 
                        </div>
                        <hr class="space-sm" />

                    </div>

                </div>

       <div class="col-lg-7 no-guttersz">



                    <div class="grid-list equalheight" data-columns="1">

                        <div class="row">
                            <div class="col-lg-6"><h3>MY PAYMENTS</h3></div>
                            <div class="col-lg-6 no-gutters">
                                <a href="{{ route('my-transactions.create') }}" class="btn btn-sm btn-icon full-width-sm">
                                    <i class="fa fa-plus"></i>Make New Payment
                                </a>
                            </div>
                        </div>

                        <hr>

                        <div class="grid-box">

                            <div class="grid-item">
                                <div class="cnt-boxz cnt-box-blog-side boxedz" data-href="#">
                                    <div class="caption2">
                                        <h3>Sale of Lexus motor vehicle KDA 001B motor vehicle KDA 001B</h3>
                                        <ul class="icon-list icon-list-horizontal">
                                            <li><i class="icon-calendar"></i><a href="#">15-Dec-2020</a></li>
                                            <li><i class="icon-bookmark"></i><a href="#">SENT</a></li>
                                            <li><i class="icon-user"></i><a href="#">KES 2,000,000</a></li>
                                            <li class="text-success"><i class="fa fa-eye"></i> VIEW</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="grid-item">
                                <div class="cnt-boxz cnt-box-blog-side boxedz" data-href="#">
                                    <div class="caption2">
                                        <h3>Sale of Lexus motor vehicle KDA 001B motor vehicle KDA 001B</h3>
                                        <ul class="icon-list icon-list-horizontal">
                                            <li><i class="icon-calendar"></i><a href="#">15-Dec-2020</a></li>
                                            <li><i class="icon-bookmark"></i><a href="#">RECEIVED</a></li>
                                            <li><i class="icon-user"></i><a href="#">KES 2,000,000</a></li>
                                            <li class="text-success"><i class="fa fa-eye"></i> VIEW</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="grid-item">
                                <div class="cnt-boxz cnt-box-blog-side boxedz" data-href="#">
                                    <div class="caption2">
                                        <h3>Sale of Lexus motor vehicle KDA 001B motor vehicle KDA 001B</h3>
                                        <ul class="icon-list icon-list-horizontal">
                                            <li><i class="icon-calendar"></i><a href="#">15-Dec-2020</a></li>
                                            <li><i class="icon-bookmark"></i><a href="#">RECEIVED</a></li>
                                            <li><i class="icon-user"></i><a href="#">KES 2,000,000</a></li>
                                            <li class="text-success"><i class="fa fa-eye"></i> VIEW</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <hr>

                          
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modalSubscriptionForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header text-center">
              <h4 class="modal-title w-100 font-weight-bold">Subscribe</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body mx-3">
              <div class="md-form mb-5">
                <i class="fas fa-user prefix grey-text"></i>
                <input type="text" id="form3" class="form-control validate">
                <label data-error="wrong" data-success="right" for="form3">ENTER AMOUNT</label>
              </div>
      
      
            </div>
            <div class="modal-footer d-flex justify-content-center">
              <button class="btn btn-success">deposit <i class="fas fa-paper-plane-o ml-1"></i></button>
            </div>
          </div>
        </div>
      </div>
      


    </section>

@endsection

{{-- @section('page_scripts')

<!-- MDB core JavaScript -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection

@section('page_css')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

@endsection --}}