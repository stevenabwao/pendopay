@extends('_web.layouts.master')

@section('title')
    My Transactions
@endsection

@section('page_title')
    My Transactions
@endsection

@section('page_breadcrumbs')
   {!! Breadcrumbs::render('admin.establishments') !!}
@endsection


@section('content')

    <section class="section-base section-color">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="fixed-area" data-offset="80">
                        <div class="menu-inner menu-inner-vertical boxed-area">
                            <ul>
                                <li class="active"><a href="service-1.html">Security audits</a></li>
                                <li><a href="service-2.html">Artificial intelligence</a></li>
                                <li><a href="service-3.html">Bots and support</a></li>
                                <li><a href="#">Financial advises</a></li>
                            </ul>
                        </div>
                        <hr class="space-sm" />
                        <div class="boxed-area light">
                            <ul class="text-list text-list-bold">
                                <li><b>Address:</b><p>139 Baker St, E17PT, London</p></li>
                                <li><b>Email:</b><p>support@example.com</p></li>
                                <li><b>Phone line:</b><p>(02) 123 333 444</p></li>
                                <li><b>Opening hours</b><p>8am-5pm Mon - Fri</p></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <hr class="space visible-md" />

                    <div class="row">
                        <div class="col-sm-6"><h3>Recent Activity</h3></div>
                        <div class="col-sm-6">
                            <a href="#" class="btn btn-sm btn-icon full-width-sm"><i class="fa fa-plus"></i>Create New Transaction</a>
                        </div>
                    </div>

                    <hr class="space-sm" />
                    <div class="menu-inner menu-inner-vertical menu-inner-image">
                        <ul>
                            <li>
                                <a href="#">
                                    <img src="media/square-1.jpg" alt="" />
                                    <span>Feb 12, 2020</span>
                                    Sale of Lexus motor vehicle KDA 001B
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="media/square-2.jpg" alt="" />
                                    <span>February 25, 2020</span>
                                    Six best practices for using artificial intelligence data
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="media/square-3.jpg" alt="" />
                                    <span>April 19, 2020</span>
                                    Machine learning and AI are raising concerns
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="media/square-4.jpg" alt="" />
                                    <span>April 20, 2020</span>
                                    Commodity traders turn to long as big oil fail more then expected
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

