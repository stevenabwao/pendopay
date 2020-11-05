@extends('_web.layouts.master')

@section('title')

My-transactions

@endsection


@section('content')
<div class="row justify-content-center">
<div class="welcome col-md-10">
  <p class="pay">Hello {{ getLoggedUser()->first_name }}!
</div>
</div>

<div class="row justify-content-center">


  <div class="column col-md-3">

      <div class="card">
        <div class="row">
          <p class="pay">PendoPay Balance</p>
      </div>
      <div>
        <p class="value">KSH 50,000</p>
        <hr>
        <button class="btn-default" data-toggle="modal" data-target="#modalLoginForm" data-target="#myModal">Transfer Funds</button>

      </div>

    </div>
    <div class="card">
      <div class="row">
        <p class="pay">Request Payment</p>
    </div>
<!-- Search form -->

<div class="md-form mat-2 mx-auto">
  <input type="text"  aria-label="Search">
  <label for="example">Phone/ Email</label>
</div>
@if ($errors->has('email'))
  <div class="help-block">
      <strong>{{ $errors->first('email') }}</strong>
  </div>
@endif

<div class="md-form mat-2 mx-auto">
  <input type="text"  name="purpose">
  <label for="example">Purpose of payment</label>
</div>
@if ($errors->has('purpose'))
  <div class="help-block">
      <strong>{{ $errors->first('purpose') }}</strong>
  </div>
@endif

<div class="md-form mat-2 mx-auto">
  <input type="text" name="amount">
  <label for="example">Amount</label>
</div>
@if ($errors->has('email'))
  <div class="help-block">
      <strong>{{ $errors->first('email') }}</strong>
  </div>
@endif
<div class="md-form mat-2 mx-auto">

      <button class="btn-default">Request Funds</button>

    </div>

  </div>

  </div>
<div class="col-md-7" >
        <div class="inputs row">
          <div class="col-md-12">
          <a href="/new-transaction"><button class="btn btn-xs" type="submit">Create Transaction</button></a>
          </div>
        </div>

        <div class="card">

              <div class="row justify-content-center">
                     <div class="col-md-12" >

                               <div class="row">
                                <i class="fas fa-history fa-3x circle-icon" ></i>
                                <p class="pay">Recent Activity</p>
                               </div>
                               <div class="row">


                                   <div class="col-md-4">
                                    <strong>Payment received</strong>
                                    <p>payment date</p>
                                   </div>

                                   <div class="col-md-4">
                                    <strong>Purpose of payment</strong>
                                    <p>payment date</p>
                                   </div>

                                   <div class="col-md-4">
                                    <strong>Amount received</strong>
                                    <p>15,000</p>
                                   </div>
                               </div>

                               <div>
                                <p class="pay"><i class="fas fa-th-list"></i><a class="btn-link" href="{{ route('all-payments') }}"> view all activities</a></p>
                              </div>
                  </div>

        </div>
  </div>

<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="card">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="card-body">
          <div class="row justify-content-center">
              <img  class="" src="{{ asset('images/login_icon.png') }}" />
                <br>
                <p class="card-text">
          </div>
          <div class="row justify-content-center form-title">
              <h3>Transfer details</h3>
          </div>
    </div>


  </div>
</div>
</div>

@endsection


@section('page_css')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


@endsection
@section('page_scripts')

<!-- MDB core JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
@endsection
