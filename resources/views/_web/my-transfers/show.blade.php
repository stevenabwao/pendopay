@extends('_web.layouts.master')

@section('title')
    Transfer details - {{ $transfer->destination_account_name }}
@endsection

@section('page_title')
    Transfer details - {{ $transfer->destination_account_name }}
@endsection

@section('page_breadcrumbs')
   {!! Breadcrumbs::render('my-transfers.show', $transfer->id) !!}
@endsection


@section('content')

    <section class="section-base section-color">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    {{-- <h3>Transfer details - {{ $transfer->destination_account_name }}</h3>
                     --}}

                    {{-- <hr> --}}

                    @if($transfer->comments)

                        <p>{!! $transfer->comments !!}</p>
                        <hr>

                    @endif

                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-6 no-margin-md align-right align-left-sm">

                            <hr class="space visible-xs" />
                            <div class="boxed-area light equalheight">
                                <table width="100%" class="">

                                    <tr>
                                        <td align="left"><b>Transfer Amount: </b></td>
                                        <td align="left"><p>{{ $transfer->formatted_transfer_amount }}</p></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left"><b>Source Account Type: </b></td>
                                        <td width="50%" align="left"><p>{{ $transfer->source_account_type }}</p></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left"><b>Source Account Name: </b></td>
                                        <td width="50%" align="left"><p>{{ $transfer->source_account_name }}</p></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left"><b>Source Account No: </b></td>
                                        <td width="50%" align="left"><p>{{ $transfer->source_account_no }}</p></td>
                                    </tr>


                                </table>

                            </div>

                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 no-margin-md align-right align-left-sm">
                            <hr class="space visible-xs" />
                            <div class="boxed-area light equalheight">
                                <table width="100%" class="">

                                    <tr>
                                        <td width="50%" align="left"><b>Destination Account Type: </b></td>
                                        <td width="50%" align="left"><p>{{ $transfer->destination_account_type }}</p></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left"><b>Destination Account Name: </b></td>
                                        <td width="50%" align="left"><p>{{ $transfer->destination_account_name }}</p></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" align="left"><b>Destination Account No: </b></td>
                                        <td width="50%" align="left"><p>{{ $transfer->destination_account_no }}</p></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><b>Transfer Status: </b></td>
                                        <td align="left"><p>{!! showStatusText($transfer->status_id) !!}</p></td>
                                    </tr>
                                    <tr>
                                        <td align="left"><b>Transfer Date: </b></td>
                                        <td align="left"><p>{{ $transfer->created_at }}</p></td>
                                    </tr>

                                </table>

                            </div>
                        </div>

                    </div>
                    <hr>

                </div>

            </div>
        </div>
    </section>

@endsection

