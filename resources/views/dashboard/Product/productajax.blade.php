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
</style>
@endsection

@section('title')
   Products
@endsection

@section('content')


<body class="bg-theme bg-theme1">
 
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
            <h2>{{__('dashboard.Product_table')}}</h2>
          </div>
       
        </div>
      </div>
      <table class="table table-striped table-hover">
        <div id="success_message"></div>
        <thead>
          <tr>
             <th>{{__('dashboard.Image')}}</th>
             <th>{{__('dashboard.Name_ar')}}</th>
             <th>{{__('dashboard.Name_en')}}</th>
             <th>{{__('dashboard.Note')}}</th>
             <th>{{__('dashboard.Info')}}</th>
             <th>{{__('dashboard.Price')}}</th>
             <th>{{__('dashboard.Offer')}}</th> 
             <th>{{__('dashboard.Action')}}bnn</th>

          </tr>
        </thead>
        <tbody>
      
           </tbody>
      </table>

<!-- Delete Modal HTML -->
<div class="modal fade" id="DeleteModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
        <div class="modal-header">            
          <h4 class="modal-title">{{__('dashboard.Delete_Product')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <p>Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <input type="hidden" id="deleteing_id">

          <button type="button" class="btn btn-primary delete_product">Yes Delete</button>

        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="editModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    

        <div class="modal-header">            
          <h4 class="modal-title">{{__('dashboard.Edit_Product')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>

        <ul id="update_msgList"></ul>

        <div class="modal-body">          
          <div class="form-group">
            <label>{{__('dashboard.Name_ar')}}</label>
            <input type="text" class="form-control" id="foo_name">
          </div>
         
          <div class="form-group">
            <label>{{__('dashboard.Name_en')}}</label>
            <input type="text" class="form-control" id="foo_name_en">
          </div>
                      
                     
            <div class="form-group">
            <label>{{__('dashboard.Info')}}</label>
            <input type="text" class="form-control" id="foo_info">
          </div>
         
          <div class="form-group">
            <label>{{__('dashboard.Note')}}</label>
            <input type="text" class="form-control" id="foo_info_en" >
          </div>
            <div class="form-group">
            <label>{{__('dashboard.Price')}}</label>
            <input type="text" class="form-control" id="foo_price">
          </div>
            <div class="form-group">
            <label>{{__('dashboard.Offer')}}</label>
            <input type="text" class="form-control" id="foo_offer" >
          </div>
                  
                  <input type="hidden" id="foo_id">
<select id="ddlRelationship" class="form-control chosen-select" name="ddlRelationship">

</select>
               <div class="form-group" >
                    <label for="exampleInputFile"></label>
                    <div class="input-group" style="border-radius:30px;">
                      <div class="custom-file">
                        <input id="file" type="file" onchange="previewFile(this)" class="custom-file-input" id="exampleInputFile">
                       
                        <label class="custom-file-label" for="exampleInputFile">{{__('dashboard.select_image')}}</label>
                     <img id="ImgOri" src="" height="80" width='80' alt="image" />
                     
                     
                      </div>
                            <img id="previewImg" alt="image" height="120" width='120'>
                    </div>
                  </div>
          
                   </div>
        <div class="modal-footer">
          
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
            <button type="submit" class="btn btn-primary update_product">Update</button>
        </div>
    </div>
  </div>

      
      
    </div>
  </div>        
</div>

  @if(auth()->user()->can('product-create'))
 
  <div class="card-footer">
      <div class="row">
 
       <a href="add_product" class="nav-link">
                  <button type="submit" class="btn btn-info">{{__('dashboard.Add_Product')}}</button>
                   </a>
                </div>
              </div>
@endif
<script>

    $(document).ready(function () {

        fetchProduct();
      
        function fetchProduct() {
            $.ajax({
                type: "GET",
                url: "/fetch-product",
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    $('tbody').html("");
                     
                    $.each(response.product, function (key, item) {
                      
                       content = "<tr>" + 
                       "<td>"+ 
                       "<img class='rounded-circle' width='30' height='20' src='{{ asset('/images/food/')}}"+'/'+ item.foo_image +"'/>" + 
                       "</td>" 
                                    +"<td>"+ item.foo_name + "</td><td>" 
                                           + item.foo_name_en + "</td><td>"  
                                           + item.foo_info_en + "</td><td>" 
                                           + item.foo_info + "</td><td>" 
                                           + item.foo_offer + "</td><td>" 
                                           + item.foo_price + "</td><td>@if(auth()->user()->can('product-edit'))<button type='button' value='" + item.foo_id + "' class='btn btn-primary editbtn btn-sm'>Edit</button>@endif @if(auth()->user()->can('product-delete'))<button type='button' value='" + item.foo_id + "' class='btn btn-danger deletebtn btn-sm'>Delete</button>@endif</td>"
                                          
                 
                        $('tbody').append(content);
                     
                    });
                }
            });
        }

       

        $(document).on('click', '.editbtn', function (e) {
            e.preventDefault();
            var foo_id = $(this).val();
            // alert(cat_id);
            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-product/" + foo_id,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').modal('hide');
                    } else {
                        $('#foo_name').val(response.product.foo_name);
                        $('#foo_name_en').val(response.product.foo_name_en);
                        $('#foo_price').val(response.product.foo_price);
                        $('#foo_offer').val(response.product.foo_offer);
                        $('#foo_info').val(response.product.foo_info);
                        $('#foo_info_en').val(response.product.foo_info_en);
                        $('#foo_id').val(response.product.foo_id);
                        var r = response.product.category.cat_name;

                        var temp = $('#ddlRelationship');
                       
        temp.empty();
        $("#ddlRelationship").append('<option value='+response.product.cat_id+'>'+r+'</option>');

        $.each(response.category, function (i, data) {                 
    
            $('<option>',
               {
                   value: data.cat_id,
                   text: data.cat_name,
               }).html(data.cat_name).appendTo("#ddlRelationship");
        });
       // $('#ddlRelationship').trigger("chosen:updated");
        $('#ImgOri').attr('src', "/images/food/"+'/'+response.product.foo_image);
                    }
                }
            });
            
            $('.btn-close').find('input').val('');

        });

        $(document).on('click', '.update_product', function (e) {
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
 
            form_data.append("foo_image", document.getElementById('file').files[0]);
         }
            var foo_name = $('#foo_name');
            var foo_name_en = $('#foo_name_en');
            var foo_info = $('#foo_info');
            var foo_info_en = $('#foo_info_en');
            var foo_price = $('#foo_price');
            var foo_offer = $('#foo_offer');
            var foo_id = $('#foo_id');
            var cat_id = $('#ddlRelationship');

            form_data.append('foo_name', foo_name.val());
            form_data.append('foo_name_en', foo_name_en.val());
            form_data.append('foo_info', foo_info.val());
            form_data.append('foo_info_en', foo_info_en.val());
            form_data.append('foo_price', foo_price.val());
            form_data.append('foo_offer', foo_offer.val());
            form_data.append('cat_id', cat_id.val());
            form_data.append('foo_id', foo_id.val());
         
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/update_product',
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
                        $('.update_product').text('Update');
                    } else {
                        $('#update_msgList').html("");

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').find('input').val('');
                        $('.update_product').text('Update');
                        $('#editModal').modal('hide');
                        fetchProduct();
                    }
                }
            });

        });

        $(document).on('click', '.deletebtn', function () {
            var foo_id = $(this).val();
            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(foo_id);
        });

        $(document).on('click', '.delete_product', function (e) {
            e.preventDefault();

            $(this).text('Deleting..');
            var foo_id = $('#deleteing_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-product/" + foo_id,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_product').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_product').text('Yes Delete');
                        $('#DeleteModal').modal('hide');
                        fetchProduct();
                    }
                }
            });
        });

    });

</script>

 @endsection

