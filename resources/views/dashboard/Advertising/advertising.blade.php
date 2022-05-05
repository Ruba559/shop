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
   Advertising
@endsection

@section('content')

<body dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}" class="bg-theme bg-theme1">
 
<!-- Start wrapper-->
 <div id="wrapper">
 



<div class="clearfix"></div>
	
  <div class="content-wrapper" id="table-container">
    <div class="container-fluid">

  <!--Start Dashboard Content-->
  <div class="container-xl">
  <div class="table-responsive">
    <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2>{{ __('dashboard.Advert_table') }}</h2>
          </div>
       
        </div>
      </div>
         <div id="success_message"></div>

      <table class="table table-striped table-hover">
     
        <thead>
          <tr>
         
            <th>{{__('dashboard.Image')}}</th>
            <th>{{__('dashboard.Name_ar')}}</th>
            <th>{{__('dashboard.Name_en')}}</th>
            <th>{{__('dashboard.Action')}}</th>
          </tr>
        </thead>
        <tbody>
         </tbody>
      </table>


<!-- Delete Modal HTML -->
<div id="DeleteModal" class="modal fade" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
         
        <div class="modal-header">            
          <h4 class="modal-title">{{ __('dashboard.Delete_advert') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <p>Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default btn-close" data-dismiss="modal" value="Cancel">

            <input type="hidden" id="deleteing_id">

          <button type="button" class="btn btn-primary delete_advertising">Yes Delete</button>

        </div>
      </form>
    </div>
  </div>
</div>

<div id="editModal" class="modal fade" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
    <div class="modal-body">
              <ul id="update_msgList"></ul>

        <div class="modal-header">            
          <h4 class="modal-title">{{ __('dashboard.Edit_advert') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <div class="form-group">
            <label>{{__('dashboard.Name_en')}}</label>
            <input  type="text" class="form-control" name="advert_name" id="advert_name">
          </div>
         
          <div class="form-group">
            <label>{{__('dashboard.Name_ar')}}</label>
            <input type="text" class="form-control" name="advert_name_en" id="advert_name_en">
          </div>
         <input type="hidden" id="advert_id" >
          <div class="form-group" >
                    <label for="exampleInputFile"></label>
                    <div class="input-group" style="border-radius:30px;">
                      <div class="custom-file">
                   
                        <input id="file" name="advert_image" onchange="previewFile(this)" type="file" class="custom-file-input" >
                       
                        <label class="custom-file-label" for="exampleInputFile">{{__('dashboard.select_image')}}</label>
                     <img id="ImgOri" src="" height="80" width='80' alt="image" />
                     
                      </div>
                            <img id="previewImg" alt="image" height="120" width='120'>
                     
                    </div>
                  </div>
                   </div>
        <div class="modal-footer">
         
          <input type="button"  class="btn btn-default" data-dismiss="modal" value="Cancel">
            <button type="submit" class="btn btn-primary update_advertising">Update</button>
        </div>
      </div>
    </div>
  </div>

       


      </div>
  </div>        
</div>
        <div class="card-footer">
      <div class="row">
               <a href="add_advertising" class="nav-link">
                  <button type="submit" class="btn btn-info">Add</button>
                   </a>
                    
                </div>
              </div>
     
	   </div>
	 </div>
	</div>
 

 <script>
    $(document).ready(function () {

        fetchAdvertising();
      
        function fetchAdvertising() {
            $.ajax({
                type: "GET",
                url: "/fetch-advertising",
                dataType: "json",
                success: function (response) {
                   console.log(response);
                    $('tbody').html("");

                    $.each(response.advertising, function (key, item) {
                      
                       content = "<tr>" + 
                       "<td>"+ 
                       "<img class='rounded-circle' width='40' src='{{ asset('/images/advert/')}}"+'/'+item.advert_image+"'/>" + 
                       "</td>" 
                       + "<td>" 
                       + item.advert_name + "</td><td>"
                       + item.advert_name_en + "</td><td><button type='button' value='" + item.advert_id + "' class='btn btn-primary editbtn btn-sm'>Edit</button><button type='button' value='" + item.advert_id + "' class='btn btn-danger deletebtn btn-sm'>Delete</button></td>"
                          
                        $('tbody').append(content);
                    });
                }
            });
        }

       
        $(document).on('click', '.editbtn', function (e) {
            e.preventDefault();
            var advert_id = $(this).val();
            // alert(cat_id);
            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-advertising/" + advert_id,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').modal('hide');
                    } else {
                        // console.log(response.category.cat_image);
                        $('#advert_name').val(response.advertising.advert_name);
                        $('#advert_name_en').val(response.advertising.advert_name_en);
                        $('#advert_id').val(response.advertising.advert_id);
                        $('#ImgOri').attr('src', "/images/advert/"+'/'+response.advertising.advert_image);
                    
                    }
                }
            });
            $('.btn-close').find('input').val('');

        });


        $(document).on('click', '.update_advertising', function (e) {
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
 
            form_data.append("advert_image", document.getElementById('file').files[0]);

     }
            var advert_name = $('#advert_name');
            var advert_name_en = $('#advert_name_en');
            var advert_id = $('#advert_id');

            form_data.append('advert_name', advert_name.val());
            form_data.append('advert_name_en', advert_name_en.val());
            form_data.append('advert_id', advert_id.val());

         
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/update_advertising',
                data:form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if (response.status == 400) {
                        $('#update_msgList').html("");
                        $('#update_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#update_msgList').append('<li>' + err_value +
                                '</li>');
                        });
                        $('.update_advertising').text('Update');
                    } else {
                        $('#update_msgList').html("");

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').find('input').val('');
                        $('.update_advertising').text('Update');
                        $('#editModal').modal('hide');
                        fetchAdvertising();
                    }
                }
            });
          
        });
        

        $(document).on('click', '.deletebtn', function () {
            var advert_id = $(this).val();
            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(advert_id);
        });

        $(document).on('click', '.delete_advertising', function (e) {
            e.preventDefault();

            $(this).text('Deleting..');
            var advert_id = $('#deleteing_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-advertising/" + advert_id,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_advertising').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_advertising').text('Yes Delete');
                        $('#DeleteModal').modal('hide');
                        fetchAdvertising();
                    }
                }
            });
        });

    });

</script>

@endsection


