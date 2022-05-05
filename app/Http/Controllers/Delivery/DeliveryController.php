<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Delivery;
use App\Models\Customer;
use Illuminate\Support\Facades\File;
use App\Http\Requests\DeliveryRequest;
use Illuminate\Support\Facades\Hash;
use DB;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;


class DeliveryController extends Controller
{



   public function __construct()
    {
         
           $this->middleware('permission:deliverystatus-list', ['only' => ['show']]);
          // $this->middleware('permission:delivery-create', ['only' => ['create','store']]);
           //$this->middleware('permission:delivery-edit', ['only' => ['edit','update']]);
           //$this->middleware('permission:delivery-delete', ['only' => ['destroy']]);  
    }


    public function index()
    {
        
        $delivery = Delivery::with('bills')->get();
	

        return view('dashboard.Delivery.delivery' , ['deliveries' => $delivery ]);
    }


    public function filter(Request $request)
    {

        $delivery = Delivery::select('*')->where('del_status','=',$request->status)->get();

         return view('dashboard.Delivery.delivery', ['deliveries' => $delivery ]);
    }



    public function indexAdd()
    {

        return view('dashboard.Delivery.add-delivery'); 

    }


    public function store(DeliveryRequest $request)
    {

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

                $delivery->save();
       
             return redirect('/delivery');

            }
    }


    public function showImage(Request $request)
    {

        if($request->file( 'del_image' )){
    
            
            $destinationPath = public_path().'/images/delivery/';

            $file = $request->file('del_image');
          
              $filename= 'del_' . uniqid() . '.'.$file->clientExtension();
              $fileName = 'delS_' . uniqid() . '.' . $file->clientExtension();
       
            $file->move($destinationPath, $filename);
          
            
            $img = Image::make($destinationPath.$filename);
            $img->blur(80);
            $img->save(public_path() . '/images/delivery/' .$fileName);
          }

         $path = $fileName;

         return response()->json([
            'success'=>'success',
            'path'=> $path,

        ]);
    }


    public function cropImage(Request $request)
    {

        if($request->file( 'del_image' )){
    
         
            $destinationPath = public_path().'/images/delivery/';

            $file = $request->file('del_image');
          
              $filename= 'del_' . uniqid() . '.'.$file->clientExtension();
              $fileName = 'delS_' . uniqid() . '.' . $file->clientExtension();
       
            $file->move($destinationPath, $filename);
          
            
            $img = Image::make($destinationPath.$filename);
            $img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
            $img->save(public_path() . '/images/delivery/' .$fileName);
        }

         $path = $fileName;

         return response()->json([
            'success'=>'success',
            'path'=> $path,

        ]);
    }


    public function update(Request $request)
    {

       if($request->del_pwd)
       {
        if($request->del_pwd != $request->del_pwd_confirm)
        {
             return redirect()->back()->with(['message_confirm' => 'wrong to confirm password']);
        }

       }
        $delivery = Delivery::where('del_id' , $request->id)->first();

            $delivery->update([
               $delivery->del_name = $request->del_name,
                $delivery->del_mobile = $request->del_mobile,
                $delivery->del_pwd = Hash::make( $request->del_pwd),
                $delivery->del_lastdate = Carbon::now(),
                $delivery->del_address = $request->del_address,
                $delivery->del_work_start_time = $request->del_work_start_time,
                $delivery->del_work_end_time = $request->del_work_end_time,
              ]);
    
        if ($request->del_image) {
            if($delivery->del_image)
            {
           
            if(File_exists(public_path('images/delivery'.'/'.$delivery->del_image))){

                unlink(public_path('images/delivery'.'/'.$delivery->del_image));
            }

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
                $image_resize->save(public_path() . '/images/delivery/' .$fileName);

                $delivery->update(['del_image' => $fileName , 'del_thumbnail' => $fileNameS ]);
                
            }else{
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
                $image_resize->save(public_path() . '/images/delivery/' .$fileName);

                $delivery->update(['del_image' => $fileName , 'del_thumbnail' => $fileNameS ]);
            }
            
        }

            return redirect('delivery');
     
   }


   public function destroy(Request $request)
   {

       $delivery = Delivery::where('del_id' , $request->id)->first();

       if(File_exists(public_path('images/delivery'.'/'.$delivery->del_image))){

           unlink(public_path('images/delivery'.'/'.$delivery->del_image));
           unlink(public_path('images/delivery'.'/'.$delivery->del_thumbnail));
       }

       Delivery::where( 'del_id' , $request->id)->delete();

       return redirect('/delivery');
   }

}
