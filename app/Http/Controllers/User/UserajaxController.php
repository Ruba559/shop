<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; 


class UserajaxController extends Controller
{


//    public function __construct()
//     {
         
//              $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['show']]);
//              $this->middleware('permission:user-create', ['only' => ['create','store']]);
//              $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
//              $this->middleware('permission:user-delete', ['only' => ['destroy']]);  
//     }


    public function index()
    {

        return view('dashboard.User.userajax');
    }


    public function indexAdd()
    {
        
        $role = Role::get();
        return view('dashboard.User.add-user' , [ 'roles' =>  $role]);

    }


    public function fetchUser()
    {
        $user = User::all();
        return response()->json([
            'user'=>$user,
        ]);
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'use_name'=> 'required|max:191',
            'use_mobile'=> 'required|unique:users|max:10',
            'use_pwd'=> 'required|max:20',
            
        ]);
     
        if($validator->fails())
        {
            return redirect('/add_product')->withErrors($validator)
            ->withInput();
        }

        
        if($request->use_pwd != $request->use_pwd_confirm)
        {
             return redirect()->back()->with(['message_confirm' => 'wrong to confirm password']);
        }
 
                $user = new User();

                $user->use_name =  $request->use_name;
                $user->use_mobile = $request->use_mobile;
                $user->use_pwd = Hash::make( $request->use_pwd);
                $user->use_datetime = Carbon::now();
                $user->use_lastdate = Carbon::now();
                $user->use_active = '0';
                $user->use_note = $request->use_note;

                $token = Str::random(60);
              
                $user->use_token = hash('sha256', $token); 

                $user->save();

                $user->assignRole($request->input('roles') );
              

             return redirect('/user');
        
    }


    public function edit($id)
    {
        $user = User::where('use_id' , $id)->first();

        if($user)
        {
            return response()->json([
                'status'=>200,
                'user'=> $user,
    
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No User Found.'
            ]);
        }

    }


    public function update(Request $request)
    {

        if($request->use_pwd != $request->use_pwd_confirm)
        {
            return response()->json([
                'status'=>4000,
                'message'=>'not match',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'use_name'=> 'required|max:191',
            
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
            $user = User::where('use_id' ,  $request->use_id)->first();

            if($user)
            {
                $user->use_name =  $request->use_name;
                $user->use_mobile = $request->use_mobile;
                $user->use_pwd = Hash::make( $request->use_pwd);
                $user->use_lastdate = Carbon::now();
                $user->use_note = $request->use_note;

              $user->update();

                return response()->json([
                    'status'=>200,
                    'message'=>'User Updated Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No User Found.'
                ]);
            }

        }
    }


    public function destroy($id)
    {

        $user = User::where('use_id' , $id)->first();

        if($user)
        {
            $user->delete();
            
            return response()->json([
                'status'=>200,
                'message'=>'User Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No User Found.'
            ]);
        }
    }

       
    public function Active(Request $request)
    {

        $user = User::where('use_id' , $request->id)->first();

        $user->use_active = '1';

        $user->update();

        return response()->json([
            'status'=>200,
            'message'=>'User Deleted Successfully.'
        ]);
     
    }

    public function UnActive(Request $request)
    {

        $user = User::where('use_id' , $request->id)->first();

        $user->use_active = '0';

        $user->update();

        return response()->json([
            'status'=>200,
            'message'=>'User Deleted Successfully.'
        ]);
    }
    

    public function getLogout()
    {
        auth('web')->logout();

        return redirect('/home');
    }
}
