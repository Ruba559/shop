<?php

namespace App\Http\Controllers\Api\category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\fileExists;
use Carbon\Carbon;


class readcategory extends Controller
{
   
    
    public function getAllCategory()
    { 
       
        $category = Category::select('cat_name', 'cat_image', 'cat_name_en')->paginate(20);
        
        return response()->json($category);

    }


    public function image()
    {
    return response()->file('images/category/'.$_GET['image']);

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
