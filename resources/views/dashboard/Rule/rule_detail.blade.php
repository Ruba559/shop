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
  Rule
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
            <h2>{{ $role->name }}</h2>
         <input type="hidden" value="{{ $role->name }}" id="role_name">
          </div>
       
        </div>
      </div>
       
      <table id="example" name="table" class="table table-striped table-hover">
     
        <thead>
          <tr>
         
            <th>Permission Name</th>
            <th>{{__('dashboard.Action')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rolePermissions as $item)
          <tr class="rowrule{{$item->id}}">
           

             <td>{{ $item->name }}</td>
      

           
            <td>
            
           <button type="button" value="{{$item->name}}" class="btn btn-primary deletebtn btn-sm">Delete</button>  </td>         
          </tr>
          
        
  


<!-- Delete Modal HTML -->
<div id="DeleteModal" class="modal fade"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form  action="delete_permission" method="post">
              @csrf
        <div class="modal-header">            
          <h4 class="modal-title">{{__('dashboard.Delete_Category')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <p>Are you sure you want to delete these Records?</p>
          <p class="text-warning"><small>This action cannot be undone.</small></p>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
           <input  type="hidden" name="name" id="deleteing_id" class="form-control"
                                                    value="">
           <input  type="hidden" name="name" id="role_name" class="form-control"
                                                    value="">

          <input type="button" class="btn btn-danger delete_per" value="{{__('dashboard.Delete')}}">
        </div>
      </form>
    </div>
  </div>
</div>

<div id="editModal" class="modal fade" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
                <input type="hidden" id="rul_id" />
           
        <div class="modal-header">            
          <h4 class="modal-title">{{ __('dashboard.Edit_rule') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>

            <ul id="update_msgList"></ul>
            <span id="notmatch_msgList"></span>

            <div class="form-group">
              @foreach ($permissions as $item)
              <label>{{ $item->name }}</label>
              <input id="per" type="radio" name="permission[]" value="{{ $item->name }}">
              <br>
              @endforeach
            </div>

        <input  type="hidden" name="name" id="role_name" class="form-control" value="">
        
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <button type="submit" class="btn btn-primary update_rule">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>



	 @endforeach
        </tbody>
      </table>

          <button type='button' class='btn btn-primary editbtn btn-sm'>Add</button>

      </div>
  </div>        
</div>


<script>
   
   $(document).ready(function () {

          $(document).on('click', '.deletebtn', function () {
            var name = $(this).val();
            var role_name = $('#role_name').val();

            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(name);
        });

        $(document).on('click', '.delete_per', function (e) {
            e.preventDefault();

            $(this).text('Deleting..');

            var name_p = $('#deleteing_id').val();
            var role_name = $('#role_name').val();

                 var data = {

                 'role_name': role_name,
                 'permission_name': name_p,
               
                            }
       
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                data : data ,
                url: "/delete_permission",
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_category').text('Yes Delete');
                        
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_category').text('Yes Delete');
                        $('#DeleteModal').modal('hide');
                        $(".table").load(location.href + " .table");
                    }
                }
            });
        });


        $(document).on('click', '.editbtn', function () {

            
            var role_name = $('#role_name').val();

            $('#editModal').modal('show');
           // $('#deleteing_id').val(name);
        });

        $(document).on('click', '.update_rule', function (e) {
            e.preventDefault();

            $(this).text('Update..');

            var per = $('#per').val();
            var role_name = $('#role_name').val();

            var checkbox_value = "";
    // $(":checkbox").each(function () {
    //     var ischecked = $(this).is(":checked");
    //     if (ischecked) {
    //         checkbox_value += $(this).val() + "|";
    //     }
    // });

 
    $(":radio").each(function () {
        var ischecked = $(this).is(":checked");
        if (ischecked) {
            checkbox_value = $(this).val();
        }
    });

   // alert(checkbox_value);
    

                 var data = {

                 'role_name': role_name,
                 'per_name': checkbox_value,
               
                            }
       
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                data : data ,
                url: "/add_permission",
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.update_rule').text('Yes add');
                        
                    } else {
                      console.log(response);
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.update_rule').text('Yes add');
                        $('#editModal').modal('hide');
                        $(".table").load(location.href + " .table");
                    }
                }
            });
        });

});

</script>
@endsection


