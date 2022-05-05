<?php

namespace App\Http\Controllers\Rule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

use Illuminate\Support\Facades\Validator;

class RuleController extends Controller
{


   public function __construct() 
    {
         
             $this->middleware('permission:rule-list|rule-create|rule-edit|rule-delete', ['only' => ['show']]);
             $this->middleware('permission:rule-create', ['only' => ['create','store']]);
             $this->middleware('permission:rule-edit', ['only' => ['edit','update']]);
             $this->middleware('permission:rule-delete', ['only' => ['destroy']]);  
    }

   
  public function index()
    {

        return view('dashboard.Rule.rule');
    }


    public function indexAdd()
    {
        
        $permission = Permission::get();

        return view('dashboard.Rule.add-rule' , [ 'permissions' => $permission ]);

    }

    public function fetchRule()
    {
        $Role= Role::get();
        return response()->json([
            'role'=>$Role,
        ]);
    }


    public function store(Request $request)
    {
   
        $validator = Validator::make($request->all(), [
            'permission'=> 'required|max:191',
            'name'=> 'required|max:191',

        ]);

        if($validator->fails())
        {
            return redirect('/add_rule')->withErrors($validator)
                        ->withInput();;
        }

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
                              
             return redirect('/rule');
        
    }


    public function edit($id)
    {
        $Role = Role::where('id' , $id)->first();

        if($Role)
        {
            return response()->json([
                'status'=>200,
                'Role'=> $Role,
    
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Rule Found.'
            ]);
        }

    }



   public function detail($id)
    {

        $permission = Permission::get();

        $role = Role::where('id' , $id)->first();

        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id) 
            ->get();

         return view('dashboard.Rule.rule_detail' , [ 'permissions' => $permission, 'rolePermissions' => $rolePermissions , 'role' => $role]);
 

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
            $Role= Role::where('id' ,  $request->id)->first();

            if($Role)
            {
                $Role->name =  $request->name;
               
                $Role->update();

                return response()->json([
                    'status'=>200,
                    'message'=>'Rule Updated Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Rule Found.'
                ]);
            }

        }
    }


    public function destroy($id)
    {

        $rule = Role::where('id' , $id)->first();

        if($rule)
        {
            $rule->delete();
            
            return response()->json([
                'status'=>200,
                'message'=>'Rule Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Rule Found.'
            ]);
        }
    }

 
    public function destroyPermission(Request $request)
    {

       $role = Role::findByName($request->role_name);
       $role->revokePermissionTo($request->permission_name);

       if($role)
        {

        return response()->json([
                'status'=>200,
                'message'=> $role
            ]);
        }

    }


    public function addPermission(Request $request)
    {
       $c=  $request->per_name;
       $role = Role::findByName($request->role_name);
       $role->givePermissionTo($request->per_name);

       if($role)
        {

        return response()->json([
                'status'=>200,
                'message'=> $c
            ]);
        }

    }


}
