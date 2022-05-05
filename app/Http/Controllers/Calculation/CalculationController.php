<?php

namespace App\Http\Controllers\Calculation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailBill;
use App\Models\Bill;
use App\Models\Delivery;
use App\Models\ProductSupplier;
use Abdullah\UserGeoLocation\GeoLocation;
use Geocoder;
use DB;
use Carbon\Carbon;


class CalculationController extends Controller
{ 
    
  
    // public function index()
    // {
      
    //   $bill = Bill::get();

    //   $bill->each(function($p){
    //     $p->detailBills->each(function($detail) use ($p){
    //     $p->sumPriceCustomer = $detail->where('bil_id' , $p->bil_id)->sum('det_price');
    //     $p->x = $detail->supplier->sup_log;
    //     $p->y = $detail->supplier->sup_lat;
      
    //     $p->fee = $this->distance($p->customer->cus_lan , $p->customer->cus_lat , $detail->supplier->sup_log , $detail->supplier->sup_lat , 'K');
    //     //$p->total = $this->getFarSupplier($p->customer->cus_lat , $p->customer->cus_lan );

    //       //  unset($p->detailBills);
    //
    //       });
    //    });
    //     // foreach ($bill->detailBills as $key => $value) {
    // 
    //     //   if($key == 1)
    //     //   {
    //     //    $xx =  $value->x;
    //     //    $yy =  $value->y;

    //     //   }
    //     //   if($key > 1)
    //     //   {
    //     //  $d =  $this->distance($xx , $yy , $value->x , $value->y , 'K');
    //     //  return $d;
    //     //   }

    //     // }
    //   // return $x;
    //    return view('dashboard.Calculate.calculate' , ['bills' => $bill ]);

    // }


    public function index()
    {
        
      $bill = Bill::with('detailBills')->get();
     
        return view('dashboard.Calculate.calculate' , ['bills' => $bill ]);
    }


    public function indexProfit()
    {
  
      $bill = Bill::with('detailBills')->get();
     
        return view('dashboard.Calculate.profit', ['bills' => $bill ]);
    }


    public function calculationDelivery()
    {
     
       $delivery = Delivery::get();
       
        return view('dashboard.Calculate.calculatdelivery'  , ['deliveries' => $delivery ]);
    }


    public function showDelivery(Request $request)
    {

        $delivery_id = $request->id;
        $s_date = $request->s_date;
        $e_date = $request->e_date;

     
        if($s_date)
        {
          $bill = Bill::where('del_id' , $delivery_id)->whereDate('bil_regdate', '>=', $s_date)                                 
          ->whereDate('bil_regdate', '<=', $e_date)    
         ->with('detailBills')->get();

        }else
        { 
          $bill = Bill::where('del_id' , $delivery_id)->whereDate('bil_regdate' , Carbon::today()->toDateTimeString() )->with('detailBills')->get();
        }
       
        $bill->each(function($p){
        $p->detailBills->each(function($detail) use ($p){
        $p->sumPriceCustomer = $detail->where('bil_id' , $p->bil_id)->sum('det_price');
        $p->sumPriceSupplier = $detail->where('bil_id' , $p->bil_id)->sum('price');
        $p->sumPrice = ($p->sumPriceCustomer - $p->sumPriceSupplier);
        $p->rate = $p->delivery->del_rate;
        $p->fee = $this->distance($p->customer->cus_lan , $p->customer->cus_lat , '22' , '444' , 'K');
        $p->total = ($p->sumPrice + $p->fee);
        $p->n = (int)($p->rate * $p->total / 100);
            unset($p->detailBills);

          });
       });

       if($bill)
       {
          return response()->json([
              'status'=>200,
               'bill'=> $bill,
             
          ]);
       }
      
      return view('dashboard.Calculate.calculatdelivery' , ['bills' => $bill ]);
    
    }


    public static function distance($lat1, $lon1, $lat2, $lon2, $unit) 
    {
         if (($lat1 == $lat2) && ($lon1 == $lon2)) {
           return 6666;
         }
 
         else {
           $theta = $lon1 - $lon2;
           $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
           $dist = acos($dist);
           $dist = rad2deg($dist);
           $miles = $dist * 60 * 1.1515;
           $unit = strtoupper($unit);
         
                   if ($unit == "K") {
                     return (int)(($miles * 1.609344)*1000);
                   } else if ($unit == "N") {
                     return (int)($miles * 0.8684);
                   } else {
                     return (int)$miles;
           }
   }

 }


//  public static function getNearBy($lat, $lng, $distance, $distanceIn = 'miles')
// {

//    if ($distanceIn == 'km') 
//    {
//       $results = self::select(['*', DB::raw('( 0.621371 * 3959 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians(lat) ) ) ) AS distance')])->havingRaw('distance < '.$distance)->get();
//    }else{
//       $results = self::select(['*', DB::raw('( 3959 * acos( cos( radians('.$lat.') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('.$lng.') ) + sin( radians('.$lat.') ) * sin( radians(lat) ) ) ) AS distance')])->havingRaw('distance < '.$distance)->get();
//     }
  
//          return $results;

// }


public function getFarSupplier($lng,$lat)
{
  
  $suppliers = DB::table('suppliers')->select('*',DB::raw("6371 * acos(cos(radians(" . floatval($lat) . "))
            * cos(radians(sup_lat)) * cos(radians(sup_log) - radians(" . floatval($lng) . "))
            + sin(radians(" . $lat . ")) * sin(radians(sup_lat))
              ) AS distance"))->having('distance' , '<' , floatval('100000'))->orderBy('distance','desc')->first();

  return $suppliers->sup_id;

}


 public function getUserDistance($lng,$lat)
 {

    $user = DB::table('delivery')->select('*',DB::raw("6371 * acos(cos(radians(" . floatval($lat) . "))
             * cos(radians(del_lat)) * cos(radians(del_log) - radians(" . floatval($lng) . "))
             + sin(radians(" . $lat . ")) * sin(radians(del_lat))
               ) AS distance"))->first();

   return $user->distance; 

 }


 public function calculate()
 {
       echo $this->distance(33.51803174101151, 36.29347570831841, 33.51852311544176, 36.294376398935256, "M") . "Miles<br>";
       echo $this->distance(33.51803174101151, 36.29347570831841, 33.51852311544176, 36.294376398935256, "K") . "Kilometers<br>";
       echo $this->distance(33.51803174101151, 36.29347570831841, 33.51852311544176, 36.294376398935256, "N") . "Nautical Miles<br>";   
 }


}
