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
Rules
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
            <h2>{{ __('dashboard.Rule') }}</h2>
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

<!-- Delete Modal HTML -->
<div id="DeleteModal" class="modal fade" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
    

        <div class="modal-header">            
          <h4 class="modal-title">{{ __('dashboard.Delete_Rule') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <p>Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
              <input type="hidden" id="deleteing_id">

          <button type="button" class="btn btn-primary delete_rule">Yes Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

      @if(auth()->user()->can('rule-create'))
        <div class="card-footer">
      <div class="row">
               <a href="/add_rule" class="nav-link">
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

        fetchRule();
      
        function fetchRule() {
            $.ajax({
                type: "GET",
                url: "/fetch-rule",
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('tbody').html("");
                    $.each(response.role, function (key, item) {
                      content = "<tr><td>"+ item.name + "</td><td>@if(auth()->user()->can('rule-edit'))@endif @if(auth()->user()->can('rule-delete'))<button type='button' value='" + item.id + "' class='btn btn-danger deletebtn btn-sm'>Delete</button>@endif <a href='detail-rule/" + item.id + "' class='btn btn-primary btn-sm'>Detail</a></td>"
                        
                              
                        $('tbody').append(content);
                    }); 

                    
                }
            });
        }

      

        $(document).on('click', '.editbtn', function (e) {
            e.preventDefault();
            var rul_id = $(this).val();
            // alert(cat_id);
            $('#editModal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-rule/" + rul_id,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').modal('hide');
                    } else {
                        // console.log(response.student.name);
                        $('#rul_name').val(response.rule.rul_name);
                        $('#rul_id').val(response.rule.rul_id);
                    
                    }
                }
            });
            $('.btn-close').find('input').val('');

        });

       
            $(document).on('click', '.detail', function (e) {
            e.preventDefault();
            var id = $(this).val();
           //  alert(id);
          
            $.ajax({
                type: "GET",
                url: "/detail-rule/" + id,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);

                    } else {
                         console.log(response.Role);
                        //$('#rul_name').val(response.rule.rul_name);
                        //$('#rul_id').val(response.rule.rul_id);
                    
                    }
                }
            });
          

        });



        $(document).on('click', '.update_rule', function (e) {
            e.preventDefault();

            $(this).text('Updating..');
             var id = $('#rul_id').val();
            //  alert(id);

            var data = {
                'rul_name': $('#rul_name').val(),
                'rul_id': $('#rul_id').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'PUT',
                url: '/update_rule',
              
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
                        $('.update_rule').text('Update');
                    }  
                    else {
                        $('#update_msgList').html("");

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').find('input').val('');
                        $('.update_rule').text('Update');
                        $('#editModal').modal('hide');
                        fetchRule();
                    }
                    
                }
            });

        });

        $(document).on('click', '.deletebtn', function () {
            var rul_id = $(this).val();
            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(rul_id);
        });

        $(document).on('click', '.delete_rule', function (e) {
            e.preventDefault();

            $(this).text('Deleting..');
            var rul_id = $('#deleteing_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-rule/" + rul_id,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_rule').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_rule').text('Yes Delete');
                        $('#DeleteModal').modal('hide');
                        fetchRule();
                    }
                }
            });
        });

    });


     
             
</script>

@endsection
	 