<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Delivery;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\fileExists;
use Carbon\Carbon;


class DelivaryController extends Controller
{
   
    public function getAllDelivery()
    { 
  
        $delivery = Delivery::select('del_name', 'del_mobile', 'del_pwd' , 'del_image')
        ->limit(10)
        ->get();
        
        return response()->json($delivery);

    }


    public function addDelivery(Request $request)
    { 
  
        $validated = $request->validate([
            'del_name' => 'required',
            'del_mobile' => 'required',
            'del_pwd' => 'required',
            'del_image' => 'nullable',
        ]);

        $imageName = "Null";

        if($request->del_image){

        $image= $request->file('del_image');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('images\delivery'),$imageName);
        }
        $delivery = Delivery::create([
    
            $delivery->del_name = $request->del_name,
            $delivery->del_mobile = $request->del_mobile,
            $delivery->del_pwd = Hash::make( $request->del_pwd),
            $delivery->del_regdate = Carbon::now(),
            $delivery->del_lastdate = Carbon::now(),
            $delivery->del_image = $imageName,
        ]);
       
        $delivery->save();

        return $this -> returnSuccessMessage('Successful');

    }


    public function deleteDelivery($id)
    { 
  
        $delivery = Delivery::where( 'del_id' , $id)->first();

       if (!$delivery)
       {

        return $this->returnError('002', 'لا يوجد بيانات');

        }
        if(File_exists(public_path('images/delivery'.'/'.$delivery->del_image))){

            unlink(public_path('images/delivery'.'/'.$delivery->del_image));
        }

        Delivery::where( 'del_id' , $id)->delete();
       

        return $this -> returnSuccessMessage('Successful');

    }


    public function editDelivery(Request $request ,$id)
    { 
  
        $validated = $request->validate([
            'del_name' => 'required',
            'del_mobile' => 'required',
            'del_pwd' => 'required',
            'del_image' => 'nullable',
        ]);

        $delivery = Delivery::where('del_id' , $id)->first();
    
        if (!$delivery)

        return $this->returnError('002', 'لا يوجد بيانات');

        $delivery->update($request->except(['del_image']));

    
        if ($request->del_image) {
            if($delivery->del_image)
            {
            if(File_exists(public_path('images/delivery'.'/'.$delivery->del_image))){

                unlink(public_path('images/delivery'.'/'.$delivery->del_image));
            }

                $image= $request->file('del_image');
                $imageName = time().'.'.$image->extension();
                $image->move(public_path('images\delivery'),$imageName);
        
                $delivery->update(['del_image' => $imageName]);
                
        }else{

                $image= $request->file('del_image');
                $imageName = time().'.'.$image->extension();
                $image->move(public_path('images\delivery'),$imageName);
    
                $delivery->update(['del_image' => $imageName]);
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
