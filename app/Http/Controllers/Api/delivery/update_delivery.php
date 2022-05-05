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



class update_delivery extends Controller
{
   
  
    public function editDelivery(Request $request)
    { 
  
        $validated = $request->validate([
            'del_name' => 'required',
            'del_mobile' => 'required',
            'del_pwd' => 'required',
            'del_image' => 'nullable',
        ]);

        $delivery = Delivery::where('del_id' , $_GET['del_id'])->first();
    
        if (!$delivery)

        return $this->returnError('002', 'لا يوجد بيانات');

        $delivery->update($request->except(['del_image']));

    
       if ($request->hasFile('del_image')) {
        if($delivery->del_image)
        {
            
        if(File_exists(public_path('images/delivery'.'/'.$delivery->del_image))){

            unlink(public_path('images/delivery'.'/'.$delivery->del_image));
            unlink(public_path('images/delivery'.'/'.$delivery->del_thumbnail));
        }
      
        $destinationPath = public_path().'/images/delivery/';

        $file = $request->file('del_image');

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

            $delivery->update(['del_image' => $fileName , 'del_thumbnail' => $fileNameS]);

        }else{

            $destinationPath = public_path().'/images/delivery/';

        $file = $request->file('del_image');

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

            $delivery->update(['del_image' => $fileName , 'del_thumbnail' => $fileNameS]);
        }
    }

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
