@extends('dashboard.app')

@section('title')
 Users
@endsection
@section('content_head')

@endsection
@section('content')

<body class="bg-theme bg-theme1">
 
<!-- Start wrapper-->
 <div id="wrapper">
 
  <!--Start sidebar-wrapper-->
  
     @include('dashboard.header')
 

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

  <!--Start Dashboard Content-->

  <div class="card">
           <div class="card-body">
           <div class="card-title">Add Product Price</div>
           <hr>
            <form action="/productprice" method="POST">
             @csrf
                    <ul id="error" class="list-unstyled"></ul>
           <div class="form-group">
            <label for="input-6">price</label>
            <input type="text" name="price" class="form-control form-control-rounded" id="input-6">
            @error('pro_name')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
           </div>
          
       
              <div class="form-group">
                  <label for="exampleSelectBorder">Select Product</label>
                  <select name="id" class="custom-select form-control-border" id="exampleSelectBorder">
                   @foreach ($productName as $item)
                    <option value="{{ $item->id }}">{{ $item->pro_name }}</option>
                    @endforeach
                   
                  </select>
                </div>

                <div class="form-group">
                    <label for="exampleSelectBorder">Select Supplier</label>
                    <select name="sup_id"  class="custom-select form-control-border" id="exampleSelectBorder">
                     @foreach ($supplier as $item)
                      <option value="{{ $item->sup_id }}">{{ $item->sup_name }}</option>
                      @endforeach
                     
                    </select>
                  </div>

           <div class="form-group">
            <input name="submit" type="submit" class="btn btn-light btn-round px-5">
          </div>
          </form>
         </div>
         </div>


	   </div>
	 </div>
	</div>

 @endsection
