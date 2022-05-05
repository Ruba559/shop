@extends('dashboard.app')


@section('content_head')
   @endsection

@section('title')
  Supplier
@endsection
@section('content')

 
  
</head>

<body class="bg-theme bg-theme1">
 
<!-- Start wrapper-->
 <div id="wrapper">
 
 


<!--End topbar header-->

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

  <!--Start Dashboard Content-->

  <div class="card">
           <div class="card-body">
           <div class="card-title">{{ __('dashboard.Add_supplier') }}</div>
           <hr>
            <form action="/supplier" method="POST">
                   @csrf
                    <ul id="error" class="list-unstyled"></ul>
           <div class="form-group">
            <label for="input-6">{{__('dashboard.Name')}}</label>
            <input type="text" name="sup_name" class="form-control form-control-rounded" id="input-6">
            @error('sup_name')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
           </div>
           <div class="form-group">
            <label for="input-7">{{__('dashboard.Phone')}}</label>
            <input type="text" name="sup_mobile" class="form-control form-control-rounded" id="input-7">
             @error('sup_mobile')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
           </div>
       <div class="form-group">
            <label for="input-7">{{ __('dashboard.Email') }}</label>
            <input type="text" name="sup_email" class="form-control form-control-rounded" id="input-7">
             @error('sup_email')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
           </div>
 <div class="form-group">
            <label for="input-7">{{ __('dashboard.Address') }}</label>
            <input type="text" name="sup_address" class="form-control form-control-rounded" id="input-7">
             @error('sup_address')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
           </div>

       
           <div class="form-group">
            <label for="input-9">{{__('dashboard.Password')}}</label>
            <input type="text" name="sup_pwd" class="form-control form-control-rounded" id="input-9" >
              @error('sup_pwd')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
           </div>
           <div class="form-group">
            <label for="input-10">{{__('dashboard.Password_confirm')}}</label>
            <input type="text" class="form-control form-control-rounded" id="input-10">
             @error('sup_pwd_confirm')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
                 
                  @if(Session::has('message_confirm'))
                     
                      {{Session::get('message_confirm')}}
                                         
                        @endif
           </div>
               <div class="form-group">
            <label for="input-8">{{__('dashboard.Note')}}</label>
            <input type="text" name="sup_note" class="form-control form-control-rounded" id="input-8">
                @error('sup_note')
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
	</div>
 @endsection
