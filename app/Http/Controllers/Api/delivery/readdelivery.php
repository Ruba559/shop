<?php

namespace App\Http\Controllers\Api\delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Delivery;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\fileExists;
use Carbon\Carbon;


class readdelivery extends Controller
{
   
    public function getAllDelivery()
    { 
  
        $delivery = Delivery::select('del_name', 'del_mobile', 'del_pwd' , 'del_image')->paginate(20);
        
        return response()->json($delivery);

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
