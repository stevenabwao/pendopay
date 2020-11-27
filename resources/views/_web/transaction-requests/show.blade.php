@extends('_web.layouts.master')

@section('title')
    Transaction Request Show
@endsection

@section('page_title')
    Transaction Request Show
@endsection

@section('page_breadcrumbs')
   {{-- {!! Breadcrumbs::render('my-transactions.show', $transaction->id) !!} --}}
@endsection


@section('content')

{{ dd($transaction->created_by == getLoggedUser()->id) }}

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

                    @if($transaction->created_by == getLoggedUser()->id)

                        @if($transaction->status_id == getStatusPending())
                            <a href="{{ route('my-transactions.create') }}" class="btn btn-sm btn-block full-width-sm btn-white">
                                Resend Transaction Request To {{ titlecase(getTransactionPartnerRole($transaction)) }}
                            </a>

                            <hr>
                        @endif

                    @else

                        @if($transaction->status_id == getStatusPending())

                            <div class="alert alert-danger text-center">
                                You have not yet responded to this Transaction Request to become a {{ strtoupper(getTransactionRole($transaction)) }}. <br>
                                Please check your email or ask the {{ strtoupper(getTransactionPartnerRole($transaction)) }} to resend the request.
                            </div>

                        @endif

                    @endif

                    <p>
                        Lorem ipsum dolor sit amet consectetur adipiscing elitsed do eiusmod tempor incididunt utlabore et dolore magna aliqua.
                        Utenim ad minim veniam quis nostrud exercitation ullamco laboris. Lorem ipsum dolor sit amet consectetur adipiscing elitsed do eiusmod tempor incididunt utlabore et dolore magna aliqua.
                        nisi ut aliquip ex ea commodo consequat. Duis aute irure dolore.
                    </p>
                    <hr>

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

