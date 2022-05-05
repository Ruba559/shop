<?php

namespace App\Http\Controllers\Api\category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\fileExists;
use Carbon\Carbon;


class delete_category extends Controller
{
  
   

    public function deleteCategory()
    { 
	//return $_GET['cat_id'];
        $category = Category::where( 'cat_id' , $_GET['cat_id'])->first();

        if (!$category)
        {

        return $this->returnError('002', 'لا يوجد بيانات');

        }

        if(File_exists(public_path('images/category'.'/'.$category->cat_image))){

            unlink(public_path('images/category'.'/'.$category->cat_image));
        }

        Category::where('cat_id' ,$_GET['cat_id'])->delete();

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
