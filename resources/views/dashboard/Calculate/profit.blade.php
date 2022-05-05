@extends('dashboard.app')


@section('content_head')

<style>
  label
  {
    color: black
  }
  .modal-title
  {
    color: rebeccapurple;
  }
  .form-control
  {
    border:1px solid #663399;
    background-color:#eee;
    color:black;
  }
  select option
  {
    background:#eeeeee;
    color:black;
  }
</style>
@endsection

@section('title')
 Users
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
            <h2>{{ __('dashboard.Calculation') }}</h2>
          </div>
       
        </div>
      </div>
     
      <table class="table table-striped table-hover">
        <thead>
          <tr>
         
            <th>{{ __('dashboard.Bill_number') }}</th>
            <th>{{ __('dashboard.supplier') }}</th>
            <th>{{ __('dashboard.Customer_price') }}</th>
            <th>{{ __('dashboard.Delivery_name') }}</th>
            <th>{{ __('dashboard.Delivery_rate') }}</th>
            <th>{{ __('dashboard.Total') }}</th>
          </tr>
        </thead>
        <tbody class="cont-data">

        @foreach ($bills as $item)
  
          <tr>
         
            <td>{{$item->bil_id}}</td>

            <td>
            <select class="custom-select form-control-border" id="exampleSelectBorder">
              @foreach ($item->detailBills as $row)
             <option> Supplier : {{ $row->supplier->sup_name }}</option>
              @endforeach
              
             </select>
            </td>
            @php

            $c = DB::table('detail_bill')->where( 'bil_id' , $item->bil_id)->sum('det_price');
          
            @endphp
         
            <td>{{ $c }}</td>
        
            <td>{{$item->delivery->del_name}}</td> 

            <td>{{$item->delivery->del_rate}}</td>
            <td></td>
          </tr>
        
          @endforeach
         

        </tbody>
      </table>
       
     
    </div>
  </div>        
</div>

@endsection
	 