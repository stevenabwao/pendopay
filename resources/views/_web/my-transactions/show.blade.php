@extends('_web.layouts.master')

@section('title')
    {{ $transaction->title }}
@endsection

@section('page_title')
    {{ $transaction->title }}
@endsection

@section('page_breadcrumbs')
   {!! Breadcrumbs::render('my-transactions.show', $transaction->id) !!}
@endsection


@section('content')

    <section class="section-base section-color">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Transaction details</h3>
                    <hr>

                    <div class="row">

                        <div class="col-lg-4 col-md-4 col-sm-5 no-margin-md align-right align-left-sm">
                            <hr class="space visible-xs" />
                            <div class="progress-circle" data-color="#03bfcb" data-thickness="5" data-progress="60"
                                data-size="185" data-size-sm="185" data-linecap="round" data-options="emptyFill:#004767">
                                <div class="content">
                                    <h4>Completed %</h4>
                                    <div class="counter" data-to="35" data-speed="2000" data-unit="%">35%</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-8 col-sm-7 no-margin-md align-right align-left-sm">
                            <hr class="space visible-xs" />
                            <div class="boxed-area light">
                                <ul class="text-list text-list-bold">
                                    <li><b>Transaction Title: </b><p>{{ $transaction->title }}</p></li>
                                    <li><b>Transaction Amount: </b><p>{{ $transaction->formatted_transaction_amount }}</p></li>
                                    <li><b>Transaction Status: </b><p>{!! showStatusText($transaction->status_id) !!}</p></li>
                                    <li><b>Estimated Trans Date: </b><p>{{ $transaction->formatted_transaction_date }}</p></li>
                                    <li><b>Your Transaction Role: </b><p>{{ $transaction->user_transaction_role }}</p></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <hr>

                    <p>
                        Lorem ipsum dolor sit amet consectetur adipiscing elitsed do eiusmod tempor incididunt utlabore et dolore magna aliqua.
                        Utenim ad minim veniam quis nostrud exercitation ullamco laboris. Lorem ipsum dolor sit amet consectetur adipiscing elitsed do eiusmod tempor incididunt utlabore et dolore magna aliqua.
                        nisi ut aliquip ex ea commodo consequat. Duis aute irure dolore.
                    </p>
                    <hr class="space" />
                    <h3>Analysis charts</h3>
                    <hr class="space-sm" />
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="progress-bar">
                                <h4>Returning customers</h4>
                                <div>
                                    <div data-progress="70">
                                        <span class="counter" data-to="70" data-speed="2000" data-unit="%">70%</span>
                                    </div>
                                </div>
                            </div>
                            <hr class="space-sm" />
                            <div class="progress-bar">
                                <h4>Success rate</h4>
                                <div>
                                    <div data-progress="95">
                                        <span class="counter" data-to="95" data-speed="2000" data-unit="%">95%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="progress-bar">
                                <h4>Success rate</h4>
                                <div>
                                    <div data-progress="95">
                                        <span class="counter" data-to="95" data-speed="2000" data-unit="%">95%</span>
                                    </div>
                                </div>
                            </div>
                            <hr class="space-sm" />
                            <div class="progress-bar">
                                <h4>Completed projects</h4>
                                <div>
                                    <div data-progress="85">
                                        <span class="counter" data-to="85" data-speed="2000" data-unit="%">85%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <hr class="space visible-sm" />
                    <div class="fixed-area" data-offset="80">
                        <div class="menu-inner menu-inner-vertical boxed-area">

                            <p>
                                fff
                            </p>

                            <p>
                                fff
                            </p>

                            <p>
                                fff
                            </p>

                            <p>
                                fff
                            </p>

                            <p>
                                fff
                            </p>

                            <p>
                                fff
                            </p>

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
            </div>
        </div>
    </section>

@endsection

