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
Velocity
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
            <h2>{{ __('dashboard.Velocity') }}</h2>
          </div>
       
        </div>
      </div>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
         
            <th>{{ __('dashboard.Velocity') }}</th>
            <th>{{__('dashboard.Action')}}</th>
          </tr>
        </thead>
        <tbody>
         </tbody>
      </table>
         
         
<div id="editModal" class="modal fade" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
                <input type="hidden" id="id" />
           
        <div class="modal-header">            
          <h4 class="modal-title">Edit Velocity</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>

            <ul id="update_msgList"></ul>
            <span id="notmatch_msgList"></span>

            <div class="form-group">
              <label>Distance for kello m</label>
              <input type="text" class="form-control" name="distance" id="distance">
            </div>
            <div class="form-group">
              <label>Time for minutes</label>
              <input type="text" class="form-control" name="time" id="time">
            </div>

        
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <button type="submit" class="btn btn-primary update_velocity">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>

    </div>
  </div>      
</div>

	<script>
    $(document).ready(function () {

        fetchVelocity();
      
        function fetchVelocity() {
            $.ajax({
                type: "GET",
                url: "/fetch-velocity",
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('tbody').html("");
                    $.each(response.velocity, function (key, item) {
                      content = "<tr><td>"+ item.velocity_value + "km / h</td><td><button type='button' value='" + item.id + "' class='btn btn-danger editbtn btn-sm'>Edit</button></td>"
                        
                              
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
                url: "/edit-velocity/" + id,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').modal('hide');
                    } else {
                        // console.log(response.student.name);
                        $('#time').val(response.velocity.time);
                        $('#distance').val(response.velocity.distance);
                        $('#id').val(response.velocity.id);
                    }
                }
            });
            $('.btn-close').find('input').val('');

        });



        $(document).on('click', '.update_velocity', function (e) {
            e.preventDefault();

            $(this).text('Updating..');
             var id = $('#id').val();
            //  alert(id);

            var data = {
                'distance': $('#distance').val(),
                'time': $('#time').val(),
                'id': $('#id').val(),
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'PUT',
                url: '/update_velocity',
              
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
                        $('.update_velocity').text('Update');
                    }  
                    else {
                        $('#update_msgList').html("");

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#editModal').find('input').val('');
                        $('.update_velocity').text('Update');
                        $('#editModal').modal('hide');
                        fetchVelocity();
                    }
                    
                }
            });

        });

    });
     
             
</script>

@endsection
	 