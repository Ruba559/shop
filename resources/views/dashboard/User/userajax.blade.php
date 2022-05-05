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
            <h2>{{__('dashboard.User_table')}}</h2>
          </div>
       
        </div>
      </div>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
         
            <th>{{__('dashboard.Name')}}</th>
            <th>{{__('dashboard.Phone')}}</th>
            <th>{{__('dashboard.Note')}}</th>
             <th>{{__('dashboard.Action')}}</th>
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
                <input type="hidden" id="use_id" />
           
        <div class="modal-header">            
          <h4 class="modal-title">{{__('dashboard.Edit_User')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>

            <ul id="update_msgList"></ul>
            <span id="notmatch_msgList"></span>

        <div class="modal-body">          
          <div class="form-group">
            <label>{{__('dashboard.Name')}}</label>
            <input  id="use_name" value="" type="text" class="form-control" >
          </div>
          
          <div class="form-group">
            <label>{{__('dashboard.Phone')}}l</label>
            <input  id="use_mobile"  type="text" class="form-control" >
          </div>
          
         
          <div class="form-group">
            <label>{{__('dashboard.Note')}}</label>
            <input id="use_note" type="text" class="form-control" >
          </div>   
          
          <div class="form-group">
            <label>{{__('dashboard.Password')}}</label>
            <input  id="use_pwd" value="" type="password" class="form-control" >
          </div>  
          
           <div class="form-group">
            <label>{{__('dashboard.Password_confirm')}}</label>
            <input id="use_pwd_confirm" value="" type="password" class="form-control" >
          </div>  
              
        </div>
       
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <button type="submit" class="btn btn-primary update_user">Update</button>
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
          <h4 class="modal-title">{{__('dashboard.Delete_User')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <p>Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
              <input type="hidden" id="deleteing_id">

          <button type="button" class="btn btn-primary delete_user">Yes Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if(auth()->user()->can('user-create'))
      
        <div class="card-footer">
      <div class="row">
               <a href="/add_user" class="nav-link">
                  <button type="submit" class="btn btn-info">{{__('dashboard.Add_User')}}</button>
                   </a>
                  
                </div>
              </div>
   @endif
    </div>
  </div>        
</div>

	<script>
    $(document).ready(function () {

        fetchUser();
      
        function fetchUser() {
            $.ajax({
                type: "GET",
                url: "/fetch-user",
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('tbody').html("");
                    $.each(response.user, function (key, item) {
                      content = "<tr><td>" + item.use_name + "</td><td>" 
                                           + item.use_mobile + "</td><td>" 
                                           + item.use_note + "</td><td>@if(auth()->user()->can('user-edit'))<button type='button' value='" + item.use_id + "' class='btn btn-primary editbtn btn-sm'>Edit</button>@endif @if(auth()->user()->can('user-delete'))<button type='button' value='" + item.use_id + "' class='btn btn-danger deletebtn btn-sm'>Delete</button>@endif</td>"
                          
                           
                                         
if (item.use_active == '0'){
  
    content += "<td><button type='button' value=" + item.use_id + " class='btn btn-primary activebtn btn-sm'>Un Active</button></td></tr>";
}
if (item.use_active == '1'){
  
    content += "<td><button type='button' value="  + item.use_id + " class='btn btn-primary unactivebtn btn-sm'>Active</button></td></tr>";
}
   
                        $('tbody').append(content);
                    });

                    
                }
            });
        }

      

        $(document).on('click', '.editbtn', function (e) {
            e.preventDefault();
            var use_id = $(this).val();
            // alert(cat_id);
            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-user/" + use_id,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').modal('hide');
                    } else {
                        // console.log(response.student.name);
                        $('#use_name').val(response.user.use_name);
                        $('#use_mobile').val(response.user.use_mobile);
                        $('#use_note').val(response.user.use_note);
                        $('#use_pwd').val(response.user.use_pwd);
                        $('#use_id').val(response.user.use_id);
                    
                    }
                }
            });
            $('.btn-close').find('input').val('');

        });

        $(document).on('click', '.update_user', function (e) {
            e.preventDefault();

            $(this).text('Updating..');
             var id = $('#use_id').val();
            // alert(id);

            var data = {
                'use_name': $('#use_name').val(),
                'use_mobile': $('#use_mobile').val(),
                'use_note': $('#use_note').val(),
                'use_pwd': $('#use_pwd').val(),
                'use_pwd_confirm': $('#use_pwd_confirm').val(),
                'use_id': $('#use_id').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'PUT',
                url: '/update_user',
              
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
                        $('.update_user').text('Update');
                    }  
                    if (response.status == 4000) {
                     
                       $('#update_msgList').html("");
                        $('#update_msgList').addClass('alert alert-danger');
                        $('#update_msgList').text(response.message);
                        $('.update_user').text('Update');
                    
                    }else {
                        $('#update_msgList').html("");

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').find('input').val('');
                        $('.update_user').text('Update');
                        $('#editModal').modal('hide');
                        fetchUser();
                    }
                    
                }
            });

        });

        $(document).on('click', '.deletebtn', function () {
            var use_id = $(this).val();
            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(use_id);
        });

        $(document).on('click', '.delete_user', function (e) {
            e.preventDefault();

            $(this).text('Deleting..');
            var use_id = $('#deleteing_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-user/" + use_id,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_user').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_user').text('Yes Delete');
                        $('#DeleteModal').modal('hide');
                        fetchUser();
                    }
                }
            });
        });

    });


     
        $(document).on('click', '.activebtn', function (e) {
            e.preventDefault();

            var use_id = $(this).val();
            $(this).text('Sending..');

            var data = {
               
                'id': use_id,
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/active-user",
                data: data,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 400) {
                        $('#save_msgList').html("");
                        $('#save_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#save_msgList').append('<li>' + err_value + '</li>');
                        });
                        $('.activebtn').text('Save');
                    } else {
                        $('#save_msgList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                     //   $('#AddStudentModal').find('input').val('');
                        $('.activebtn').text('Active done');
                       // $('#AddStudentModal').modal('hide');
                        fetchUser();
                    }
                }
            });

        });
         $(document).on('click', '.unactivebtn', function (e) {
            e.preventDefault();

            var use_id = $(this).val();
            $(this).text('Sending..');

            var data = {
               
                'id': use_id,
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/unactive-user",
                data: data,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 400) {
                        $('#save_msgList').html("");
                        $('#save_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#save_msgList').append('<li>' + err_value + '</li>');
                        });
                        $('.unactivebtn').text('Save');
                    } else {
                        $('#save_msgList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                     //   $('#AddStudentModal').find('input').val('');
                        $('.unactivebtn').text('un Active done');
                       // $('#AddStudentModal').modal('hide');
                        fetchUser();
                    }
                }
            });

        });
</script>

@endsection
	 