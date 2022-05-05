<?php

namespace App\Http\Controllers\ProductName;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductName;
use App\Models\Supplier;
use App\Models\ProductSupplier;
use Illuminate\Support\Facades\Validator;

class ProductNameController extends Controller
{
    

    public function index()
    {

        return view('dashboard.ProductName.productname');
    }


    public function indexAdd()
    {
        
        $category = Category::get();
        return view('dashboard.ProductName.add-productname' , [ 'categories' =>  $category]);

    }


    public function indexPrice()
    {

        $productName = ProductName::get();
        $supplier = Supplier::get();

        return view('dashboard.ProductName.productprice' , [ 'productName' =>  $productName , 'supplier' => $supplier]);
    }


    public function fetchProductName()
    {
        $productName = ProductName::get();
        return response()->json([
            'productName'=>$productName,
        ]);
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'pro_name'=> 'required|max:191',
            'cat_id'=> 'required|max:191',
        ]);
       
        if($validator->fails())
        {
            return redirect('/add_productname')->withErrors($validator)
            ->withInput();
        }
 
                $productName = new ProductName();

                $productName->pro_name =  $request->pro_name;
                $productName->cat_id =  $request->cat_id;

                $productName->save();

             return redirect('/productname');
        
    }


    public function storePrice(Request $request)
    {
 
        $validator = Validator::make($request->all(), [
            'price'=> 'required',
            'sup_id'=> 'required',
            'id' => 'required',
        ]);
       
        if($validator->fails())
        {
            return redirect('/add_productname')->withErrors($validator)
            ->withInput();
        }

                $product = new ProductSupplier();

                $product->price =  $request->price;
                $product->foo_id =  $request->id;
                $product->sup_id =  $request->sup_id;

                $product->save();

             return redirect('/productprice');
        
    }


    
    public function showSupllier(Request $request)
    {

        $product = ProductSupplier::where('foo_id' , $request->id)->with('supllier')->get();
        $product->each(function($p){
            $p->sup_name = $p->supllier->sup_name;
            $p->sup_id = $p->supllier->sup_id;
            unset($p->supllier);
        });
	   
        $total = ProductSupplier::where('foo_id' , $request->id)->max('price');

        if($product)
        {
            return response()->json([
                'status'=>200,
                'product'=> $product,
                'total'=> $total,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Product Found.'
            ]);
        }

    }

    public function edit($id)
    {
        $productName = ProductName::where('id' , $id)->first()->load('category');
        $category = Category::get();

        if($productName)
        {
            return response()->json([
                'status'=>200,
                'productName'=> $productName,
                'category'=> $category 
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No ProductName Found.'
            ]);
        }

    }


    public function update(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'pro_name'=> 'required|max:191',
            
        ]);

       
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $productName = ProductName::where('id' ,  $request->id)->first();

            if($productName)
            {
                $productName->pro_name =  $request->pro_name;
                $productName->cat_id =  $request->cat_id;


              $productName->update();

                return response()->json([
                    'status'=>200,
                    'message'=>'ProductName Updated Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No ProductName Found.'
                ]);
            }

        }
    }


    public function destroy($id)
    {

        $productName = ProductName::where('id' , $id)->first();

        if($productName)
        {
            $productName->delete();
            
            return response()->json([
                'status'=>200,
                'message'=>'ProductName Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No ProductName Found.'
            ]);
        }
    }
}
