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
 Supplier
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
            <h2>{{__('dashboard.Supplier_table') }}</h2>
          </div>
       
        </div>
      </div>
         <div id="success_message"></div>

      <table class="table table-striped table-hover">
     
        <thead>
          <tr>
            <th>{{__('dashboard.Name') }}</th>
            <th>{{__('dashboard.Phone') }}</th>
            <th>{{__('dashboard.Email') }}</th>
            <th>{{__('dashboard.Note') }}</th>
            <th>{{__('dashboard.Address') }}</th>
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
          <h4 class="modal-title">Delete Supplier</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <p>Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default btn-close" data-dismiss="modal" value="Cancel">

            <input type="hidden" id="deleteing_id">

          <button type="button" class="btn btn-primary delete_supplier">Yes Delete</button>

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
          <h4 class="modal-title">{{ __('dashboard.Edit_Supplier') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <div class="form-group">
            <label>{{__('dashboard.Name_en')}}</label>
            <input  type="text" class="form-control" name="sup_name" id="sup_name">
          </div>

         <div class="form-group">
            <label>{{ __('dashboard.Email') }}</label>
            <input  type="text" class="form-control" name="sup_email" id="sup_email">
          </div>

            <div class="form-group">
            <label>{{ __('dashboard.Phone') }}</label>
            <input  type="text" class="form-control" name="sup_mobile" id="sup_mobile">
          </div>

         <div class="form-group">
            <label>{{ __('dashboard.Note') }}</label>
            <input  type="text" class="form-control" name="sup_note" id="sup_note">
          </div>

         
          <div class="form-group">
            <label>{{ __('dashboard.Address') }}</label>
            <input type="text" class="form-control" name="sup_address" id="sup_address">
          </div>

          <div class="form-group">
            <label>{{ __('dashboard.Password') }}</label>
            <input type="text" class="form-control" name="sup_pwd" id="sup_pwd">
          </div>

          <div class="form-group">
            <label>{{ __('dashboard.Password_confirm') }}</label>
            <input type="text" class="form-control" name="sup_pwd_confirm" id="sup_pwd_confirm">
          </div>

         <input type="hidden" id="sup_id" >
                  <div class="modal-footer">
         
          <input type="button"  class="btn btn-default" data-dismiss="modal" value="Cancel">
            <button type="submit" class="btn btn-primary update_supplier">Update</button>
        </div>
      </div>
    </div>
  </div>

       


      </div>
  </div>        
</div>
@if(auth()->user()->can('supplier-create'))
        <div class="card-footer">
      <div class="row">
               <a href="add_supplier" class="nav-link">
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

        fetchSupplier();
      
        function fetchSupplier() {
            $.ajax({
                type: "GET",
                url: "/fetch-supplier",
                dataType: "json",
                success: function (response) {
                   console.log(response);
                    $('tbody').html("");

                    $.each(response.supplier, function (key, item) {
                      
                       content =  content = "<tr><td>" + item.sup_name + "</td><td>" 
                                           + item.sup_mobile + "</td><td>" 
+ item.sup_email + "</td><td>" 
+ item.sup_note + "</td><td>" 
                                           + item.sup_address + "</td><td>@if(auth()->user()->can('supplier-edit'))<button type='button' value='" + item.sup_id + "' class='btn btn-primary editbtn btn-sm'>Edit</button>@endif @if(auth()->user()->can('supplier-delete'))<button type='button' value='" + item.sup_id + "' class='btn btn-danger deletebtn btn-sm'>Delete</button>@endif</td>"
                          
                        $('tbody').append(content);
                    });
                }
            });
        }

       
        $(document).on('click', '.editbtn', function (e) {
            e.preventDefault();
            var sup_id = $(this).val();
            // alert(cat_id);
            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-supplier/" + sup_id,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').modal('hide');
                    } else {
                        // console.log(response.supplier.name);
                        $('#sup_name').val(response.supplier.sup_name);
                        $('#sup_mobile').val(response.supplier.sup_mobile);
                        $('#sup_note').val(response.supplier.sup_note);
                        $('#sup_email').val(response.supplier.sup_email);
                        $('#sup_address').val(response.supplier.sup_address);
                        $('#sup_id').val(response.supplier.sup_id);
                    
                    }
                }
            });
            $('.btn-close').find('input').val('');

        });

        $(document).on('click', '.update_supplier', function (e) {
            e.preventDefault();

            $(this).text('Updating..');
             var id = $('#sup_id').val();
            // alert(id);

            var data = {
                'sup_name': $('#sup_name').val(),
                'sup_mobile': $('#sup_mobile').val(),
                'sup_note': $('#sup_note').val(),
                'sup_pwd': $('#sup_pwd').val(),
                'sup_email': $('#sup_email').val(),

                'sup_address': $('#sup_address').val(),
                'sup_pwd_confirm': $('#sup_pwd_confirm').val(),
                'sup_id': $('#sup_id').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'PUT',
                url: '/update_supplier',
              
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
                        $('.update_supplier').text('Update');
                    }  
                    if (response.status == 4000) {
                     
                       $('#update_msgList').html("");
                        $('#update_msgList').addClass('alert alert-danger');
                        $('#update_msgList').text(response.message);
                        $('.update_supplier').text('Update');
                    
                    }else {
                        $('#update_msgList').html("");

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').find('input').val('');
                        $('.update_supplier').text('Update');
                        $('#editModal').modal('hide');
                        fetchSupplier();
                    }
                    
                }
            });

        });

        $(document).on('click', '.deletebtn', function () {
            var sup_id = $(this).val();
            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(sup_id);
        });

        $(document).on('click', '.delete_supplier', function (e) {
            e.preventDefault();

            $(this).text('Deleting..');
            var sup_id = $('#deleteing_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-supplier/" + sup_id,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_supplier').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_supplier').text('Yes Delete');
                        $('#DeleteModal').modal('hide');
                        fetchSupplier();
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
