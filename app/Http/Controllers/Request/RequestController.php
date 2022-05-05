<?php

namespace App\Http\Controllers\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\DetailBill;
use App\Models\Delivery;
use App\Models\Product;


class RequestController extends Controller
{


    public function __construct()
    {
         
           $this->middleware('permission:request-list', ['only' => ['show']]);
          // $this->middleware('permission:category-create', ['only' => ['create','store']]);
           //$this->middleware('permission:category-edit', ['only' => ['edit','update']]);
           //$this->middleware('permission:category-delete', ['only' => ['destroy']]);  
    }

    
    public function index()
    {

          $bill = Bill::where('bil_status' , '0')->get();
  
        return view('dashboard.Request.request' , ['bills' => $bill]);

    }


    public function indextodo()
    {

           $bill = Bill::whereIn('bil_status' , ['1' , '2' , '3'])->get();
  
        return view('dashboard.Request.requesttodo' , ['bills' => $bill]);

    }


    public function billBetail(Request $request)
    {

           $bill = Bill::where('bil_id' , $request->bil_id)->first();
           $detailBill = DetailBill::where('bil_id' , $request->bil_id)->get();

           $price = DetailBill::where('bil_id' , $request->bil_id)->sum('det_price');

            $total = DetailBill::where('bil_id' , $request->bil_id)->sum('det_price');
   
  
        return view('dashboard.Request.detail' , [ 'bills' => $bill , 'detailBills' => $detailBill , 
        'total' =>  $total]);

    }



}
