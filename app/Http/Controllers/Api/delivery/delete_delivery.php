<?php

namespace App\Http\Controllers\Api\delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Delivery;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\fileExists;
use Carbon\Carbon;


class delete_delivery extends Controller
{
   
 
    public function deleteDelivery()
    { 
  
        $delivery = Delivery::where( 'del_id' , $_GET['del_id'])->first();

       if (!$delivery)
       {

        return $this->returnError('002', 'لا يوجد بيانات');

        }
        if(File_exists(public_path('images/delivery'.'/'.$delivery->del_image))){

            unlink(public_path('images/delivery'.'/'.$delivery->del_image));
        }

        Delivery::where( 'del_id' , $_GET['del_id'])->delete();
       

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
