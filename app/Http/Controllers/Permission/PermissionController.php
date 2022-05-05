<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
 
class PermissionController extends Controller
{


   public function __construct()
    {
         
             $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['show']]);
             $this->middleware('permission:permission-create', ['only' => ['create','store']]);
             $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:permission-delete', ['only' => ['destroy']]);  
    }


    public function index()
    {

        return view('dashboard.Permission.permission');
    }


    public function indexAdd()
    {
        
        return view('dashboard.Permission.add-permission');

    }


    public function fetchPermission()
    {
        $permission = Permission::all();
        return response()->json([
            'permission'=>$permission ,
        ]);
    }


    public function store(Request $request)
    {

                $permission= new Permission();

                $permission->name =  $request->name;

                $permission->save();
               
             return redirect('/permission');
        
    }


    public function edit($id)
    {
        $permission = Permission::where('id' , $id)->first();

        if($permission)
        {
            return response()->json([
                'status'=>200,
                'permission'=> $permission,
    
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Permission Found.'
            ]);
        }

    }


    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'=> 'required|max:191',
            
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
            $permission = Permission::where('id' ,  $request->id)->first();

            if($permission)
            {
                $permission->name =  $request->name;
               
                $permission->update();

                return response()->json([
                    'status'=>200,
                    'message'=>'Permission Updated Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Permission Found.'
                ]);
            }

        }
    }


    public function destroy($id)
    {

        $permission = Permission::where('id' , $id)->first();

        if($permission)
        {
            $permission->delete();
            
            return response()->json([
                'status'=>200,
                'message'=>'Permission Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Permission Found.'
            ]);
        }
    }




}
