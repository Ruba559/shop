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
            <h2>{{ __('dashboard.Calculation') }}</h2>
          </div>
       
        </div>
      </div>
      <br><br>
      <!--Blue select-->


<label for="exampleSelectBorder">{{ __('dashboard.select_delivery') }}</label><br>
<select name="del_id" class="myselect custom-select form-control-border" id="exampleSelectBorder">
 @foreach ($deliveries as $item)
  <option value="{{ $item->del_id }}">{{ $item->del_name }}</option>
  @endforeach
 
</select>
<br>

<input type="date" class="myselect" value="" name="s_date" id="s_date">
<input type="date" class="myselect" value="" name="e_date" id="e_date">


      <br><br><br>

      <table class="table table-striped table-hover"  id="sup">
        <thead>
          <tr>
         
            <th>{{ __('dashboard.Bill_number') }}</th>
            <th>{{ __('dashboard.Profit') }}</th>
            <th>{{ __('dashboard.Bill_fee') }}</th>
            <th>{{ __('dashboard.Delivery_rate') }}</th>
            <th>{{ __('dashboard.Total') }}</th>
            <th>{{ __('dashboard.net_delivery_Profit') }}</th>

          </tr>
        </thead>
                    
        <tbody class="view">

        </tbody>
      </table>
     
    </div>
  </div>        
</div>

<script type="text/javascript">

  $(document).ready(function () {
     $("#sup").hide();
     
    $(".myselect").change(function(e){
           e.preventDefault();
    var id = $(this).val();
    var e_date = $('#e_date').val();
    var s_date = $('#s_date').val();

    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({

                type: "post",
                url: "/show_delivery",
                data: {'id':id , 'e_date': e_date , 's_date': s_date},
                dataType: "json",
                success: function (response) {
                  if (response.status == 404) {
                    $(".no").append('no resulte');

                    }else{
                    
                      $(".view").empty().hide(200);
                      
                     $.each(response.bill, function (key, item) { 
                     
                       $(".view").fadeOut(200 , function(){
                       $(this).append('<tr><td>'+item.bil_id+'</td><td>'+item.sumPrice+'</td><td>'+item.fee+'</td><td>'+item.rate+'</td><td>'+item.total+'</td><td>'+item.n+'</td></tr>').show(200);
                       });

                   });
  		   
                     $("#sup").show(600);

                 }
                }
            });

          });
      });

  </script> 

@endsection
	 