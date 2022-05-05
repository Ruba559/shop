@extends('dashboard.app')



@section('title')
Rule
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
           <div class="card-title">{{ __('dashboard.Rule') }}</div>
           <hr>
            <form action="/rule" method="POST">
             @csrf
             
            <ul id="error" class="list-unstyled"></ul>
           <div class="form-group">
            <label for="input-6">{{__('dashboard.Name')}}</label>
            <input type="text" name="name" class="form-control form-control-rounded" id="input-6">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
           </div>
                 
                {{-- <div class="form-group">
                  <label for="exampleSelectBorder">Select Rule</label>
                  <select  name="permission[]"  multiple="multiple" class="form-control-border" id="exampleSelectBorder">
                   @foreach ($permissions as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                   
                  </select>
                </div> --}}

                <div class="form-group">
                  @foreach ($permissions as $item)
                  <label>{{ $item->name }}</label>
                  <input type="checkbox" name="permission[]" value="{{ $item->id }}">
                  <br>
                  @endforeach
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
