<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;


class UserController extends Controller
{
   
    
    public function update(Request $request)
    {

            if($request->use_pwd != $request->use_pwd_confirm)
            {
               return redirect()->back()->with(['message_confirm' => 'wrong to confirm password']);
            }

            $user = User::where('use_id' , $request->id)->first();
           
                $user->use_name =  $request->use_name;
                $user->use_mobile = $request->use_mobile;
                $user->use_pwd = Hash::make( $request->use_pwd);
                $user->use_lastdate = Carbon::now();
                $user->use_node = $request->use_node;

             $user->update();
         
            //toastr()->success('Updated');
           return redirect()->route('User.index');
       

    }

     
    public function Active(Request $request)
    {

        $user = User::where('use_id' , $request->id)->first();

        $user->use_active = '1';

        $user->update();

        return redirect()->route('User.index');
     
    }

    public function UnActive(Request $request)
    {

        $user = User::where('use_id' , $request->id)->first();

        $user->use_active = '0';

        $user->update();

        return redirect()->route('User.index');
     
    }


    public function getLogout()
    {
        auth()->logout();

        return redirect('/');
    }
}
