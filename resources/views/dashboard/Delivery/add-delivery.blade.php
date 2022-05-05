@extends('dashboard.app')


@section('content_head')

    <link rel="stylesheet" href="{{ asset('css/imgareaselect-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/imgareaselect-animated.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/imgareaselect-deprecated.css') }}" />
@endsection

@section('title')
   delivery
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
           <div class="card-title">{{__('dashboard.Add_Delivery')}}</div>
           <hr>
            <form id="imageUploadForm" action="/delivery" method="POST" enctype="multipart/form-data">
                    @csrf
           <div class="form-group">
            <label for="input-6">{{__('dashboard.Name')}}</label>
           <div class="form-group">

            <input type="text"  name="del_name" class="form-control form-control-rounded" id="input-6" >
            @error('del_name')
                 <span class="text-danger">{{$message}}</span>
             @enderror
             <label for="input-6">{{__('dashboard.Phone')}}</label>
            <input type="text"  name="del_mobile" class="form-control form-control-rounded" id="input-6">
           </div>
            @error('del_mobile')
                 <span class="text-danger">{{$message}}</span>
             @enderror
 <div class="form-group">

  <label for="input-6">{{ __('dashboard.Work_stert_time') }}</label>
            <input type="time"  name="del_work_start_time" class="form-control form-control-rounded" id="input-6">
           </div>
            @error('del_work_start_time')
                 <span class="text-danger">{{$message}}</span>
             @enderror
<div class="form-group">

  <label for="input-6">{{ __('dashboard.Work_end_time') }}</label>
            <input type="time"  name="del_work_end_time" class="form-control form-control-rounded" id="input-6">
           </div>
            @error('del_work_end_time')
                 <span class="text-danger">{{$message}}</span>
             @enderror

<div class="form-group">

      <label for="input-6">{{ __('dashboard.Address') }}</label>
            <input type="text"  name="del_address" class="form-control form-control-rounded" id="input-6">
           </div>
            @error('del_address')
                 <span class="text-danger">{{$message}}</span>
             @enderror

             <label for="input-6">{{ __('dashboard.Rate') }}</label>
            <input type="text"  name="del_rate" class="form-control form-control-rounded" id="input-6">
           </div>
            @error('del_rate')
                 <span class="text-danger">{{$message}}</span>
             @enderror

              <label for="input-6">{{__('dashboard.Password')}}</label>
            <input type="text"  name="del_pwd" class="form-control form-control-rounded" id="input-6">
           </div>
            @error('del_pwd')
                 <span class="text-danger">{{$message}}</span>
             @enderror

              <label for="input-6">{{__('dashboard.Password_confirm')}}</label>
            <input type="text"  name="del_pwd_confirm" class="form-control form-control-rounded" id="input-6">
           </div>
            @error('del_pwd_confirm')
                 <span class="text-danger">{{$message}}</span>
             @enderror
            @if(Session::has('message_confirm'))
                     
                      {{Session::get('message_confirm')}}
                                         
                        @endif
           
   
                <div class="form-group">
                <label for="exampleInputImage">{{ __('dashboard.Image') }}:</label>
                <input  type="file" id="file" name="del_image"  class="file image" >
                <input type="hidden" name="x1" id="x1" value="0" />
                <input type="hidden" name="y1" id="y1" value="0" />
                <input type="hidden" name="w" id="w" value="300" />
                <input type="hidden" name="h" id="h" value="300" />
            </div>
           {{-- <input type="text" name="file_path" id="file-path"> --}}
           <div class="form-group">
            <button type="submit" class="btn btn-light btn-round px-5">{{__('dashboard.Add')}}</button>
          </div>
          </form>
          <div class="form-group py-2">
           <p><img id="previewimage" src="" >
          
           </div>
            <div class="form-group py-2">
           <p><img id="preview" src="" >
             <img id="ImgOri" src=""  width='100' alt="image" />

            <button type="button" class="crop btn btn-primary">crop</button>
           </div>
         </div>
         </div>
     
          
	   </div>
	 </div>
	</div>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <script src="{{ asset('js/jquery.imgareaselect.dev.js') }}"></script>
    <script>
    jQuery(function($) {
        var p = $("#preview");
 
        $("body").on("change", ".image", function(){
            var imageReader = new FileReader();
            imageReader.readAsDataURL(document.querySelector(".image").files[0]);
 
            imageReader.onload = function (oFREvent) {
                p.attr('src', oFREvent.target.result).fadeIn();
            };
        });
 
        $('#preview').imgAreaSelect({
            onSelectEnd: function (img, selection) {
                $('input[name="x1"]').val(selection.x1);
                $('input[name="y1"]').val(selection.y1);
                $('input[name="w"]').val(selection.width);
                $('input[name="h"]').val(selection.height);            
            }
        });
    });


   $(document).on('click', '.show', function (e) {
        e.preventDefault();
         $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            
  var name = document.getElementById("file").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg' ,'jfif']) == -1) 
  {
   alert("Invalid Image File");
  }
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("file").files[0]);
  var f = document.getElementById("file").files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 2000000)
  {
   alert("Image File Size is very big");
  }
  else
  {
   form_data.append("del_image", document.getElementById('file').files[0]);

    $.ajax({

            type:"POST",
            url: "/show",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
           
            success:function(response){
               if (response.status == 200) {
                 
               }
               $('#ImgOri').attr('src', "/images/delivery/"+'/'+response.path);
               
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
   
  
    });
  }
}); 

$(document).on('click', '.crop', function (e) {
        e.preventDefault();
         $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            
  var name = document.getElementById("file").files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg' ,'jfif']) == -1) 
  {
   alert("Invalid Image File");
  }
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("file").files[0]);
  var f = document.getElementById("file").files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 2000000)
  {
   alert("Image File Size is very big");
  }
  else
  {
   form_data.append("del_image", document.getElementById('file').files[0]);

var w = $('#w');
var h = $('#h');
var x1 = $('#x1');
var y1 = $('#y1');

form_data.append('w', w.val());
form_data.append('h', h.val());
form_data.append('x1', x1.val());
form_data.append('y1', y1.val());

    $.ajax({

            type:"POST",
            url: "/crop_delivery",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
           
            success:function(response){
               if (response.status == 200) {
                 alert('n');
               }
               $('#ImgOri').attr('src', "/images/delivery/crop/"+'/'+response.path);
               
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
   
  
    });
  }
}); 

    </script>
@endsection

  