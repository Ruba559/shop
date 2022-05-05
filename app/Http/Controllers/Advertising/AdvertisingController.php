<?php

namespace App\Http\Controllers\Advertising;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertising;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use ImageResize;
use Intervention\Image\Facades\Image;


class AdvertisingController extends Controller
{


   public function __construct()
    {
         
           $this->middleware('permission:advert-list|advert-create|advert-edit|advert-delete', ['only' => ['show']]);
           $this->middleware('permission:advert-create', ['only' => ['create','store']]);
           $this->middleware('permission:advert-edit', ['only' => ['edit','update']]);
           $this->middleware('permission:advert-delete', ['only' => ['destroy']]);  
    }


 public function index()
    {
        
        return view('dashboard.Advertising.advertising');
    }


    public function indexAdd()
    {

        return view('dashboard.Advertising.add-advertising');

    }


    public function fetchAdvertising()
    {
        $advertising= Advertising::get();

        return response()->json([
            'advertising'=>$advertising,
        ]);

    }


   public function store(Request $request)
    { 
       
         $fileName = 0;

        if($request->hasFile('advert_image')){


            $file = $request->advert_image;
            $destinationPath = public_path().'/images/advert/';
           
            $filename= 'cat_' . uniqid() . '.'.$file->clientExtension();
            $fileName = 'catS_' . uniqid() . '.' . $file->clientExtension();

            $file->move($destinationPath, $filename);
           

            $image_resize = Image::make($destinationPath.$filename); 
            $image_resize->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
            $image_resize->save(public_path() . '/images/advert/' .$fileName);
           
         }
                $advertising= new Advertising();

                $advertising->advert_name = $request->advert_name;
                $advertising->advert_name_en = $request->advert_name_en;
                $advertising->advert_image = $fileName;              
                $advertising->save();

               
             return redirect('/advertising');

    }


    public function edit($id)
    {
        $advertising= Advertising::where('advert_id' , $id)->first();

        if($advertising)
        {
            return response()->json([
                'status'=>200,
                'advertising'=> $advertising,
    
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Advertising Found.'
            ]);
        }

    }


    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'advert_name'=> 'required|max:191',
            'advert_image'=> 'nullable',

        ]);

       
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {

        $advertising = Advertising::where('advert_id' , $request->advert_id)->first();

        $advertising->update([
            
                $advertising->advert_name = $request->advert_name,
                $advertising->advert_name_en = $request->advert_name_en,           
          ]);

    if ($request->hasFile('advert_image')) {
        if($advertising->advert_image)
        {
            
        if(File_exists(public_path('images/advert'.'/'.$advertising->advert_image))){

            unlink(public_path('images/advert'.'/'.$advertising->advert_image));
        }
      
        $destinationPath = public_path().'/images/advert/';

        $file = $request->file('advert_image');

        $filename= 'cat_' . uniqid() . '.'.$file->clientExtension();
        $fileName = 'catS_' . uniqid() . '.' . $file->clientExtension();

        
        $file->move($destinationPath, $filename);
                
        $image_resize = Image::make($destinationPath.$filename);  
        $image_resize->resize(600);
        $image_resize->save(public_path() . '/images/advert/' .$fileName);

            $advertising->update(['advert_image' => $fileName]);

        }else{

            $destinationPath = public_path().'/images/advert/';

        $file = $request->file('advert_image');

        $filename= 'cat_' . uniqid() . '.'.$file->clientExtension();
        $fileName = 'catS_' . uniqid() . '.' . $file->clientExtension();

        
        $file->move($destinationPath, $filename);
                
        $image_resize = Image::make($destinationPath.$filename);  
        $image_resize->resize(600);
        $image_resize->save(public_path() . '/images/advert/' .$fileName);

            $advertising->update(['advert_image' => $fileName]);
        }
    }

    return response()->json([
        'status'=>200,
        'message'=>'Advertising Updated Successfully.'
     ]);
      }
    }


    public function destroy($id)
    {

        $advertising = Advertising::where('advert_id' , $id)->first();

       
         if(File_exists(public_path('images/advert'.'/'.$advertising->advert_image))){

            unlink(public_path('images/advert').'/'.$advertising->advert_image);
          }

         Advertising::where( 'advert_id' , $id)->delete(); 

        

        if($advertising)
        {
           
            return response()->json([
                'status'=>200,
                'message'=>'Advertising Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Advertising Found.'
            ]);
        }

    }
    
    public function cropImage(Request $request)
    {

        if($request->file( 'advert_image' )){
    
         
            $destinationPath = public_path().'/images/advert/crop/';

            $file = $request->file('advert_image');
          
              $filename= 'cat_' . uniqid() . '.'.$file->clientExtension();
              $fileName = 'catS_' . uniqid() . '.' . $file->clientExtension();
       
            $file->move($destinationPath, $filename);
          
            
            $img = Image::make($destinationPath.$filename);
            $img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
            $img->save(public_path() . '/images/advert/crop/' .$fileName);
        }

        $path = $fileName;

        return response()->json([
           'path'=> $path,

       ]);
    }


    
}
