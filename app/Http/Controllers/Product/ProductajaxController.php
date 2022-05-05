<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductSupplier;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\ProductName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;
use Carbon\Carbon;
use ImageResize;
use Intervention\Image\Facades\Image;


class ProductajaxController extends Controller
{


   public function __construct()
    {
         
           $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['show']]);
           $this->middleware('permission:product-create', ['only' => ['create','store']]);
           $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
           $this->middleware('permission:product-delete', ['only' => ['destroy']]);  
    }

    public function index()
    {

        return view('dashboard.Product.productajax'); 
    }


    public function indexAdd()
    {

        $category = Category::get();
        $supplier = Supplier::get();
        $product = ProductName::get();

        return view('dashboard.Product.add-product' , [ 'product' => $product, 'categories' => $category , 'suppliers' => $supplier]);

    }


    public function fetchProduct()
    {
        $product = Product::get(); 
        $category = Category::get();

        return response()->json([
             'product'=>$product,
             'category'=>$category,
        ]);

    }



   public function store(Request $request)
    { 

        $validator = Validator::make($request->all(), [
            'foo_name'=> 'required|max:191',
            'foo_name_en'=> 'required|max:191',
            'sup_id'=> 'required',
            'cat_id'=> 'required',
            'foo_image'=> 'required|mimes:jpg,jpeg,png',

        ]);
       
        if($validator->fails())
        {
            return redirect('/add_product')->withErrors($validator)
            ->withInput();
        }
        

         $fileName = 0;
         $fileNameS = 0;

        if($request->hasFile('foo_image')){


            $file = $request->foo_image;
            $destinationPath = public_path().'/images/food/';
           
            $filename= 'cat_' . uniqid() . '.'.$file->clientExtension();
            $fileNameS = 'catS_' . uniqid() . '.' . $file->clientExtension();
            $fileName = 'catS_' . uniqid() . '.' . $file->clientExtension();

            $file->move($destinationPath, $filename);
           

            $image_resize = Image::make($destinationPath.$filename);  
            $image_resize->resize(200);
            $image_resize->save(public_path() . '/images/food/' .$fileNameS);
            
            $image_resize = Image::make($destinationPath.$filename);  
            $image_resize->resize(600);
            $image_resize->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
            $image_resize->save(public_path() . '/images/food/' .$fileName);
           
         }
                $product = new Product();

                $product->foo_name = $request->foo_name;
                $product->foo_name_en = $request->foo_name_en;
                $product->foo_info = $request->foo_info;
                $product->foo_info_en = $request->foo_info_en;
                $product->cat_id = $request->cat_id;
                $product->foo_image = $fileName;
                $product->foo_thumbnail = $fileNameS;
                $product->foo_offer =  $request->foo_offer;
                $product->foo_price =  $request->foo_price;
                $product->foo_regdate = Carbon::now();
              
                $product->save();

                $suppliers_list  =  $request->suppliers;
                $price_list  =  $request->price;
    
            if($suppliers_list)
              {
                foreach ($suppliers_list as $supp )
                 {
    
                $productSupplier = new ProductSupplier();
                  
                $productSupplier->sup_id = $supp;
                $productSupplier->foo_id =  $product->foo_id;
                $productSupplier->price =  $price_list[$supp];
    
                $productSupplier->save();
    
                 }
            }
             return redirect('/product');

    }


    public function edit($id)
    {
        $product = Product::where('foo_id' , $id)->first()->load('category');
	    $category = Category::get();

        if($product)
        {
            return response()->json([
                'status'=>200,
                'product'=> $product,
	            'category'=> $category 
    
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


    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'foo_name'=> 'required|max:191',
            'foo_image'=> 'nullable',

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

        $product = Product::where('foo_id' , $request->foo_id)->first();

        $product->update([
            $product->foo_name = $request->foo_name,
            $product->foo_name_en = $request->foo_name_en,
            $product->foo_info = $request->foo_info,
            $product->foo_info_en = $request->foo_info_en,
            $product->cat_id = $request->cat_id,
            $product->foo_offer =  $request->foo_offer,
            $product->foo_price =  $request->foo_price,
           
          ]);

    if ($request->hasFile('foo_image')) {
        if($product->foo_image)
        {
            
        if(File_exists(public_path('images/food'.'/'.$product->foo_image))){

            unlink(public_path('images/food'.'/'.$product->foo_image));
            unlink(public_path('images/food'.'/'.$product->foo_thumbnail));
        }
      
        $destinationPath = public_path().'/images/food/';

        $file = $request->file('foo_image');

        $filename= 'cat_' . uniqid() . '.'.$file->clientExtension();
        $fileNameS = 'catS_' . uniqid() . '.' . $file->clientExtension();
        $fileName = 'catS_' . uniqid() . '.' . $file->clientExtension();

        
        $file->move($destinationPath, $filename);
    
        $image_resize = Image::make($destinationPath.$filename);  
        $image_resize->resize(200);
        $image_resize->save(public_path() . '/images/food/' .$fileNameS);
            
        $image_resize = Image::make($destinationPath.$filename);  
        $image_resize->resize(600);
        $image_resize->save(public_path() . '/images/food/' .$fileName);

            $product->update(['foo_image' => $fileName , 'foo_thumbnail' => $fileNameS]);

        }else{

            $destinationPath = public_path().'/images/food/';

        $file = $request->file('foo_image');

        $filename= 'cat_' . uniqid() . '.'.$file->clientExtension();
        $fileNameS = 'catS_' . uniqid() . '.' . $file->clientExtension();
        $fileName = 'catS_' . uniqid() . '.' . $file->clientExtension();

        
        $file->move($destinationPath, $filename);
    
        $image_resize = Image::make($destinationPath.$filename);  
        $image_resize->resize(200);
        $image_resize->save(public_path() . '/images/food/' .$fileNameS);
            
        $image_resize = Image::make($destinationPath.$filename);  
        $image_resize->resize(600);
        $image_resize->save(public_path() . '/images/food/' .$fileName);

            $product->update(['foo_image' => $fileName , 'foo_thumbnail' => $fileNameS]);
        }
    }

    return response()->json([
        'status'=>200,
        'message'=>'Product Updated Successfully.'
     ]);
      }
    }


    public function destroy($id)
    {

        $product = Product::where('foo_id' , $id)->first();

        if(File_exists(public_path('images/food'.'/'.$product->foo_image))){

            unlink(public_path('images/food'.'/'.$product->foo_image));
            unlink(public_path('images/food'.'/'.$product->foo_thumbnail));
        }

        Product::where( 'foo_id' , $id)->delete();

        return response()->json([
            'status'=>200,
            'message'=>'Product Delete Successfully.'
         ]);

    }
    
    public function cropImage(Request $request)
    {

        if($request->file( 'cat_image' )){
    
         
            $destinationPath = public_path().'/images/category/crop/';

            $file = $request->file('cat_image');
          
              $filename= 'cat_' . uniqid() . '.'.$file->clientExtension();
              $fileName = 'catS_' . uniqid() . '.' . $file->clientExtension();
       
            $file->move($destinationPath, $filename);
          
            
            $img = Image::make($destinationPath.$filename);
            $img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
            $img->save(public_path() . '/images/category/crop/' .$fileName);
        }

        $path = $fileName;

        return response()->json([
           'path'=> $path,

       ]);
    }


}
