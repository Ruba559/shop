<?php

namespace App\Http\Controllers\Velocity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use App\Models\Velocity;
use Illuminate\Support\Facades\Validator;

class VelocityController extends Controller
{


//    public function __construct() 
//     {
         
//              $this->middleware('permission:rule-list|rule-create|rule-edit|rule-delete', ['only' => ['show']]);
//              $this->middleware('permission:rule-create', ['only' => ['create','store']]);
//              $this->middleware('permission:rule-edit', ['only' => ['edit','update']]);
//              $this->middleware('permission:rule-delete', ['only' => ['destroy']]);  
//     }

   
   public function index()
    {

        return view('dashboard.Velocity.velocity');
    }


    public function fetchVelocity()
    {
        $velocity= Velocity::get();
        return response()->json([
            'velocity'=>$velocity,
        ]);
    }


    public function edit($id)
    {
        $velocity = Velocity::where('id' , $id)->first();

        if($velocity)
        {
            return response()->json([
                'status'=>200,
                'velocity'=> $velocity,
    
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Velocity Found.'
            ]);
        }

    }


    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            //'name'=> 'required|max:191',
            
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
            $velocity= Velocity::where('id' ,  $request->id)->first();

            if($velocity)
            {
                $time = ($request->time/60);
                $distance = $request->distance;
               
                $v =  ($distance/$time);

                $velocity->velocity_value = $v;
                $velocity->time = $request->time;
                $velocity->distance = $request->distance;

                $velocity->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Velocity Updated Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Velocity Found.'
                ]);
            }

        }
    }


}
