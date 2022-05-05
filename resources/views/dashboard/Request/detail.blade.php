@extends('dashboard.app')


@section('content_head')

<style>

 body {
    color: #000;
    overflow-x: hidden;
    height: 100%;
    background-color: #8C9EFF;
    background-repeat: no-repeat
}

.card {
    z-index: 0;
    background-color: #ECEFF1;
    padding-bottom: 20px;
    margin-top: 90px;
    margin-bottom: 90px;
    border-radius: 10px
}

.top {
    padding-top: 40px;
    padding-left: 13% !important;
    padding-right: 13% !important
}

#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: #455A64;
    padding-left: 0px;
    margin-top: 30px
}

#progressbar li {
    list-style-type: none;
    font-size: 13px;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400
}

#progressbar .step0:before {
    font-family: FontAwesome;
    content: "\f10c";
    color: #fff
}

#progressbar li:before {
    width: 40px;
    height: 40px;
    line-height: 45px;
    display: block;
    font-size: 20px;
    background: #C5CAE9;
    border-radius: 50%;
    margin: auto;
    padding: 0px
}

#progressbar li:after {
    content: '';
    width: 100%;
    height: 8px;
    background: #C5CAE9;
    position: absolute;
    left: 0;
    top: 16px;
    z-index: -1
}

#progressbar li:last-child:after {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    position: absolute;
    left: -50%
}

#progressbar li:nth-child(2):after,
#progressbar li:nth-child(3):after {
    left: -50%
}

#progressbar li:first-child:after {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    position: absolute;
    left: 50%
}

#progressbar li:last-child:after {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px
}

#progressbar li:first-child:after {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px
}

#progressbar li.active:before,
#progressbar li.active:after {
    background: #5cb85c
}

#progressbar li.active:before {
    font-family: FontAwesome;
    content: "\f00c"
}

.icon {
    width: 30px;
    height: 30px;
    margin-right: 15px
}

.icon-content {
    padding-bottom: 20px
}

@media screen and (max-width: 992px) {
    .icon-content {
        width: 50%
    }
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@endsection

@section('title')
Requests
@endsection

@section('content')
<body class="bg-theme bg-theme1">
 
<!-- Start wrapper-->
 <div id="wrapper">
 
  <!--Start sidebar-wrapper-->
  
@include('dashboard.header')


<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid" id="table-container">

  <!--Start Dashboard Content-->
  <div class="container-xl">
  <div class="table-responsive">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2>{{ __('dashboard.Request') }}</h2>
             @if($bills->bil_status ==! 0 ) 
<h6>{{ __('dashboard.Request') }} : {{ $bills->bil_id }}</h6>
<h6> {{$bills->bil_regdate}}</h6>
          </div>
      
        </div>
      </div>
      <br><br><br>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
         
            <th>{{ __('dashboard.product') }}</th>
            <th>{{ __('dashboard.Price') }}</th>
            <th>{{ __('dashboard.Amount') }}</th>
          </tr>
        </thead>
        <tbody class="cont-data">
        @foreach ($detailBills as $item)
            
          <tr>
         
            <td>{{$item->product->foo_name}}</td>
            <td>{{$item->det_price}}</td>
            <td>{{$item->det_qty}}</td>
            
           
          </tr>
       @endforeach
   

        </tbody>
      </table>
      @endif
      <br><br><br>
    <h5> {{__('dashboard.Request_status')}} : <h5> 
 

{{-- <div class="tracking">
        <div class="title">Tracking Order</div>
    </div>
    <div class="progress-track">
        <ul id="progressbar">
            <li class="step0 active " id="step1">Ordered</li>
            @if($bills->bill_status == 2 ) 
            <li class="step0 active text-center" id="step2">Shipped</li>
            <li class="step0  text-right" id="step3">On the way</li>
            <li class="step0  text-right" id="step4">Delivered</li>
            @endif
            
            
             @if($bills->bill_status == 1 ) 
             <li class="step0 active  text-center" id="step2">Shipped</li>
            <li class="step0 active text-right" id="step3">On the way</li>
            <li class="step0  text-right" id="step4">Delivered</li>
              @endif
            
             @if($bills->bill_status == 0 ) 
            <li class="step0 active  text-center" id="step2">Shipped</li>
            <li class="step0 active text-right" id="step3">On the way</li>
            <li class="step0 active text-right" id="step4">Delivered</li>
              @endif
        </ul>
    </div> --}}
 
  <div class="row d-flex justify-content-center">
            <div class="col-12">
                <ul id="progressbar" class="text-center">
                    <li class="active step0"></li>
                     @if($bills->bil_status == 2 ) 
                    <li class="active step0"></li>
                    <li class=" step0"></li>
                    <li class="step0"></li>
                     @endif
                     @if($bills->bil_status == 1 )
                    <li class="active step0"></li>
                    <li class="active step0"></li>
                    <li class="step0"></li>
                    @endif
                    @if($bills->bil_status == 0 ) 
                    <li class="active step0"></li>
                    <li class="active step0"></li>
                    <li class="active step0"></li>
                     @endif
                </ul>
            </div>
        </div>

        <div class="row justify-content-between top">
            <div class="row d-flex icon-content">@if($bills->bil_status ==! 0 )  <img class="icon" src="https://i.imgur.com/9nnc9Et.png"> 
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">{{ __('dashboard.Order') }}<br>{{ __('dashboard.Processed') }}</p>
                </div> @endif
            </div>
            <div class="row d-flex icon-content">@if($bills->bil_status ==! 0 ) <img class="icon" src="https://i.imgur.com/u1AzR7w.png">
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">{{ __('dashboard.Order') }}<br>{{ __('dashboard.Shipped') }}</p>
                </div> @endif
            </div>
            <div class="row d-flex icon-content">@if($bills->bil_status ==! 0 ) <img class="icon" src="https://i.imgur.com/TkPm63y.png">
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">{{ __('dashboard.Order') }}<br>{{ __('dashboard.En Route') }}</p>
                </div>@endif
            </div>
            <div class="row d-flex icon-content"> <img class="icon" src="https://i.imgur.com/HdsziHP.png">
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">{{ __('dashboard.Order') }}<br>{{ __('dashboard.Arrived') }}</p>
                </div>
            </div>
        </div>
  

<br><br><br>
  @if($bills->bil_status ==! 0 ) 
<table class="table table-bordered table-active">
  <thead>
    <tr>
         </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">{{ __('dashboard.Customer_name') }} :</th>
      <td>{{$bills->customer->cus_name}}</td>
      <td>{{ __('dashboard.Customer_phone') }} :</td>
      <td>{{$bills->customer->cus_mobile}}</td>
    </tr>
    <tr>
      <th scope="row">{{ __('dashboard.Delivery_name') }} :</th>
      <td>{{$bills->delivery->del_name}}</td>
      <td>{{ __('dashboard.Delivery_phone') }} :</td>
      <td>{{$bills->delivery->del_mobile}}</td>
    </tr>
    <tr>
      <th>{{ __('dashboard.total_price') }} :</th>
      <td>{{$total}}</td>
     
    </tr>
  </tbody>
</table>
       
        @endif
    </div>
  </div>        
</div>
	<script>

    
</script>