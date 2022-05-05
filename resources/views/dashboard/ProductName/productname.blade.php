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
 Users
@endsection

@section('content')
<body class="bg-theme bg-theme1">
 
<!-- Start wrapper-->
 <div id="wrapper">
 
  <!--Start sidebar-wrapper-->
  
@include('dashboard.header')


<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid" id="table-container">

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
        <thead>
          <tr>
         
            <th>{{__('dashboard.Name')}}</th>

            <th>{{__('dashboard.Action')}}</th>
          </tr>
        </thead>
        <tbody>
         </tbody>
      </table>
         
         
<!-- Edit Modal HTML -->
<div id="editModal" class="modal fade" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
                <input type="hidden" id="id" />
           
        <div class="modal-header">            
          <h4 class="modal-title">{{ __('dashboard.Edit_Product') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>

            <ul id="update_msgList"></ul>
            <span id="notmatch_msgList"></span>

        <div class="modal-body">          
          <div class="form-group">
            <label>{{__('dashboard.Name')}}</label>
            <input  id="pro_name" value="" type="text" class="form-control" >
          </div>  
        </div>

        <select id="ddlRelationship" class="form-control chosen-select" name="ddlRelationship">

        </select>

        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <button type="submit" class="btn btn-primary update_productname">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Delete Modal HTML -->
<div id="DeleteModal" class="modal fade" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
    

        <div class="modal-header">            
          <h4 class="modal-title">{{ __('dashboard.Delete_Product') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <p>Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
              <input type="hidden" id="deleteing_id">

          <button type="button" class="btn btn-primary delete_productname">Yes Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

      
        <div class="card-footer">
      <div class="row">
               <a href="/add_productname" class="nav-link">
                  <button type="submit" class="btn btn-info">Add</button>
                   </a>
                  
                </div>
              </div>
 
    </div>
  </div>        
</div>

	<script>
    $(document).ready(function () {

        fetchProductName();
      
        function fetchProductName() {
            $.ajax({
                type: "GET",
                url: "/fetch-productname",
                dataType: "json",
                success: function (response) {
                     console.log(response);
                    $('tbody').html("");
                    $.each(response.productName, function (key, item) {
                      content = "<tr><td>" + item.pro_name + "</td><<td><button type='button' value='" + item.id + "' class='btn btn-primary editbtn btn-sm'>Edit</button><button type='button' value='" + item.id + "' class='btn btn-danger deletebtn btn-sm'>Delete</button></td>"
                          
   
                        $('tbody').append(content);
                    });

                    
                }
            });
        }

      

        $(document).on('click', '.editbtn', function (e) {
            e.preventDefault();
            var id = $(this).val();
            // alert(cat_id);
            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-productname/" + id,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').modal('hide');
                    } else {
                        // console.log(response.student.name);
                        $('#pro_name').val(response.productName.pro_name);
                        $('#id').val(response.productName.id);

                        var r = response.productName.category.cat_name;

                        var temp = $('#ddlRelationship');
                       
        temp.empty();
        $("#ddlRelationship").append('<option value='+response.productName.cat_id+'>'+r+'</option>');

        $.each(response.category, function (i, data) {                 
    console.log(response.category);
            $('<option>',
               {
                   value: data.cat_id,
                   text: data.cat_name,
               }).html(data.cat_name).appendTo("#ddlRelationship");
        });
                    
                    }
                }
            });
            $('.btn-close').find('input').val('');

        });

        $(document).on('click', '.update_productname', function (e) {
            e.preventDefault();

            $(this).text('Updating..');

             var id = $('#id').val();
             var cat_id = $('#ddlRelationship').val();
            // alert(id);

            var data = {
                'pro_name': $('#pro_name').val(),
                'id': id,
                'cat_id': cat_id,
                
                
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                url: '/update_productname',
              
                data: data,
                dataType: "json",
                success: function (response) {
                     console.log(response);
                    if (response.status == 400) {
                        $('#update_msgList').html("");
                        $('#update_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#update_msgList').append('<li>' + err_value +
                                '</li>');
                        });
                        $('.update_productname').text('Update');
                    }  
                    if (response.status == 4000) {
                     
                       $('#update_msgList').html("");
                        $('#update_msgList').addClass('alert alert-danger');
                        $('#update_msgList').text(response.message);
                        $('.update_productname').text('Update');
                    
                    }else {
                        $('#update_msgList').html("");

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').find('input').val('');
                        $('.update_productname').text('Update');
                        $('#editModal').modal('hide');
                        fetchProductName();
                    }
                    
                }
            });

        });

        $(document).on('click', '.deletebtn', function () {
            var id = $(this).val();
            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(id);
        });

        $(document).on('click', '.delete_productname', function (e) {
            e.preventDefault();

            $(this).text('Deleting..');
            var id = $('#deleteing_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-productname/" + id,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_productname').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_productname').text('Yes Delete');
                        $('#DeleteModal').modal('hide');
                        fetchProductName();
                    }
                }
            });
        });

    });


     
      

</script>

@endsection
	 