<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\DeliveryRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;


class DeliveryajaxController extends Controller
{



   public function __construct()
    {
         
           $this->middleware('permission:delivery-list|delivery-create|delivery-edit|delivery-delete', ['only' => ['show']]);
           $this->middleware('permission:delivery-create', ['only' => ['create','store']]);
           $this->middleware('permission:delivery-edit', ['only' => ['edit','update']]);
           $this->middleware('permission:delivery-delete', ['only' => ['destroy']]);  
    }


    public function index()
    {

        return view('dashboard.Delivery.deliveryajax');
    }


    public function indexAdd()
    {

        return view('dashboard.Delivery.add-delivery');

    }


    public function fetchDelivery()
    {
        

        $delivery = Delivery::get();
        return response()->json([
            'delivery'=>$delivery,
        ]);

    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'del_name'=> 'required|max:191',
            'del_mobile'=> 'required|max:191',
            'del_address'=> 'required',
            'del_pwd'=> 'required|max:191',

        ]);

       
        if($validator->fails())
        {
            return redirect('/add_delivery')->withErrors($validator)
            ->withInput();
        }


         $fileName = 0;
         $fileNameS = 0;

        if($request->del_pwd != $request->del_pwd_confirm)
        {
             return redirect()->back()->with(['message_confirm' => 'wrong to confirm password']);
        }

        else {
            if($request->hasFile('del_image')){


                $file = $request->del_image;
                $destinationPath = public_path().'/images/delivery/';
    
                $filename= 'del_' . uniqid() . '.'.$file->clientExtension();
                $fileNameS = 'delS_' . uniqid() . '.' . $file->clientExtension();
                $fileName = 'delS_' . uniqid() . '.' . $file->clientExtension();
    
                $file->move($destinationPath, $filename);
    
                $image_resize = Image::make($destinationPath.$filename);  
                $image_resize->resize(200);
                $image_resize->save(public_path() . '/images/delivery/' .$fileNameS);

                $image_resize = Image::make($destinationPath.$filename);  
                $image_resize->resize(600);
                $image_resize->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
                $image_resize->save(public_path() . '/images/delivery/' .$fileName);
               
             } 
                
              
                $delivery = new Delivery();

                $delivery->del_name = $request->del_name;
                $delivery->del_mobile = $request->del_mobile;
                $delivery->del_pwd = Hash::make( $request->del_pwd);
                $delivery->del_regdate = Carbon::now();
                $delivery->del_lastdate = Carbon::now();
                $delivery->del_image = $fileName;
                $delivery->del_thumbnail = $fileNameS;
                $delivery->del_status = '0';
                $delivery->del_address = $request->del_address;
                $delivery->del_work_start_time = $request->del_work_start_time;
                $delivery->del_work_end_time = $request->del_work_end_time;
                $delivery->del_rate = $request->del_rate;

                $delivery->save();
       
             return redirect('/delivery');

            }
    
    }



    public function edit($id)
    {
        $delivery = Delivery::where('del_id' , $id)->first();

        if($delivery)
        {
            return response()->json([
                'status'=>200,
                'delivery'=> $delivery,
    
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Delivery Found.'
            ]);
        }

    }


    public function update(Request $request)
    {
        
        if($request->del_pwd != $request->del_pwd_confirm)
        {
            return response()->json([
                'status'=>4000,
                'message'=>'not match',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'del_name'=> 'required|max:191',

            
        ]);


        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        } else {
            $delivery = Delivery::where('del_id' , $request->del_id)->first();

            $delivery->update([
                $delivery->del_name = $request->del_name,
                $delivery->del_mobile = $request->del_mobile,
                $delivery->del_pwd = Hash::make( $request->del_pwd),
                $delivery->del_lastdate = Carbon::now(),
               
              ]);
    
        if ($request->hasFile('del_image')) {
            if($delivery->del_image)
            {
                
            if(File_exists(public_path('images/delivery'.'/'.$delivery->del_image))){
    
                unlink(public_path('images/delivery'.'/'.$delivery->del_image));
                unlink(public_path('images/delivery'.'/'.$delivery->del_thumbnail));
            }
          
            $destinationPath = public_path().'/images/delivery/';
    
            $file = $request->file('del_image');
    
            $filename= 'del_' . uniqid() . '.'.$file->clientExtension();
            $fileNameS = 'delS_' . uniqid() . '.' . $file->clientExtension();
            $fileName = 'delS_' . uniqid() . '.' . $file->clientExtension();
    
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
        
                $filename= 'del_' . uniqid() . '.'.$file->clientExtension();
                $fileNameS = 'delS_' . uniqid() . '.' . $file->clientExtension();
                $fileName = 'delS_' . uniqid() . '.' . $file->clientExtension();
        
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
    
        return response()->json([
            'status'=>200,
            'message'=>'Delivery Updated Successfully.'
         ]);
         }
    }


    public function destroy($id)
    {
        $delivery = Delivery::where('del_id' , $id)->first();

        if(File_exists(public_path('images/delivery'.'/'.$delivery->del_image))){

            unlink(public_path('images/delivery'.'/'.$delivery->del_image));
            unlink(public_path('images/delivery'.'/'.$delivery->del_thumbnail));
        }

      
        if($delivery)
        {
            $delivery->delete();
            
            return response()->json([
                'status'=>200,
                'message'=>'Delivery Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Delivery Found.'
            ]);
        }
    }
    


    public function cropImage(Request $request)
    {

        if($request->file( 'del_image' )){
    
         
            $destinationPath = public_path().'/images/delivery/crop/';

            $file = $request->file('del_image');
          
              $filename= 'del_' . uniqid() . '.'.$file->clientExtension();
              $fileName = 'delS_' . uniqid() . '.' . $file->clientExtension();
       
            $file->move($destinationPath, $filename);
          
            
            $img = Image::make($destinationPath.$filename);
            $img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
            $img->save(public_path() . '/images/delivery/crop/' .$fileName);
        }

         $path = $fileName;

         return response()->json([
            'success'=>'success',
            'path'=> $path,

        ]);
    }
    
}
