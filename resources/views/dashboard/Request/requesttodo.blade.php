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
            <h2>Request</h2>
          </div>
       
        </div>
      </div>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
         
            <th>Request</th>
            <th>date</th>
            <th>detail</th>
          </tr>
        </thead>
        <tbody class="cont-data">
        @foreach ($bills as $item)
            
          <tr>
         
            <td>{{$item->bil_id}}</td>
            <td>{{$item->bil_regdate}}</td>
 <form action="bill_detail" method="post">
            @csrf
            <input type=hidden value="{{$item->bil_id}}" name="bil_id">
             <td><input type="submit" class="btn btn-info" value="detail"></td>
            
            </form>
            
          </tr>
         


  @endforeach
        </tbody>
      </table>
      
     
    </div>
  </div>        
</div>


@endsection
	 