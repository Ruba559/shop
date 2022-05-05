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
   Categories
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
            <h2>{{__('dashboard.Category_table')}}</h2>
          </div>
       
        </div>
      </div>
       
      <table id="example" name="table" class="table table-striped table-hover">
     
        <thead>
          <tr>
         
            <th>{{__('dashboard.Image')}}</th>
            <th>{{__('dashboard.Name_ar')}}</th>
            <th>{{__('dashboard.Name_en')}}</th>
            <th>{{__('dashboard.Action')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as $item)
          <tr>
           

         <td><img src="{{asset('images/category')}}/{{$item->cat_image}}" class="rounded-circle" width="30" height="20"></td>
            <td>{{ $item->cat_name }}</td>
             <td>{{ $item->cat_name_en }}</td>

           
            <td>
           <a href="#editEmployeeModal" class="edit" data-toggle="modal"  data-target="#2"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
           <a href="#deleteEmployeeModal" class="delete" data-target="#delete{{ $item->cat_id }}" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>  </td>
           
          </tr>
          
        
  


<!-- Delete Modal HTML -->
<div id="delete{{ $item->cat_id }}" class="modal fade"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form  action="delete_category" method="post">
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
           <input  type="hidden" name="id" class="form-control"
                                                    value="{{ $item->cat_id }}">
                     
          <input type="submit" class="btn btn-danger" value="{{__('dashboard.Delete')}}">
        </div>
      </form>
    </div>
  </div>
</div>

 <div id="2" class="modal fade"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
  mmm
      
    </div>
  </div>
  
</div>
</div>
	 @endforeach
        </tbody>
      </table>


      </div>
  </div>        
</div>
        <div class="card-footer">
      <div class="row">
               <a href="/add_category" class="nav-link">
                  <button type="submit" class="btn btn-info">{{__('dashboard.Add_Category')}}</button>
                   </a>
                    
                </div>
              </div>
     
	   </div>
	 </div>
	</div>
  {{-- var degrees = 0;
$('.rotat').click(function rotateMe(e) {

    degrees += 90;

     $('#previewimage').addClass('rotated'); // for one time rotation

    $('.rotated').css({
      'transform': 'rotate(' + degrees + 'deg)',
      '-ms-transform': 'rotate(' + degrees + 'deg)',
      '-moz-transform': 'rotate(' + degrees + 'deg)',
      '-webkit-transform': 'rotate(' + degrees + 'deg)',
      '-o-transform': 'rotate(' + degrees + 'deg)'
    }); 

});   --}}
@endsection


