<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use Carbon\Carbon;


class ProductController extends Controller
{

    public function getAllProduct()
    {
  
        $product = Product::select('foo_name', 'foo_name_en' ,'foo_image', 'foo_price' , 'foo_info_en' , 'foo_offer' ,
        'foo_info' , 'cat_id')
        ->limit(10)
        ->get();

        return response()->json($product);

    }


    public function addProduct(Request $request)
    { 

        $validated = $request->validate([
            'foo_name' => 'required',
            'foo_name_en' => 'required',
            'foo_image' => 'required',
            'cat_id' => 'required',
            'foo_price' => 'nullable',
            'foo_info_en' => 'nullable',
            'foo_offer' => 'nullable',
            'foo_info' => 'nullable',
        ]);
        $imageName = "Null";

        if($request->foo_image){

        $image= $request->file('foo_image');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('images\food'),$imageName);
        }

        $product = Product::create([
            'foo_name' => $request->foo_name,
            'foo_name_en' => $request->foo_name_en,
            'foo_price' => $request->foo_price,
            'foo_info_en' => $request->foo_info_en,
            'foo_offer' => $request->foo_offer,
            'foo_info' => $request->foo_info,
            'cat_id' => $request->cat_id,
            'foo_regdate' => Carbon::now(),
            'foo_image' => $imageName,
        ]);
       
        $product->save();

        return $this -> returnSuccessMessage('Successful');

    }

    public function deleteProduct($id)
    { 
  
        $product = Product::where( 'foo_id' , $id)->first();

       if (!$product)
        {

        return $this->returnError('002', 'لا يوجد بيانات');
        }

        if(File_exists(public_path('images/food'.'/'.$product->foo_image))){

            unlink(public_path('images/food').'/'.$product->foo_image);
        }

        $product = Product::where('foo_id' , $id)->delete();

        return $this -> returnSuccessMessage('Successful' , '200');

    }


    public function editProduct(Request $request ,$id)
    { 
  
        $validated = $request->validate([
            'foo_name' => 'required',
            'foo_name_en' => 'required',
            'foo_image' => 'required',
            'cat_id' => 'required',
            'foo_price' => 'nullable',
            'foo_info_en' => 'nullable',
            'foo_offer' => 'nullable',
            'foo_info' => 'nullable',
        ]);

        $product = Product::where('foo_id' , $id)->first();
    
        if (!$product)

        return $this->returnError('002', 'لا يوجد بيانات');

        $product->update($request->except(['foo_image']));

    
        if ($request->foo_image) {
            if($product->foo_image)
            {
            if(File_exists(public_path('images/food'.'/'.$product->foo_image))){

                unlink(public_path('images/food'.'/'.$product->foo_image));
            }

                $image= $request->file('foo_image');
                $imageName = time().'.'.$image->extension();
                $image->move(public_path('images\food'),$imageName);
        
                $product->update(['foo_image' => $imageName]);
        }else{
            
            $image= $request->file('foo_image');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images\food'),$imageName);
    
            $product->update(['foo_image' => $imageName]);
        }
        }

        return $this -> returnSuccessMessage('Successful');

    }

    public function returnSuccessMessage($msg = "", $errNum = "S000")
    {
        return [
            'status' => true,
            'errNum' => $errNum,
            'msg' => $msg
        ];
    }

    public function returnError($errNum, $msg)
    {
        return response()->json([
            'status' => false,
            'errNum' => $errNum,
            'msg' => $msg
        ]);
    }

}
