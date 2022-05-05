<?php

namespace App\Http\Controllers\Api\category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\fileExists;
use Carbon\Carbon;
use ImageResize;
use Intervention\Image\Facades\Image;



class insert_category extends Controller
{
   

    public function addCategory(Request $request)
    { 
  
        $validated = $request->validate([
            'cat_name' => 'required',
            'cat_name_en' => 'required',
            'cat_image' => 'nullable',
        ]);

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
            $image_resize->save(public_path() . '/images/category/' .$fileName);
           
         }

        $category = Category::create([
            'cat_name' => $request->cat_name,
            'cat_name_en' => $request->cat_name_en,
            'cat_regdate' => Carbon::now(),
            'cat_image' => $fileName,
            'cat_thumbnail' => $fileNameS,

        ]);
       
        $category->save();

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
