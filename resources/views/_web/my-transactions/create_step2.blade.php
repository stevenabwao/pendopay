@extends('_web.layouts.master')

@section('title')
    Create New Transaction
    @if ($new_item_data['trans_message'])
     - {{ $new_item_data['trans_message'] }}
    @endif
@endsection

@section('page_title')
    Create New Transaction
    @if ($new_item_data['trans_message'])
     - {{ $new_item_data['trans_message'] }}
    @endif
@endsection

{{-- {{ dd($new_item_data) }} --}}

@section('page_breadcrumbs')
    {!! Breadcrumbs::render('my-transactions.create') !!}
@endsection


@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6" >

        <div class="card">

            <div class="card-body">

                <div class="row justify-content-center">
                    <img  class="" src="{{ asset('images/login_icon.png') }}" />
                    <br>

                    <p class="card-text">
                    </div>
                    <div class="row justify-content-center form-title">
                        <h3>Create New Transaction
                            @if ($new_item_data['trans_message'])
                            - {{ $new_item_data['trans_message'] }}
                            @endif
                        </h3>
                    </div>

                    <form action="{{ route('my-transactions.store') }}" class="form-box" method="post">

                        {{ csrf_field() }}

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ $new_item_data['title'] }}" name="title" disabled>
                            <label for="title">Transaction Title</label>
                        </div>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ $new_item_data['transaction_amount'] }}" name="transaction_amount" disabled>
                            <label for="transaction_amount">Transaction Amount</label>

                            @if ($errors->has('transaction_amount'))
                                <div class="help-block">
                                    <strong>{{ $errors->first('transaction_amount') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('user_id') }}"
                                class="form-control datepicker" name="user_id">
                            <label class="date" for="user_id">Enter User ID</label>
                            <div>
                                @if ($errors->has('user_id'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('user_id') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('phone') }}"
                                class="form-control datepicker" name="phone">
                            <label class="date" for="phone">Enter User Phone</label>
                            <div>
                                @if ($errors->has('phone'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="md-form mat-2 mx-auto">
                            <input type="text" value="{{ old('email') }}"
                                class="form-control datepicker" name="email">
                            <label class="date" for="email">Enter User Email</label>
                            <div>
                                @if ($errors->has('email'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="inputs row">
                            <button class="btn btn-xs" type="submit">Submit</button>
                        </div>
                        </form>

                </p>
            </div>
          </div>
        </div>
        </div>

    </div>

@endsection

@section('page_scripts')

    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>

    <script>
        $(document).ready(function(){

            $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true,
            toggleActive: true
            });

        });
    </script>

@endsection

@section('page_css')

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    {{-- datepicker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="{{ asset('css/datepicker_custom.css') }}">

@endsection
