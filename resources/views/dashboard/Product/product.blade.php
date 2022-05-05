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
            <h2>{{__('dashboard.Product_table')}}</h2>
          </div>
       
        </div>
      </div>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
             <th>{{__('dashboard.Image')}}</th>
             <th>{{__('dashboard.Name_ar')}}</th>
             <th>{{__('dashboard.Name_en')}}</th>
             <th>{{__('dashboard.Category')}}</th>
             <th>{{__('dashboard.Note')}}</th>
             <th>{{__('dashboard.Info')}}</th>
             <th>{{__('dashboard.Price')}}</th>
             <th>{{__('dashboard.Offer')}}</th>
             <th>{{__('dashboard.Action')}}</th>
             <th>{{__('dashboard.Action')}}</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($products as $item)
       
          <tr>
            <td><img src="{{asset('images/food')}}/{{$item->foo_image}}" class="rounded-circle" width="40"></td>
            <td>{{$item->foo_name}}</td>
            <td>{{$item->foo_name_en}}</td>
            @if(isset($item->category->cat_name))
            <td>{{$item->category->cat_name}}</td>
            @else  
            <td>empty</td>
            @endif
            <td>{{$item->foo_info_en}}</td>
            <td>{{$item->foo_info}}</td>
            <td>{{$item->foo_price}}</td>
            <td>{{$item->foo_offer}}</td>
             <td>
            <select class="myselect custom-select form-control-border">

              @foreach ($item->productSuppliers as $row) 
              <option value="{{ $row->price }}/{{$item->foo_id}}">  price : {{ $row->price }}</option>
               @endforeach
              
            </select>
            </td>
           
            <td> 
             <input class="p" type="text" value=""/>
             <input class="idd" type="hidden" value="{{$item->foo_id}}"/>
            </td>

              @php 
              $c = DB::table('food_suppliers')->where('foo_id' , $item->foo_id)->max('price');
              @endphp
            {{-- <td>
              {{ $c }}
            </td> --}}

            <td>
          
           <a href="#editEmployeeModal" class="edit" data-toggle="modal"  data-target="#edit{{ $item->foo_id }}"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
              <a href="#deleteEmployeeModal"  data-target="#delete{{ $item->foo_id }}" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
            </td>
          </tr>
         
<!-- Delete Modal HTML -->
<div id="delete{{ $item->foo_id }}" class="modal fade"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="delete_product">
                @csrf
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
          <input type="hidden" name="id" value="{{ $item->foo_id }}">
          <input type="submit" foo_id="{{$item->foo_id}}" class="delete_btn btn btn-danger" value="{{__('dashboard.Delete')}}">
        </div>
      </form>
    </div>
  </div>
</div>


<div id="edit{{ $item->foo_id }}" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <form method="POST" action="update_product" enctype="multipart/form-data">
       
            @csrf
        <div class="modal-header">            
          <h4 class="modal-title">{{__('dashboard.Edit_Product')}}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">          
          <div class="form-group">
            <label>{{__('dashboard.Name_ar')}}</label>
            <input type="text" class="form-control" name="foo_name" value="{{ $item->foo_name}}">
          </div>
         
          <div class="form-group">
            <label>{{__('dashboard.Name_en')}}</label>
            <input type="text" class="form-control" name="foo_name_en" value="{{ $item->foo_name_en }}">
          </div>
                      
                     
            <div class="form-group">
            <label>{{__('dashboard.Info')}}</label>
            <input type="text" class="form-control" name="foo_info" value="{{ $item->foo_info }}">
          </div>
         
          <div class="form-group">
            <label>{{__('dashboard.Note')}}</label>
            <input type="text" class="form-control" name="foo_info_en" value="{{ $item->foo_info_en }}">
          </div>
            <div class="form-group">
            <label>{{__('dashboard.Price')}}</label>
            <input type="text" class="form-control" name="foo_price" value="{{ $item->foo_price }}">
          </div>
            <div class="form-group">
            <label>{{__('dashboard.Offer')}}</label>
            <input type="text" class="form-control" name="foo_offer" value="{{ $item->foo_offer }}">
          </div>
                  <div class="form-group">
                  <label>{{__('dashboard.Category')}}</label>
                  <select name="cat_id" class="select2"  data-placeholder="" style="width: 100%;">
                    @foreach ($categories as $category)
                    <option value="{{ $category->cat_id }}">{{ $category->cat_name }}</option>
                    @endforeach
                  </select>
                </div> 
                
               <div class="form-group" >
                    <label for="exampleInputFile"></label>
                    <div class="input-group" style="border-radius:30px;">
                     <img src="{{asset('images/product')}}/{{$item->foo_image}}" class="rounded-circle" width="40">
                      <div class="custom-file">
                        <input name="foo_image" type="file" onchange="previewFile(this)" class="custom-file-input" id="exampleInputFile">
                       
                        <label class="custom-file-label" for="exampleInputFile">{{__('dashboard.select_image')}}</label>
                     
                      </div>
                            <img id="previewImg" alt="image">
                   
         
                    </div>
                  </div>
          
                   </div>
        <div class="modal-footer">
          <input type="hidden" name="id" value="{{ $item->foo_id }}">
          <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
          <input type="submit" class="btn btn-info" value="{{__('dashboard.Edit')}}">
        </div>
      </form>
    </div>
  </div>

 @endforeach
        </tbody>
      </table>
        <div class="card-footer">
      <div class="row">
               <a href="add_product" class="nav-link">
                  <button type="submit" class="btn btn-info">{{__('dashboard.Add_Product')}}</button>
                   </a>
                 
                </div>
              </div>
    </div>
  </div>        
</div>


	   </div>
	 </div>
	</div>


  <script>

    $(document).ready(function () {


      $(".p").change(function(){

var p = $(this).val();

var id = $(".idd").val();
alert(id);
var data = {
    'id': id,
    'p': p,
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    type: "POST",
    url: "/p",
    data: data,
    dataType: "json",
    success: function (response) {
        console.log(response);
   
    }
});


});

      $(".myselect").change(function(){

           
 console.log( $(this).val());
           
            // var data = {
               
            //     'id': use_id,
            // }

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });

            // $.ajax({
            //     type: "POST",
            //     url: "/unactive-user",
            //     data: data,
            //     dataType: "json",
            //     success: function (response) {
            //         // console.log(response);
               
            //     }
            // });

        });
      });

</script>
 @endsection

