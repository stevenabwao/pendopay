@extends('_web.layouts.master')

@section('title')

{{ getLoggedUser()->first_name }} all payments
@endsection


@section('content')
<div class="row justify-content-center">
    <div class="col-md-10" >


<div class="card">
              

                 <div class="col-md-12" >

                           <div class="row">
                            <i class="fas fa-history fa-3x circle-icon" ></i>
                            <p class="pay">Your Activities</p>
                           </div>
                           <div>
                        <div class="inputs row">
                           <div class="col-md-12">
                             
                            </div>
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