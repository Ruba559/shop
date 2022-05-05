<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSupplier;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;
use DB;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
   
    
    public function index()
    {
        
        $product = Product::with('productSuppliers')->get();
        // $product->each(function($p){
        //     $p->productSuppliers->each(function($ps) use ($p){

        //         $p->price = $ps->price;
        //        // unset($p->productSuppliers);
        //     });
        // });
         //return $product;
        $category = Category::get();

        return view('dashboard.Product.product' , ['products' => $product , 'categories' => $category]);
    }


    public function indexAdd()
    {

        $category = Category::get();

        return view('dashboard.Product.add-product' , ['categories' => $category]);

    }


    public function store(ProductRequest $request)
    {

        if($request->hasFile('foo_image')){

            $file = $request->foo_image;
            $destinationPath = public_path().'/images/food/';

          //  $filename= 'pro_' . uniqid() . '.'.$file->clientExtension();
            $fileNameS = 'proS_' . uniqid() . '.' . $file->clientExtension();
            $fileName = 'proS_' . uniqid() . '.' . $file->clientExtension();

           // $file->move($destinationPath, $filename);

            $image_resize = Image::make($destinationPath.$file);  
            $image_resize->resize(200);
            $image_resize->save(public_path() . '/images/food/' .$fileNameS);

            $image_resize = Image::make($destinationPath.$file);  
            $image_resize->resize(600);
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
    
            
                foreach ($suppliers_list as $supp )
                 {
    
                $productSupplier = new ProductSupplier();
                  
                $productSupplier->sup_id = $supp;
                $productSupplier->foo_id =  $product->id;
                $productSupplier->price =  $price_list[$supp];
    
                $productSupplier->save();
    
                 }

             return redirect('/product');

    }


    public function update(ProductRequest $request)
    {

        $product = Product::where('foo_id' , $request->id)->first();
       
        $product->update([
            $product->foo_name = $request->foo_name,
            $product->foo_name_en = $request->foo_name_en,
            $product->foo_info = $request->foo_info,
            $product->foo_info_en = $request->foo_info_en,
            $product->cat_id = $request->cat_id,
            $product->foo_offer =  $request->foo_offer,
            $product->foo_price =  $request->foo_price,
          
          ]);

    if ($request->pro_image) {
        if($product->pro_image)
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

            return redirect('product');
    }

   
    public function destroy(Request $request)
    {
        $product = Product::where('foo_id' , $request->id)->first();

        if(File_exists(public_path('images/food'.'/'.$product->foo_image))){

            unlink(public_path('images/food'.'/'.$product->foo_image));
            unlink(public_path('images/food'.'/'.$product->foo_thumbnail));
        }

        Product::where( 'foo_id' , $request->id)->delete();

        return redirect('/product');
    }
    

    public function p(Request $request)
    {

        $user = Product::where('use_id' , $request->id)->first();

        $user->use_active = '1';

        $user->update();

        return response()->json([
            'status'=>200,
            'message'=>'User Deleted Successfully.'
        ]);
     
    }
}
