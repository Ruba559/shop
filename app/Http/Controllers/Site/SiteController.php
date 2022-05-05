<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\Favorite;
use App\Models\Bill;
use App\Models\Supplier;
use App\Models\DetailBill;
use App\Models\ProductSupplier;
use App\Models\Advertising;
use App\Models\Delivery;
use App\Models\Velocity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Abdullah\UserGeoLocation\GeoLocation;
use Geocoder;
use DB;


class SiteController extends Controller
{
   

    public function index(Request $request)
    { 
       
        $category = Category::take(2)->get();
        $categoryall = Category::get();
        $products = Product::get();
        $product_offer = Product::where('foo_offer' , '<>', '0' )->get();
        $advertising = Advertising::get();
        $all = Category::with('products')->get();

        return view('site.index' , ['categories' => $category , 'category' => $categoryall , 'products' => $products ,
         'product_offers' => $product_offer , 'advertising' => $advertising , 'all' => $all ]);
       
    }


    public function indexLogin()
    { 

          $categoryall = Category::get();

          return view('site.login' , ['category' => $categoryall ]);
       
    }


    public function indexRegister()
    { 

          $categoryall = Category::get();

          return view('site.register' , ['category' => $categoryall ]);
       
    }


    public function indexCart()
    {  

          $categoryall = Category::get();

          return view('site.cart' , ['category' => $categoryall ]);
       
    }


    public function indexAboutUs()
    {  

          $categoryall = Category::get();

          return view('site.about-us' , ['category' => $categoryall ]);
       
    }


    public function Thankyou()
    {  

          $categoryall = Category::get();

          return view('site.thankyou' , ['category' => $categoryall ]);
       
    }



    public function detailProduct($id)
    {

        $product = Product::where('foo_id' , $id)->first();
        $category = Category::get();

        return view('site.detail', ['product' => $product , 'category' => $category]);
              
    }


    public function autoComplete(Request $request)
    {

         return Product::select('foo_name')
        ->where('foo_name', 'like', "%{$request->term}%")
        ->pluck('foo_name');

    }


    public function Search(Request $request)
    {
      
        $category_id = $request->input("product-cate");
        $q = $request->search;
       
      if(!$category_id){
	    if($q != ""){
       
	    	$product = Product::where( 'foo_name', 'LIKE', '%' . $q . '%' )->first();
               
		  if ($product){
                    $id = $product->foo_id;

	                return redirect()->route('detail_product' ,  [$id]);

                   }
	   	else
			      return redirect('/');
	       }
      }
      if($category_id){

          $product = Product::where( 'foo_name', 'LIKE', '%' . $q . '%' )->where('cat_id' , $category_id)->first();
                  
        if ($product){
          
                    $id = $product->foo_id;
                    return redirect()->route('detail_product' ,  [$id]);
  
                     } 
         else
              return redirect('/');
           
        }
  
	              return redirect('/');
      
    }
 

    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["foo_q"] = $request->quantity;
            session()->put('cart', $cart);
           
        }
    }


    // public function more_data(Request $request)
    // {
        
    //     if($request->ajax()){
    //         $skip=$request->skip;
    //         $take=4;
    //         $products=Product::skip($skip)->take($take)->get();
    //
    //         return response()->json($products);
    //     }else{
    //         return response()->json('Direct Access Not Allowed!!');
    //     }
    // }


    public function indexproduct()
    {
       
        $category = Category::take(3)->get();
        $product = Product::get();
        $product_offer = Product::where('foo_offer' , '<>', '0' )->take(3)->get();
        $advertising = Advertising::get();
        
        return view('index' , ['categories' => $category , 'products' => $product ,
         'product_offers' => $product_offer , 'advertising' => $advertising]);

        return view('indexproduct');

    }


    // public function addBill(Request $request)
    // {
        
    //      $bill = Bill::updateOrCreate([

    //        'del_id' => $this->getNearDelivery(auth('customer')->user()->cus_lan  , auth('customer')->user()->cus_lat ),
    //        'bil_address' => $this->getNearSupplier(auth('customer')->user()->cus_lan  , auth('customer')->user()->cus_lat ),
    //        'bil_before_note' => $request->bil_before_note,
    //        'bil_rate' => 'rate',
    //        'bil_after_note' => 'note',
	//           'bil_status' => 3,
    //        'bil_regdate' => Carbon::now(),
    //        'cus_id' => auth('customer')->user()->cus_id,

    //      ]);
          


    //       $detailBill = new  DetailBill();

    //      $sup_id = ProductSupplier::where('foo_id' , $request->product_id)->pluck('sup_id')->first();

    //          $detailBill->foo_id = $request->product_id;
    //          $detailBill->det_price = $request->product_price;
    //          $detailBill->det_qty = $request->product_qty;
    //          $detailBill->bil_id = $bill->bil_id;  
    //          $detailBill->sup_id = $sup_id;
          
    //      $bill->detailBills()->save($detailBill);

    //      return response()->json($sup_id);

    // }



       public function addBillb(Request $request)
      {

       if ($request->session()->exists('cart')) {

           $bill = new  Bill();
           
           $bill->del_id = '1';
           $bill->bil_address = 'nn';
           $bill->bil_before_note = 'note';
           $bill->bil_rate = 'rate';
           $bill->bil_after_note = 'note';
	         $bill->bil_status = 3;
           $bill->bil_regdate = Carbon::now();
           $bill->cus_id = auth('customer')->user()->cus_id;
           $bill->expected_distance	 = '0';
           $bill->expected_time	 = '0';
           $bill->save(); 

           $id_bil = $bill->bil_id;
          
         $cart = session()->get('cart');

        foreach($cart as  $c)
         {

           $id = ProductSupplier::where('foo_id' , $c["foo_id"])->pluck('sup_id');
           
           $a = $this->getNearSupplierWithProduct(auth('customer')->user()->cus_lan , auth('customer')->user()->cus_lat , $id);
           
           $p = ProductSupplier::where('foo_id' , $c["foo_id"])->whereIn('sup_id' , $id )->sum('price');
    
           $detailBill = new  DetailBill();

           $detailBill->price = $p * $c["foo_q"];
           $detailBill->foo_id = $c["foo_id"];
           $detailBill->det_price = $c["foo_price_total"];
           $detailBill->det_qty = $c["foo_q"];
           $detailBill->bil_id = $id_bil;
           $detailBill->sup_id = $a;
          
           $detailBill->save();

          }
       
           $sup_ids = DetailBill::where('bil_id' , $id_bil)->groupby('sup_id')->pluck('sup_id')->toArray();
   
           $sup_id_far =  $this->getFarSupplierWithProduct(auth('customer')->user()->cus_lan , auth('customer')->user()->cus_lat , $sup_ids);
         
           $supplier = Supplier::where('sup_id' , $sup_id_far)->first();
           
           $del = $this->getNearDelivery($supplier->sup_lat , $supplier->sup_log , auth('customer')->user()->cus_address);
           
           $bill->update(['del_id' => $del]);


           $arr = DetailBill::where('bil_id' , $id_bil)->groupby('sup_id')->pluck('sup_id')->toArray();

           $delivery = Delivery::where('del_id' , $del)->first();

           $sup_id =  $this->getNearSupplierById($delivery->del_lat , $delivery->del_log , $sup_ids);
         
           
           $x = Supplier::where('sup_id' , $sup_id)->first();
          
           $a = $this->distanceWithDeliverySupplier($delivery->del_lat , $delivery->del_log , $x->sup_lat , $x->sup_log , 'k');
       
             $z = $x->sup_id;
             $numItems = count($sup_ids) -1;
             $b = null;

           foreach ($arr as $key => $id){
            if($key < $numItems)
              {
              
              $sup_ids = array_diff($sup_ids, array($z));
            
              $sup_ids2 =  $this->getNearSupplierById($delivery->del_lat , $delivery->del_log , $sup_ids);
             
              $x2 = Supplier::where('sup_id' , $sup_ids2)->first();
           
              $b =+ $this->distanceSuppliers($z, $x2->sup_lat , $x2->sup_log , 'k');

               $z =  $x2->sup_id;
              
              }
            
           }
      
              $x3 = Supplier::where('sup_id' , $z)->first();

              $c = $this->distanceWithSupplierCustomer( $x->sup_lat , $x->sup_log , auth('customer')->user()->cus_lat , auth('customer')->user()->cus_lan  , 'k');
             
              
              if($b)
              {

              $distance = $a + $b + $c;
              }else{

                $distance = $a + $c;
              }

              $time = $this->calculateTime($distance);

              $bill->update(['expected_distance' => $distance , 'expected_time' => $time]);
              
             
          session()->forget('cart');
          
         return redirect('/thankyou');
         }

        return redirect('/');
      }


      public function updateTimeDelivery()
      {
  
          $bills = Bill::where('bil_status' , '1')->whereYear('bil_regdate' , Carbon::now()->format('Y'))->where('expected_time' , '>' , 0)->get();
 
           foreach ($bills as $key => $bill) {
          
          $regdate = Bill::where('bil_status' , '1')->pluck('bil_regdate')->first();
          $expectedTime = Bill::where('bil_status' , '1')->pluck('expected_time')->first();

          $now = Carbon::now()->format('i');

          $regdate = date('i', strtotime($regdate));
        
          $a = $now - $regdate;

          $b = $expectedTime - $a;
          if($b < 0)
          {
            break;
          }
          $bill->update([ 'expected_time' => $b ]);

          }   
           
         return response()->json([
                  'status'=>200,
              ]);
  
      }


    public function addFavorite(Request $request)
    {

        $Favorite = new  Favorite();
       
        $Favorite->foo_id = $request->id;
        $Favorite->fav_regdate = Carbon::now();
        $Favorite->cus_id = auth('customer')->user()->cus_id;

        $Favorite->save();
         
       return response()->json([
                'status'=>200,
                'message'=>'User Deleted Successfully.'
            ]);

    }


    public function removeFavorite($foo_id)
    {

        $Favorite = Favorite::where('foo_id' , $foo_id)->where('cus_id' , auth('customer')->user()->cus_id)->first();
       

        $Favorite->delete();
         
        return redirect('/');

    }



   public function removeCart($id)
    {
        if($id) {
            $cart = session()->get('cart');
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
           return redirect('/');
        }
    }



    // public function add($id)
    // {
    //     $product = Product::where('foo_id' , $id)->first();

    //     if($product)
    //     {
    //         return response()->json([
    //             'status'=>200,
    //             'product'=> $product,
    
    //         ]);
    //     }
    //     else
    //     {
    //         return response()->json([
    //             'status'=>404,
    //             'message'=>'No User Found.'
    //         ]);
    //     }

    // }



   public function addToCart(Request $request)
   {

        $quantity = $request->quatity;

        $product = Product::where("foo_id" , $request->foo_id)->first();
      
        
        $cart = session()->get('cart', []);
  
        if(isset($cart[$request->foo_id])) {
          return response()->json([
            'message'=> 'The product is on the cart',
        ]); 
        } else {

            $cart[$request->foo_id] = [
                "foo_id" => $product->foo_id, 
                "foo_name" => $product->foo_name, 
                "foo_price" => $product->foo_price,
                "foo_price_total" => $product->foo_price * $quantity,
                "foo_image" => $product->foo_image,
                "cus_id" => auth('customer')->user()->cus_id,
                "foo_q" => $quantity,

                "quantity" => 1,      
            ];
        }
          
        session()->put('cart', $cart);

            return response()->json([
                'product'=> $product,
            ]);     
        
   }


    public function getLogout()
    {
      
        auth('customer')->logout();

         return redirect('/');
    }


    public function calculateTime($dis)
    {
      
      $velocity = Velocity::pluck('velocity_value')->first();

      $time = $dis/$velocity;

      return round($time * 60);

    }


    public function distanceSuppliers($id , $lat2, $lon2, $unit) 
    {
 
      $supplier = Supplier::where('sup_id' , $id)->first();

         if (($supplier->sup_lat == $lat2) && ($supplier->sup_log == $lon2)) {
           return 0;
         }
 
         else {
           $theta = $supplier->sup_log - $lon2;
           $dist = sin(deg2rad($supplier->sup_lat)) * sin(deg2rad($lat2)) +  cos(deg2rad($supplier->sup_lat)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
           $dist = acos($dist);
           $dist = rad2deg($dist);
           $miles = $dist * 60 * 1.1515;
           $unit = strtoupper($unit);
         
                   if ($unit == "K") {
                     return ($miles * 1.609344);
                   } else if ($unit == "N") {
                     return (int)($miles * 0.8684);
                   } else {
                     return (int)$miles;
           }
   }
 }


    public function distanceWithSupplierCustomer($lat1, $lon1, $lat2, $lon2, $unit) 
    {
 
         if (($lat1 == $lat2) && ($lon1 == $lon2)) {
           return 0;
         }
 
         else {
           $theta = $lon1 - $lon2;
           $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
           $dist = acos($dist);
           $dist = rad2deg($dist);
           $miles = $dist * 60 * 1.1515;
           $unit = strtoupper($unit);
         
                   if ($unit == "K") {
                     return ($miles * 1.609344);
                   } else if ($unit == "N") {
                     return (int)($miles * 0.8684);
                   } else {
                     return (int)$miles;
           }
   }
 }


    public function distanceWithDeliverySupplier($lat1, $lon1, $lat2, $lon2, $unit) 
    {
 
         if (($lat1 == $lat2) && ($lon1 == $lon2)) {
           return 0;
         }
 
         else {
           $theta = $lon1 - $lon2;
           $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
           $dist = acos($dist);
           $dist = rad2deg($dist);
           $miles = $dist * 60 * 1.1515;
           $unit = strtoupper($unit);
         
                   if ($unit == "K") {
                     return (int)($miles * 1.609344);
                   } else if ($unit == "N") {
                     return ($miles * 0.8684);
                   } else {
                     return $miles;
           }
   }
 }


   public function distance($lat1, $lon1, $lat2, $lon2, $unit) 
   {

        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
          return 0;
        }

        else {
          $theta = $lon1 - $lon2;
          $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
          $dist = acos($dist);
          $dist = rad2deg($dist);
          $miles = $dist * 60 * 1.1515;
          $unit = strtoupper($unit);
        
                  if ($unit == "K") {
                    return ($miles * 1.609344);
                  } else if ($unit == "N") {
                    return (int)($miles * 0.8684);
                  } else {
                    return (int)$miles;
          }
  }
}



public function getNearSupplierById($lng , $lat , $ids)
{
  $suppliers = DB::table('suppliers')->select('*',DB::raw("6371 * acos(cos(radians(" . floatval($lat) . "))
            * cos(radians(sup_lat)) * cos(radians(sup_log) - radians(" . floatval($lng) . "))
            + sin(radians(" . $lat . ")) * sin(radians(sup_lat))
              ) AS distance"))->having('distance' , '<' , floatval('100000'))->whereIn('sup_id' , $ids)->orderBy('distance','asc')->first();

  return $suppliers->sup_id;

}



public function getFarSupplierWithProduct($lng , $lat , $id)
{

  $suppliers = DB::table('suppliers')->select('*',DB::raw("6371 * acos(cos(radians(" . floatval($lat) . "))
            * cos(radians(sup_lat)) * cos(radians(sup_log) - radians(" . floatval($lng) . "))
            + sin(radians(" . $lat . ")) * sin(radians(sup_lat))
              ) AS distance"))->having('distance' , '<' , floatval('100000'))->whereIn('sup_id' , $id)->orderBy('distance','desc')->first();

  return $suppliers->sup_id;

}


    public function getNearSupplierWithProduct($lng , $lat , $id)
    {

      $suppliers = DB::table('suppliers')->select('*',DB::raw("6371 * acos(cos(radians(" . floatval($lat) . "))
                * cos(radians(sup_lat)) * cos(radians(sup_log) - radians(" . floatval($lng) . "))
                + sin(radians(" . $lat . ")) * sin(radians(sup_lat))
                  ) AS distance"))->having('distance' , '<' , floatval('100000'))->whereIn('sup_id' , $id)->orderBy('distance','asc')->first();

      return $suppliers->sup_id;

    }


    public function getNearDelivery($lng , $lat , $address)
    {

      $delivery = DB::table('delivery')->select('*',DB::raw("6371 * acos(cos(radians(" . floatval($lat) . "))
                * cos(radians(del_lat)) * cos(radians(del_log) - radians(" . floatval($lng) . "))
                + sin(radians(" . $lat . ")) * sin(radians(del_lat))
                  ) AS distance"))->having('distance' , '<=' , floatval('100000'))->where('del_status' , '2')->where('del_address' , $address)->orderBy('distance','asc')->first();

              
         if($delivery)
          {

             return  $delivery->del_id;

          }

         $ids = Bill::where('bil_status' , '1')->orderby('expected_time')->pluck('del_id');

         foreach($ids as $id){

            $delivery = DB::table('delivery')->select('*',DB::raw("6371 * acos(cos(radians(" . floatval($lat) . "))
            * cos(radians(del_lat)) * cos(radians(del_log) - radians(" . floatval($lng) . "))
            + sin(radians(" . $lat . ")) * sin(radians(del_lat))
              ) AS distance"))->having('distance' , '<=' , floatval('100000'))->where('del_id' , $id)->where('del_status' , '1')->where('del_address' , $address)->orderBy('distance','asc')->first();
         

           if($delivery)
           {
              return  $delivery->del_id;
           }

          
          }

          return 'not found';

    }



    // public function getUserDistance($lng,$lat)
    // {
    //  $user = DB::table('delivery')->select('*',DB::raw("6371 * acos(cos(radians(" . floatval($lat) . "))
    //             * cos(radians(del_lat)) * cos(radians(del_log) - radians(" . floatval($lng) . "))
    //             + sin(radians(" . $lat . ")) * sin(radians(del_lat))
    //               ) AS distance"))->first();

    //   return $user->distance; 
    // }



    // public function calculate()
    // {
    //       echo $this->distance(33.51803174101151, 36.29347570831841, 33.51852311544176, 36.294376398935256, "M") . " Miles<br>";
    //       echo $this->distance(33.51803174101151, 36.29347570831841, 33.51852311544176, 36.294376398935256, "K") . " Kilometers<br>";
    //       echo $this->distance(33.51803174101151,36.29347570831841, 33.51852311544176, 36.294376398935256, "N") . " Nautical Miles<br>";   
    // }

}
