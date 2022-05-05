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
  .form-control
  {
    color::black;
  }
  
</style>

@endsection
@section('title')
  Delivery
@endsection

@section('content')

<body dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}" class="bg-theme bg-theme1">
 
<!-- Start wrapper-->
 <div id="wrapper">
 



<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

  <!--Start Dashboard Content-->
  <div class="container-xl">
  <div class="table-responsive">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2>{{__('dashboard.Delivery_table')}}</h2>
          </div>
       
        </div>
      </div>

       

      <table class="table table-striped table-hover">
       <div id="success_message"></div>
        <thead>
          <tr>
         
            <th>{{__('dashboard.Image')}}</th>
            <th>{{__('dashboard.Name')}}</th>
            <th>{{__('dashboard.Phone')}}</th>
            <th>Address</th>
            <th>Work Start Time</th>
            <th>Work End Time</th>
            <th>{{__('dashboard.Action')}}</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
           </tbody>
      </table>

<!-- Delete Modal HTML -->
<div id="DeleteModal" class="modal fade"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
          
        <div class="modal-header">            
          <h4 class="modal-title">{{__('dashboard.Delete_Delivery')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <p>Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
         <input type="hidden" id="deleteing_id">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
         <button type="button" class="btn btn-primary delete_delivery">Yes Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="editModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <form enctype="multipart/form-data">
     
        <div class="modal-header">            
          <h4 class="modal-title">{{__('dashboard.Edit_Delivery')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">   

         <ul id="update_msgList"></ul>

          <div class="form-group">
            <label>{{__('dashboard.Name')}}</label>
            <input type="text" class="form-control" name="del_name" id="del_name" value="">
          </div>
        
          <div class="form-group">
            <label>{{__('dashboard.Phone')}}</label>
            <input type="text" class="form-control" name="del_mobile" id="del_mobile" value="">
          </div>

<div class="form-group">
            <label>Address</label>
            <input type="text" class="form-control" name="del_address" id="del_address" value="">
          </div>

<div class="form-group">
            <label>Work Start Time</label>
            <input type="text" class="form-control" name="del_work_start_time" id="del_work_start_time" value="">
          </div>

<div class="form-group">
            <label>Work End Time</label>
            <input type="text" class="form-control" name="del_work_end_time" id="del_work_end_time" value="">
          </div>
      
            <div class="form-group">
            <label>{{__('dashboard.Password')}}</label>
            <input type="password" class="form-control" name="del_pwd" id="del_pwd" value="">
          </div>
          
           <div class="form-group">
            <label>{{__('dashboard.Password_confirm')}}</label>
            <input type="password" class="form-control" name="del_pwd_confirm" id="del_pwd_confirm" value="">
          </div>
                       <input type="hidden" name="del_id" id="del_id" >
          <div class="form-group" >
                    <label for="exampleInputFile"></label>
                    <div class="input-group" style="border-radius:30px;">
                      <div class="custom-file">
                        <input  id="file" name="del_image" type="file" onchange="previewFile(this)" class="custom-file-input">
                             <img id="ImgOri" src="" height="80" width='80' alt="image" />
                        <label class="custom-file-label" for="exampleInputFile">{{__('dashboard.select_image')}}</label>
                     
                      </div>
                            <img id="previewImg" alt="image" height="120" width='120'>
                     
         
                    </div>
                  </div>
                   </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <button type="submit" class="btn btn-primary update_delivery">Update</button>
        </div>
      </form>
    </div>
  </div>

      


      </div>
  </div>        
</div>
@if(auth()->user()->can('delivery-create'))
        <div class="card-footer">
      <div class="row">
               <a href="/add_delivery" class="nav-link">
                  <button type="submit" class="btn btn-info">{{__('dashboard.Add_Delivery')}}</button>
                   </a>
                    
                </div>
              </div>
     @endif
	   </div>
	 </div>
	</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>

    $(document).ready(function () {

           fetchDelivery();

           function fetchDelivery() {
   
                      $.ajax({
                type: "GET",
                url: "/fetch-delivery/",
                dataType: "json",
                success: function (response) {
                     console.log(response);
                    $('tbody').html("");
                     
                    $.each(response.delivery, function (key, item) {
                      
                       content = "<tr>" + 
                       "<td>"+ 
                       "<img class='rounded-circle' width='40' src='{{ asset('/images/delivery/')}}"+'/'+item.del_image+"'/>" + 
                       "</td>" 
                       + "<td>"
                                           + item.del_name + "</td><td>"
                                           + item.del_mobile + "</td><td>"
                                           + item.del_address + "</td><td>"
                                           + item.del_work_start_time + "</td><td>"
                                           + item.del_work_end_time + "</td><td>@if(auth()->user()->can('delivery-edit'))<button type='button' value='" + item.del_id + "' class='btn btn-primary editbtn btn-sm'>Edit</button>@endif @if(auth()->user()->can('delivery-delete'))<button type='button' value='" + item.del_id + "' class='btn btn-danger deletebtn btn-sm'>Delete</button>@endif</td>"
                          
                           if (item.del_status == '0'){
  
    content += "<td><button type='button' value=" + item.del_id + " class='btn btn-primary btn-sm'>Out of Working</button></td></tr>";
}
if (item.del_status == '1'){
  
    content += "<td><button type='button' value=" + item.del_id + " class='btn btn-primary btn-sm'>Working</button></td></tr>";
}
if (item.del_status == '2'){
  
    content += "<td><button type='button' value=" + item.del_id + " class='btn btn-primary btn-sm'>Free To Work</button></td></tr>";
}

                 
                        $('tbody').append(content);
                    });
                }
     });
}
           

        $(document).on('click', '.editbtn', function (e) {
            e.preventDefault();
            var del_id = $(this).val();
            // alert(cat_id);
            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-delivery/" + del_id,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').modal('hide');
                    } else {
                        $('#del_name').val(response.delivery.del_name);
                        $('#del_mobile').val(response.delivery.del_mobile);
                        $('#del_id').val(response.delivery.del_id);
                        $('#del_address').val(response.delivery.del_address);
                        $('#del_work_start_time').val(response.delivery.del_work_start_time);
                        $('#del_work_end_time').val(response.delivery.del_work_end_time);

                        $('#ImgOri').attr('src', "/images/delivery/"+'/'+response.delivery.del_image);
                    
                    }
                }
            });
            $('.btn-close').find('input').val('');

        });

        $(document).on('click', '.update_delivery', function (e) {
            e.preventDefault();

            $(this).text('Updating..');

            var files = $('#file')[0].files;
            var form_data = new FormData();

         if(files.length > 0){

            var name = document.getElementById("file").files[0].name;
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
 
            form_data.append("del_image", document.getElementById('file').files[0]);
         }
            var del_name = $('#del_name');
            var del_mobile = $('#del_mobile');
            var del_id = $('#del_id');
            var del_pwd = $('#del_pwd');
            var del_pwd_confirm = $('#del_pwd_confirm');
var del_address = $('#del_address'); 
var del_work_start_time = $('#del_work_start_time');
 var del_work_end_time = $('#del_work_end_time');


            form_data.append('del_name', del_name.val());
            form_data.append('del_mobile', del_mobile.val());
            form_data.append('del_id', del_id.val());
            form_data.append('del_pwd', del_pwd.val());
            form_data.append('del_pwd_confirm', del_pwd_confirm.val());
form_data.append('del_address', del_address.val());
form_data.append('del_work_start_time', del_work_start_time.val());
form_data.append('del_work_end_time', del_work_end_time.val());

         
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/update_delivery',
                data:form_data,
                contentType: false,
                cache: false,
                processData: false,
               success: function (response){
                 if (response.status == 40) {alert('m');}
                        if (response.status == 400) {
                        $('#update_msgList').html("");
                        $('#update_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#update_msgList').append('<li>' + err_value +
                                '</li>');
                        });
                        $('.update_delivery').text('Update');
                    } if (response.status == 4000) {
                     
                       $('#update_msgList').html("");
                        $('#update_msgList').addClass('alert alert-danger');
                        $('#update_msgList').text(response.message);
                        $('.update_delivery').text('Update');
                    
                    } else {
                        $('#update_msgList').html("");

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').find('input').val('');
                        $('.update_delivery').text('Update');
                        $('#editModal').modal('hide');
                        fetchDelivery();
                    }

            }

          });

       
        });

        $(document).on('click', '.deletebtn', function () {
            var del_id = $(this).val();
            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(del_id);
        });

        $(document).on('click', '.delete_delivery', function (e) {
            e.preventDefault();

            $(this).text('Deleting..');
            var del_id = $('#deleteing_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-delivery/" + del_id,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_delivery').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_delivery').text('Yes Delete');
                        $('#DeleteModal').modal('hide');
                        fetchDelivery();
                    }
                }
            });
        });
 });
            
           
                
</script>

@endsection


