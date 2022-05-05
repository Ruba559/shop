@extends('dashboard.app')


@section('content_head')
    <link rel="stylesheet" href="{{ asset('css/imgareaselect-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/imgareaselect-animated.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/imgareaselect-deprecated.css') }}" />
@endsection

@section('title')
  Advertising
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
           <div class="card-title">{{ __('dashboard.Add_advert') }}</div>
           <hr>
            <form action="/advertising" method="POST" enctype="multipart/form-data">
                    @csrf
           <div class="form-group">
            <label for="input-6">{{__('dashboard.Name_ar')}}</label>
          
            <input type="text"  name="advert_name" class="form-control form-control-rounded" id="input-6" >
            @error('advert_name')
                 <span class="text-danger">{{$message}}</span>
             @enderror
             <label for="input-6">{{__('dashboard.Name_en')}}</label>
            <input type="text"  name="advert_name_en" class="form-control form-control-rounded" id="input-6">
           </div>
            @error('advert_name_en')
                 <span class="text-danger">{{$message}}</span>
             @enderror
        
           <div class="form-group" >
                    <label for="exampleInputFile"></label>
                    <div class="input-group" style="border-radius:30px;">
                      <div class="custom-file">
                     
                      
                      </div>
                      @error('advert_image')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      
                   
            <div class="form-group">
                <label for="exampleInputImage">{{ __('dashboard.Image') }}:</label>
                <input type="file" id="file" name="advert_image" class="file image" >
                 <input type="hidden" name="x1" id="x1" value="0" />
                <input type="hidden" name="y1" id="y1" value="0" />
                <input type="hidden" name="w" id="w" value="300" />
                <input type="hidden" name="h" id="h" value="300" />
            </div>
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
   form_data.append("advert_image", document.getElementById('file').files[0]);

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
               $('#ImgOri').attr('src', "/images/advert/"+'/'+response.path);
               
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
   form_data.append("advert_image", document.getElementById('file').files[0]);

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
            url: "/crop_advertising",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
           
            success:function(response){
               if (response.status == 200) {
                 alert('n');
               }
               $('#ImgOri').attr('src', "/images/advert/crop/"+'/'+response.path);
               
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

