@extends('_web.layouts.master')

@section('title')

My-Payments

@endsection


@section('content')


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
      <p class="pay">Make Payment</p>
  </div>
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
        
        <button class="btn-default">Make payment</button>
  
      </div>
  
</div>
      
  </div>
<div class="col-md-7" >


        <div class="card1">
                  
              <div class="row justify-content-center">
                     <div class="col-md-12" >

                               <div class="row">
                                
                                <p class="pay">Payment history</p>
                               </div>
                               <div class="row">

                                
                                   <div class="col-md-2">
                                    <strong>Date</strong>
                                    <p>payment date</p>
                                   </div>
                                   <div class="col-md-2">
                                    <strong>Type</strong>
                                    <p>received/sent</p>
                                   </div>
                                   <div class="col-md-2">
                                    <strong>Purpose</strong>
                                    <p>payment date</p>
                                   </div>

                                   <div class="col-md-2">
                                    <strong>Amount</strong>
                                    <p>15,000</p>
                                   </div>
                                   <div class="col-md-2">
                                    <strong>status</strong>
                                    <p>active/canceled/completed</p>
                                   </div>

                               </div>
                   
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

@endsection