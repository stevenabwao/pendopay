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
                                    <div class="text-lg text-amount-big">Ksh 9,999</div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class=" walet">
                                    <a href="#" class="btn btn-sm btn-border full-width btn-block"><i class="fa fa-dollar"></i> Transfer Funds</a>
                                </div>
                                <div class="walet">
                                    <a href="#" class="btn btn-sm btn-border full-width btn-block">
                                        <i class="fa fa-money-bill-wave-alt"></i> Deposit Funds</a>
                                </div>
                                
                            </div>

                            

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

                            @if (count($transactions))

                                @foreach ($transactions as $transaction)

                                    <div class="grid-item">
                                        <div class="cnt-boxz cnt-box-blog-side boxedz" data-href="{{ $transaction->url }}">
                                            <div class="caption2">
                                                <h3>{{ $transaction->title }}</h3>
                                                <ul class="icon-list icon-list-horizontal">
                                                    <li>
                                                        <i class="icon-calendar"></i>
                                                        <a href="{{ $transaction->url }}">
                                                            {{ $transaction->formatted_transaction_date }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <i class="icon-bookmark"></i>
                                                        <a href="#">
                                                            {{ $transaction->user_transaction_role }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <i class="icon-user"></i>
                                                        <a href="{{ $transaction->url }}">
                                                            {{ $transaction->formatted_transaction_amount }}
                                                        </a>
                                                    </li>
                                                    <li class="text-success">
                                                        <i class="fa fa-thumbs-up"></i>
                                                        {!! showStatusText($transaction->status_id) !!}
                                                        ({{ getMyTransactionMessage($transaction) }})
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                @endforeach

                            @else

                                No Transactions

                            @endif

                            {{-- pagination --}}
                            {{ $transactions->links() }}

                        </div>

                    </div>



                </div>
            </div>
        </div>
    </section>

@endsection

