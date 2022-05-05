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
           <div class="card-title">{{__('dashboard.Add_User')}}</div>
           <hr>
            <form action="/user" method="POST">
             @csrf
                    <ul id="error" class="list-unstyled"></ul>
           <div class="form-group">
            <label for="input-6">{{__('dashboard.Name')}}</label>
            <input type="text" name="use_name" class="form-control form-control-rounded" id="input-6">
            @error('use_name')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
           </div>
           <div class="form-group">
            <label for="input-7">{{__('dashboard.Phone')}}</label>
            <input type="text" name="use_mobile" class="form-control form-control-rounded" id="input-7">
             @error('use_mobile')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
           </div>
       
           <div class="form-group">
                  <label for="exampleSelectBorder">{{ __('dashboard.select_rule') }}</label>
                  <select name="roles" class="custom-select form-control-border" id="exampleSelectBorder">
                   @foreach ($roles as $item)
                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                    @endforeach
                   
                  </select>
                </div>


           <div class="form-group">
            <label for="input-9">{{__('dashboard.Password')}}</label>
            <input type="text" name="use_pwd" class="form-control form-control-rounded" id="input-9" >
              @error('use_pwd')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
           </div>
           <div class="form-group">
            <label for="input-10">{{__('dashboard.Password_confirm')}}</label>
            <input type="text"  name="use_pwd_confirm" class="form-control form-control-rounded" id="input-10">
             @error('use_pwd_confirm')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
                 
                  @if(Session::has('message_confirm'))
                     
                      {{Session::get('message_confirm')}}
                                         
                        @endif
           </div>
               <div class="form-group">
            <label for="input-8">{{__('dashboard.Note')}}</label>
            <input type="text" name="use_note" class="form-control form-control-rounded" id="input-8">
                @error('use_note')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
           </div>
              
           <div class="form-group py-2">
           
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
