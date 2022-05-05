@extends('dashboard.app')



@section('title')
Permission
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
           <div class="card-title">Permission</div>
           <hr>
            <form action="/permission" method="POST">
             @csrf
                    <ul id="error" class="list-unstyled"></ul>
           <div class="form-group">
            <label for="input-6">{{__('dashboard.Name')}}</label>
            <input type="text" name="name" class="form-control form-control-rounded" id="input-6">
            @error('name')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
           </div>
                 
               
                                 
              <div class="form-group">
            <input name="submit" type="submit" class="btn btn-light btn-round px-5">
          </div>
          </form>
         </div>
         </div>


	   </div>
	 </div>
	</div><!--End Row-->
 

 @endsection
