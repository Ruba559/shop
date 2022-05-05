<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Requests\categoryRequest;
use Carbon\Carbon;
use ImageResize;
use Intervention\Image\Facades\Image;


class CategoryajaxController extends Controller
{


   public function __construct()
    {
         
           $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['show']]);
           $this->middleware('permission:category-create', ['only' => ['create','store']]);
           $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
           $this->middleware('permission:category-delete', ['only' => ['destroy']]);  
    }


    public function index()
    {
        
        return view('dashboard.Category.categoryajax');
    }


    public function indexAdd()
    {

        return view('dashboard.Category.add-category');

    }


    public function fetchCategory()
    {
        $category = Category::get();

        return response()->json([
            'category'=>$category,
        ]);

    }


   public function store(Request $request)
    { 

        $validator = Validator::make($request->all(), [
            'cat_name'=> 'required|max:191',
            'cat_name_en'=> 'required|max:191',
            'cat_image'=> 'nullable|mimes:jpg,jpeg,png',

        ]);

       
        if($validator->fails())
        {
            return redirect('/add_category')->withErrors($validator)
            ->withInput();
        }

         $fileName = 0;
         $fileNameS = 0;

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
            $image_resize->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
            $image_resize->save(public_path() . '/images/category/' .$fileName);
           
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


    public function edit($id)
    {
        $category = Category::where('cat_id' , $id)->first();

        if($category)
        {
            return response()->json([
                'status'=>200,
                'category'=> $category,
    
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Category Found.'
            ]);
        }

    }


    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'cat_name'=> 'required|max:191',
            'cat_name_en'=> 'required|max:191',
            'cat_image'=> 'nullable',

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

        $category = Category::where('cat_id' , $request->cat_id)->first();

        $category->update([
            $category->cat_name = $request->cat_name,
            $category->cat_name_en = $request->cat_name_en,
           
          ]);

    if ($request->hasFile('cat_image')) {
        if($category->cat_image)
        {
            
        if(File_exists(public_path('images/category'.'/'.$category->cat_image))){

            unlink(public_path('images/category'.'/'.$category->cat_image));
            unlink(public_path('images/category'.'/'.$category->cat_thumbnail));
        }
      
        $destinationPath = public_path().'/images/category/';

        $file = $request->file('cat_image');

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

            $category->update(['cat_image' => $fileName , 'cat_thumbnail' => $fileNameS]);

        }else{

            $destinationPath = public_path().'/images/category/';

        $file = $request->file('cat_image');

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

            $category->update(['cat_image' => $fileName , 'cat_thumbnail' => $fileNameS]);
        }
    }

    return response()->json([
        'status'=>200,
        'message'=>'Category Updated Successfully.'
     ]);
      }
    }


    public function destroy($id)
    {

        $category = Category::where('cat_id' , $id)->first();
        $product_id = Product::where('cat_id' , $id)->pluck('foo_id');

        if($product_id->count() == 0 )
        {
            if(File_exists(public_path('images/category'.'/'.$category->cat_image))){

                unlink(public_path('images/category').'/'.$category->cat_image);
                unlink(public_path('images/category').'/'.$category->cat_thumbnail);
            }
            
            Category::where( 'cat_id' , $id)->delete();

        }else{

         foreach($product_id as $id)
         {
        
            $product = Product::where('foo_id' , $id)->first();

            if(File_exists(public_path('images/product'.'/'.$product->foo_image))){

                unlink(public_path('images/product'.'/'.$product->foo_image));
                unlink(public_path('images/product'.'/'.$product->foo_thumbnail));
            }

            Product::where( 'foo_id' , $id)->delete();

         }

         if(File_exists(public_path('images/category'.'/'.$category->cat_image))){

            unlink(public_path('images/category').'/'.$category->cat_image);
            unlink(public_path('images/category').'/'.$category->cat_thumbnail);
          }

         Category::where( 'cat_id' , $id)->delete(); 

        }

        if($category)
        {
           
            return response()->json([
                'status'=>200,
                'message'=>'Category Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Category Found.'
            ]);
        }

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
