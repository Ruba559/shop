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
<style>

 body {
    color: #000;
    overflow-x: hidden; 
    height: 100%;
    background-color: #8C9EFF;
    background-repeat: no-repeat
}

.card {
    z-index: 0;
    background-color: #ECEFF1;
    padding-bottom: 20px;
    margin-top: 90px;
    margin-bottom: 90px;
    border-radius: 10px
}

.top {
    padding-top: 10px;
    padding-left: 11% !important;
    padding-right: 11% !important
}

#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: #455A64;
    padding-left: 0px;
    margin-top: 30px
}

#progressbar li {
    list-style-type: none;
    font-size: 13px;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400
}

#progressbar .step0:before {
    font-family: FontAwesome;
    content: "\f10c";
    color: #fff
}

#progressbar li:before {
    width: 40px;
    height: 40px;
    line-height: 45px;
    display: block;
    font-size: 20px;
    background: #C5CAE9;
    border-radius: 50%;
    margin: auto;
    padding: 0px
}

#progressbar li:after {
    content: '';
    width: 100%;
    height: 8px;
    background: #C5CAE9;
    position: absolute;
    left: 0;
    top: 101px;
    z-index: -1
}

#progressbar li:last-child:after {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    position: absolute;
    left: -50%
}

#progressbar li:nth-child(2):after,
#progressbar li:nth-child(3):after {
    left: -50%
}

#progressbar li:first-child:after {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    position: absolute;
    left: 50%
}

#progressbar li:last-child:after {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px
}

#progressbar li:first-child:after {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px
}

#progressbar li.active:before,
#progressbar li.active:after {
    background: #5cb85c
}

#progressbar li.active:before {
    font-family: FontAwesome;
    content: "\f00c"
}

.icon {
    width: 30px;
    height: 30px;
    margin-right: 15px
}

.icon-content {
    padding-bottom: 20px
}

@media screen and (max-width: 992px) {
    .icon-content {
        width: 50%
    }
}
</style>

@endsection
@section('title')
  Delivery
@endsection

@section('content')

<body dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}" class="bg-theme bg-theme1">
 
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
            <h2>{{__('dashboard.Delivery_table')}}</h2>
          </div>
       
        </div>
      </div>
        <form action="/filter" method="POST">
                    {{ csrf_field() }}
                    <select class="selectpicker" data-style="btn-info" name="status" required
                            onchange="this.form.submit()">
                        <option value="" selected disabled>Search By</option>
                        
                            <option value="1">Working</option>
                            <option value="0">Out Of Working</option>
                            <option value="2">Free</option>
                        
                    </select>
                </form>
      <table id="datatable" class="table table-striped table-hover">
     
        <thead>
          <tr>

            <th>{{__('dashboard.Delivery_name')}}</th>
            <th>{{__('dashboard.Detail')}}</th>
                     
            <th>{{__('dashboard.Status')}}</th>
           
          </tr>
        </thead>
        <tbody>
           @if(isset($search)) 
             <?php $List = $search; ?>
                    @else

                     <?php $List = $deliveries; ?>
                    @endif

          @foreach ($List as $item)
                         <tr>
           
            <td>{{ $item->del_name }}</td>

            <td>   
                  <select class="custom-select form-control-border" id="exampleSelectBorder">
                   @foreach ($item->bills as $row)
                  <option> Bill Number : {{ $row->bil_id }} Customer :  {{ $row->customer->cus_name }}</option>
                    @endforeach
                   
                  </select>
                
</td>
            
           <td>
        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <ul id="progressbar" class="text-center">
                    <li class="active step0"></li>
                     @if($item->del_status == 2 ) 
                    <li class="active step0"></li>
                    <li class=" step0"></li>
                    <li class="step0"></li>
                     @endif
                     @if($item->del_status == 1 )
                    <li class="active step0"></li>
                    <li class="active step0"></li>
                    <li class="step0"></li>
                    @endif
                    @if($item->del_status == 0 ) 
                    <li class="active step0"></li>
                    <li class="active step0"></li>
                    <li class="active step0"></li>
                     @endif
                </ul>
            </div>
        </div>

        <div class="row justify-content-between top">
            <div class="row d-flex icon-content">@if($item->del_status ==! 0 )  
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">{{__('dashboard.Order')}}<br>{{__('dashboard.Processed')}}</p>
                </div> @endif
            </div>
            <div class="row d-flex icon-content">@if($item->del_status ==! 0 ) 
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">{{__('dashboard.Order')}}<br>{{__('dashboard.Shipped')}}</p>
                </div> @endif
            </div>
            <div class="row d-flex icon-content">@if($item->del_status ==! 0 ) 
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">{{__('dashboard.Order')}}<br>{{__('dashboard.En_Route')}}</p>
                </div>@endif
            </div>
            <div class="row d-flex icon-content"> 
                <div class="d-flex flex-column">
                    <p class="font-weight-bold">{{__('dashboard.Order')}}<br>{{__('dashboard.Arrived')}}</p>
                </div>
            </div>
        </div>
  

</td> 

 @endforeach
 
        </tbody>
      </table>


      </div>
  </div>        
</div>
       
     
	   </div>
	 </div>
	</div>

@endsection


