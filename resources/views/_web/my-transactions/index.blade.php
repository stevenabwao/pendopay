@extends('_web.layouts.master')

@section('title')
    My Transactions
@endsection

@section('page_title')
    {!! getLoggedUser()->first_name !!} 
@endsection

@section('page_breadcrumbs')
   {!! Breadcrumbs::render('my-transactions.index') !!}
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
                                    <div class="text-lg">Ksh 9,999</div>
                                </div>
                            </div>

                            <hr>

                            <a href="#" class="btn btn-sm btn-border full-width-sm btn-block"><i class="fa fa-money"></i> Transfer Funds</a>

                        </div>
                        <hr class="space-sm" />

                    </div>

                </div>
                <div class="col-lg-7 no-guttersz">



                    <div class="grid-list equalheight" data-columns="1">

                        <div class="row">
                            <div class="col-lg-6"><h3>RECENT TRANSACTIONS</h3></div>
                            <div class="col-lg-6 no-gutters">
                                <a href="{{ route('my-transactions.create') }}" class="btn btn-sm btn-icon full-width-sm">
                                    <i class="fa fa-plus"></i>Create New Transaction
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
                                            <li><i class="icon-bookmark"></i><a href="#">SELLER</a></li>
                                            <li><i class="icon-user"></i><a href="#">KES 2,000,000</a></li>
                                            <li class="text-success"><i class="fa fa-thumbs-up"></i> COMPLETED</li>
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
                                            <li><i class="icon-bookmark"></i><a href="#">BUYER</a></li>
                                            <li><i class="icon-user"></i><a href="#">KES 2,000,000</a></li>
                                            <li class="text-danger"><i class="fa fa-thumbs-up"></i> PENDING</li>
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
                                            <li><i class="icon-bookmark"></i><a href="#">SELLER</a></li>
                                            <li><i class="icon-user"></i><a href="#">KES 2,000,000</a></li>
                                            <li class="text-danger"><i class="fa fa-thumbs-up"></i> PENDING</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <a href="#" class="btn btn-sm btn-border full-width-sm btn-block"><i class="fa fa-plus"></i> View All Transactions</a>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

