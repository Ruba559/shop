@extends('dashboard.app')


@section('content_head')

<style>
    .custom-select
    {
      border-radius:25px;
      color: #99b4c5;
    }
    
  </style>
  
@endsection

@section('title')
   Products
@endsection
@section('content')


<body class="bg-theme bg-theme1">
 
 <div id="wrapper">
 
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

  <!--Start Dashboard Content-->

  <div class="card">
           <div class="card-body">
           <div class="card-title">{{__('dashboard.Add_Product')}}</div>
           <hr>
            <form action="/product" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="exampleSelectBorder">{{__('dashboard.select_category')}}</label>
                      <select name="id" class="myselect custom-select form-control-border" id="exampleSelectBorder">
                       @foreach ($product as $item)
                        <option value="{{ $item->id }}">{{ $item->pro_name }}</option>
                        @endforeach
                       
                      </select>
                    </div>
                       @error('pro_id')
                     <span class="text-danger">{{$message}}</span>
                 @enderror

            <div class="form-group">
            <label for="input-6">{{__('dashboard.Name_ar')}}</label>
            <input name="foo_name_en" type="text" class="form-control form-control-rounded" id="input-6">
           </div>
             @error('foo_name_en')
                 <span class="text-danger">{{$message}}</span>
             @enderror
           <div class="form-group">
            <label for="input-7">{{__('dashboard.Info')}}</label>
            <input name="foo_info" type="text" class="form-control form-control-rounded" id="input-7">
           </div>
               @error('foo_info')
                 <span class="text-danger">{{$message}}</span>
             @enderror
           <div class="form-group">
            <label for="input-7">Info in English</label>
            <input name="foo_info_en" type="text" class="form-control form-control-rounded" id="input-7">
           </div>
       @error('foo_info_en')
                 <span class="text-danger">{{$message}}</span>
             @enderror
             <div class="form-group">
            <label for="input-7">{{__('dashboard.Price')}}</label>
            <input name="foo_price" type="text" class="form-control form-control-rounded" id="input-7">
           </div>
       @error('foo_price')
                 <span class="text-danger">{{$message}}</span>
             @enderror
             <div class="form-group">
            <label for="input-7">{{__('dashboard.Offer')}}</label>
            <input name="foo_offer" type="text" class="form-control form-control-rounded" id="input-7">
           </div>
           @error('foo_offer')
                 <span class="text-danger">{{$message}}</span>
             @enderror
               
                  <div class="form-group">
                  <label for="exampleSelectBorder">{{__('dashboard.select_category')}}</label>
                  <select name="cat_id" class="custom-select form-control-border" id="exampleSelectBorder">
                   @foreach ($categories as $category)
                    <option value="{{ $category->cat_id }}">{{ $category->cat_name }}</option>
                    @endforeach
                   
                  </select>
                </div>
                   @error('cat_id')
                 <span class="text-danger">{{$message}}</span>
             @enderror
               
                <div class="form-group" >
                    <label for="exampleInputFile"></label>
                    <div class="input-group" style="border-radius:30px;">
                      <div class="custom-file">
                        <input id="file" name="foo_image" type="file" class="file image custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">{{__('dashboard.select_image')}}</label>
                      <input type="hidden" name="x1" id="x1" value="0" />
                      <input type="hidden" name="y1" id="y1" value="0" />
                      <input type="hidden" name="w" id="w" value="300" />
                      <input type="hidden" name="h" id="h" value="300" />
                      </div>
                     
                    </div>
                  </div>
                     
                  
                    <div class="no"></div>
           <div class="card-body table-responsive p-0" id="sup" style="height: 280px;">
                              <table class="table table-head-fixed text-nowrap">
                                <thead>
                                  
                                  <tr>
                                    
                                    <th>ID</th>
                                    <th>Suppliers Name</th>
                                    <th>Price</th>
                                    
                                  </tr>
                                
                                </thead>
                                <tbody class="viewsupllier">
                                
                                 
                                </tbody>
                              </table>

                            </div> 
                            <div id="total"></div>
                        </div>



           <div class="form-group">
            <button type="submit" class="btn btn-light btn-round px-5">{{__('dashboard.Add')}}</button>
          </div>
          </form>
         </div>
         </div>
        <div class="form-group py-2">
         
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

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="{{ asset('js/jquery.imgareaselect.dev.js') }}"></script>

   <script>

   $(document).ready(function () {
     $("#sup").hide();
     
    $(".myselect").change(function(e){
           e.preventDefault();
    var id = $(this).val();

    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
               
                url: "/show_supllier",
                data: {'id':id},
                dataType: "json",
                success: function (response) {
                  if (response.status == 404) {
                    $(".no").append('no resulte');

                    }else{
                     console.log(response);

                  
                      $(".viewsupllier").empty().hide(200);
                  

                     $.each(response.product, function (key, item) { 
                       $(".viewsupllier").fadeOut(200 , function(){
                       $(this).append('<tr><td>'+item.sup_id+'</td><td>'+item.sup_name+'</td><td><span class="price_total">'+item.price+'</span></td></tr>').show(200);
                       });
                   });
  		   
                     $("#sup").show(600);


                     var sum = 0 ;
                    
		               	$("#total").text('Max  is : $'+response.total);
                }
                }
            });

  });
      });

   </script>


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
   form_data.append("foo_image", document.getElementById('file').files[0]);

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
               $('#ImgOri').attr('src', "/images/food/"+'/'+response.path);
               
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
   form_data.append("foo_image", document.getElementById('file').files[0]);

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
            url: "/crop_product",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
           
            success:function(response){
               if (response.status == 200) {
                 alert('n');
               }
               $('#ImgOri').attr('src', "/images/food/crop/"+'/'+response.path);
               
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
