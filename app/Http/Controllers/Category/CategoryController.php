<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use App\Http\Requests\categoryRequest;
use DB;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Helpers\General;



class CategoryController extends Controller
{
   
    public function index()
    {
        
        $category = Category::get();

        return view('dashboard.Category.category' , ['categories' => $category]);
    }


    public function indexAdd()
    {
       
        return view('dashboard.Category.add-category');

    }
    

    public function store(categoryRequest $request)
    {
        
        if($request->hasFile('cat_image')){

          
            $file = $request->cat_image;
            $destinationPath = public_path().'/images/category/';

            $filename= 'cat_' . uniqid() . '.'.$file->clientExtension();
            $fileNameS = 'catS_' . uniqid() . '.' . $file->clientExtension();
            $fileName = 'catS_' . uniqid() . '.' . $file->clientExtension();

            
            $file->move($destinationPath, $filename);

            $image_resize = Image::make($destinationPath.$filename);  
            $image_resize->resize(200);
            $image_resize->save(public_path() . '/images/category/' .$fileNameS);
            
            $image_resize = Image::make($destinationPath.$filename);  
            $image_resize->resize(600);
            $image_resize->save(public_path() . '/images/category/' .$fileName);

            $Path = $image_resize;  
            $img = Image::make($destinationPath.$filename);
          
            
                
            $Path = uploadImageRotate($destinationPath, $filename );
            $Path = uploadImageBlur($destinationPath, $filename );

        //    $image_info = getimagesize($destinationPath.$filename);
            $image = imagecreatefromjpeg($destinationPath.$filename);
            
            $width = imagesx($image);
            $height = imagesy($image);
            
            $resized_width = ((int)$request->x2) - ((int)$request->x1);
            $resized_height = ((int)$request->y2) - ((int)$request->y1);
            
            $resized_image = imagecreatetruecolor($resized_width, $resized_height);
            imagecopyresampled($resized_image, $image, 0, 0, (int)$request->x1, (int)$request->y1, $resized_width , $resized_height, $width, $height);
            $save = imagejpeg($resized_image, $destinationPath.$filename);

            Image::make($destinationPath.$save);

            // if($request->p)
            // {
            // $Path = uploadImageCrop($destinationPath, $filename , $request->input('w') , $request->input('h') , $request->input('x1') , $request->input('y1'));
            // }
            // $img = Image::make($destinationPath.$filename);
            // $img->crop($request->input('w') , $request->input('h') , $request->input('x1') , $request->input('y1'));
            // $img->save(public_path() . '/images/category/' .$fileName);
             $Path->save(public_path() . '/images/category/' .$fileName );
            
         }
       
                $category = new Category();

                $category->cat_name = $request->cat_name;
                $category->cat_name_en = $request->cat_name_en;
                $category->cat_regdate = Carbon::now();
                $category->cat_image = $fileName;
                $category->cat_thumbnail = $fileNameS;
              
                $category->save();

               
             return redirect('/category');

    }


    public function destroy(Request $request)
    {

        $category = Category::where('cat_id' , $request->id)->first();
        $product_id = Product::where('cat_id' , $request->id)->pluck('foo_id');

        if($product_id->count() == 0 )
        {
            if(File_exists(public_path('images/category'.'/'.$category->cat_image))){

                unlink(public_path('images/category').'/'.$category->cat_image);
            }
            
            Category::where( 'cat_id' , $request->id)->delete();

        }else{

         foreach($product_id as $id)
         {
        
            $product = Product::where('foo_id' , $id)->first();

            if(File_exists(public_path('images/product'.'/'.$product->foo_image))){

                unlink(public_path('images/product'.'/'.$product->foo_image));
            }

            Product::where( 'foo_id' , $id)->delete();

         }

         if(File_exists(public_path('images/category'.'/'.$category->cat_image))){

            unlink(public_path('images/category').'/'.$category->cat_image);
        }

         Category::where( 'cat_id' , $request->id)->delete(); 

        }
          
       
        return redirect('/category');

    }


    public function update(Request $request)
    {
     
        $category = Category::where('cat_id' , $request->id)->first();

            $category->update([
                $category->cat_name = $request->cat_name,
                $category->cat_name_en = $request->cat_name_en,
               
              ]);
    
        if ($request->cat_image) {
            if($category->cat_image)
            {

            if(File_exists(public_path('images/category'.'/'.$category->cat_image))){

                unlink(public_path('images/category'.'/'.$category->cat_image));
            }

                $image= $request->file('cat_image');
                $imageName = time().'.'.$image->extension();
                $image->move(public_path('images\category'),$imageName);
        
                $category->update(['cat_image' => $imageName]);

            }else{
                $image= $request->file('cat_image');
                $imageName = time().'.'.$image->extension();
                $image->move(public_path('images\category'),$imageName);
        
                $category->update(['cat_image' => $imageName]);
            }
        }

        return redirect('/category');
    
    }



    
    }


  

