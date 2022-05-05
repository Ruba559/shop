<?php

namespace App\Http\Controllers\Api\delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Delivery;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\fileExists;
use Carbon\Carbon;
use ImageResize;
use Intervention\Image\Facades\Image;


class insert_delivery extends Controller
{
   

    public function addDelivery(Request $request)
    { 
  
        $validated = $request->validate([
            'del_name' => 'required',
            'del_mobile' => 'required',
            'del_pwd' => 'required',
            'del_image' => 'nullable',
        ]);

        $fileName = 0;
         $fileNameS = 0;

        if($request->hasFile('del_image')){


            $file = $request->del_image;
            $destinationPath = public_path().'/images/delivery/';
           
            $filename= 'cat_' . uniqid() . '.'.$file->clientExtension();
            $fileNameS = 'catS_' . uniqid() . '.' . $file->clientExtension();
            $fileName = 'catS_' . uniqid() . '.' . $file->clientExtension();

            $file->move($destinationPath, $filename);
           

            $image_resize = Image::make($destinationPath.$filename);  
            $image_resize->resize(200);
            $image_resize->save(public_path() . '/images/delivery/' .$fileNameS);
            
            $image_resize = Image::make($destinationPath.$filename);  
            $image_resize->resize(600);
            $image_resize->save(public_path() . '/images/delivery/' .$fileName);
           
         }
        $delivery = Delivery::create([
    
            $delivery->del_name = $request->del_name,
            $delivery->del_mobile = $request->del_mobile,
            $delivery->del_pwd = Hash::make( $request->del_pwd),
            $delivery->del_regdate = Carbon::now(),
            $delivery->del_lastdate = Carbon::now(),
            $delivery->del_image = $fileName,
            $delivery->del_thumbnail = $fileNameS,
        ]);
       
        $delivery->save();

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
