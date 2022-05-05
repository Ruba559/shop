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
Permission
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
            <h2>Rule</h2>
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
          <h4 class="modal-title">Edit Permission</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>

            <ul id="update_msgList"></ul>
            <span id="notmatch_msgList"></span>

        <div class="modal-body">          
          <div class="form-group">
            <label>{{__('dashboard.Name')}}</label>
            <input  id="name"  value="" type="text" class="form-control" >
          </div>
          
                  
                               
        </div>
       
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <button type="submit" class="btn btn-primary permission_rule">Update</button>
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
          <h4 class="modal-title">Delete Rule</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <p>Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
              <input type="hidden" id="deleteing_id">

          <button type="button" class="btn btn-primary delete_permission">Yes Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

      @if(auth()->user()->can('permission-create'))
        <div class="card-footer">
      <div class="row">
               <a href="/add_permission" class="nav-link">
                  <button type="submit" class="btn btn-info">Add</button>
                   </a>
                  
                </div>
              </div>
   @endif
     
    </div>
  </div>        
</div>

	<script>
    $(document).ready(function () {

        fetchPermission();
      
        function fetchPermission() {
            $.ajax({
                type: "GET",
                url: "/fetch-permission",
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('tbody').html("");
                    $.each(response.permission, function (key, item) {
                      content = "<tr><td>"+ item.name + "</td><td>@if(auth()->user()->can('permission-edit'))<button type='button' value='" + item.id + "' class='btn btn-primary editbtn btn-sm'>Edit</button>@endif @if(auth()->user()->can('permission-delete'))<button type='button' value='" + item.id + "' class='btn btn-danger deletebtn btn-sm'>Delete</button>@endif</td>"
                          
                              
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
                url: "/edit-permission/" + id,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').modal('hide');
                    } else {
                        // console.log(response.student.name);
                        $('#name').val(response.permission.name);
                        $('#id').val(response.permission.id);
                    
                    }
                }
            });
            $('.btn-close').find('input').val('');

        });

        $(document).on('click', '.update_permission', function (e) {
            e.preventDefault();

            $(this).text('Updating..');
             var id = $('#id').val();
            //  alert(id);

            var data = {
                'name': $('#name').val(),
                'id': $('#id').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'PUT',
                url: '/update_permission',
              
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
                        $('.update_permission').text('Update');
                    }  
                    else {
                        $('#update_msgList').html("");

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').find('input').val('');
                        $('.update_permission').text('Update');
                        $('#editModal').modal('hide');
                        fetchPermission();
                    }
                    
                }
            });

        });

        $(document).on('click', '.deletebtn', function () {
            var id = $(this).val();
            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(id);
        });

        $(document).on('click', '.delete_permission', function (e) {
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
                url: "/delete-permission/" + id,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_permission').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_permission').text('Yes Delete');
                        $('#DeleteModal').modal('hide');
                        fetchPermission();
                    }
                }
            });
        });

    });


     
             
</script>

@endsection
	 