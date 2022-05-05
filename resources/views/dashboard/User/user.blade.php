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
<div class="alert alert-success" id="success_msg" style="display: none;">
        تم الحفظ بنجاح
    </div>
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
        <tbody class="cont-data">
        @foreach ($users as $item)
            
          <tr class="catRow{{$item->use_id}}">
         
            <td>{{$item->use_name}}</td>
            <td>{{$item->use_mobile}}</td>
            <td>{{$item->use_node}}</td>
         

            <td>
           <a href="#editEmployeeModal" data-target="#edit" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
           <a href="#deleteEmployeeModal" data-target="#delete{{ $item->use_id }}" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
            </td>
            <td>
                     @if($item->use_active == 1) 
                     <form method="POST" action="un_active">
                     @csrf
                                                        <button class="badge  p-1 IsConfirm">Active</button>
                                                        <input type="hidden" name="id" value="{{$item->use_id}}">
                                                        </form>
                                                        @endif

                                                        @if($item->use_active == 0) 
                                                        <form method="POST" action="active">
                     @csrf
                                                        <button class="badge  p-1 IsConfirm">UnActive</button>
                                                        <input type="hidden" name="id" value="{{$item->use_id}}">
                                                        </form>
                                                        @endif
                    </td>
          </tr>
         
         
<!-- Edit Modal HTML -->
<div id="edit{{ $item->use_id }}" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('User.update' , 'test') }}" method="POST">
            
           @csrf
           
        <div class="modal-header">            
          <h4 class="modal-title">{{__('dashboard.Edit_User')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <div class="form-group">
            <label>{{__('dashboard.Name')}}</label>
            <input name="use_name" id="use_name" value="" type="text" class="form-control" >
          </div>
           @error('use_name')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
          <div class="form-group">
            <label>{{__('dashboard.Phone')}}l</label>
            <input name="use_mobile" id="use_mobile" value="{{$item->use_mobile}}" type="text" class="form-control" >
          </div>
          
          @error('use_mobile')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
          <div class="form-group">
            <label>{{__('dashboard.Note')}}</label>
            <input name="use_node" id="use_node" value="{{$item->use_node}}" type="text" class="form-control" >
          </div>   
           @error('use_node')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
          <div class="form-group">
            <label>{{__('dashboard.Password')}}</label>
            <input name="use_pwd" id="use_pwd" value="" type="password" class="form-control" >
          </div>  
           @error('use_pwd')
                 <span class="text-danger">{{$message}}</span>
                 @enderror
           <div class="form-group">
            <label>{{__('dashboard.Password_confirm')}}</label>
            <input name="use_pwd_confirm" value="" type="password" class="form-control" >
          </div>  
           @error('use_pwd_confirm')
                 <span class="text-danger">{{$message}}</span>
                 @enderror      
        </div>
        @if(Session::has('message_confirm'))
                     
                      {{Session::get('message_confirm')}}
                                         
                        @endif
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <input type="hidden" name="id"  value="{{$item->use_id}}">
          <input type="submit" class="btn btn-info" value="{{__('dashboard.Edit')}}">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Delete Modal HTML -->
<div id="delete{{$item->use_id}}" class="catRow{{ $item->use_id }} modal fade"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form  method="post">
            {{ method_field('Delete') }}
              @csrf
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
          <input type="hidden" name="id" value="{{$item->use_id}}">
          <input type="button" use_id="{{$item->use_id}}" class="delete_btn btn btn-danger" value="{{__('dashboard.Delete')}}">
        </div>
      </form>
    </div>
  </div>
</div>

  @endforeach
        </tbody>
      </table>
        <div class="card-footer">
      <div class="row">
               <a href="/add_user" class="nav-link">
                  <button type="submit" class="btn btn-info">{{__('dashboard.Add_User')}}</button>
                   </a>
                  
        

                </div>
              </div>
     
    </div>
  </div>        
</div>

	<script>
   $.ajaxSetup({
                    headers: 
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

        $(document).on('click', '.delete_btn', function (e) {
            e.preventDefault();
              var use_id =  $(this).attr('use_id');
            $.ajax({
                type: 'post',
                 url: "/delete_use",
                data: {
                    '_token': "{{csrf_token()}}", 
                    'id' :use_id
                },
               
                success: function (data) {
                    if(data.status == true){
                        $('#success_msg').show();
                    }
                    $('.catRow'+data.id).remove();
                   
                     $('#delete'+data.id).hide();
                    
                }, error: function (reject) {
                }
            });
        });


  
    </script>

@endsection
	 