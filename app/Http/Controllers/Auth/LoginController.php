<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;

class LoginController extends Controller
{
   

    use AuthenticatesUsers;

  
    protected $redirectTo = RouteServiceProvider::HOME;

   
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:customer')->except('logout');
    }





    // public function username()
    // {

    //     $login = request()->input('username');
       
    //     $user = User::where('use_mobile' , $login)->first();
       
    //  if($user->use_active == '1')
    //   {
           
    //     if(is_numeric($login)){
    //         $field = 'use_mobile';
    
    //     } 

    //     request()->merge([$field => $login]);

    //     return $field;

    //   }else
      
    //   return 'f';

    // }


    public function Login(Request $request)
    {
  
    $user = User::where('use_mobile' , $request->username)->first();
    $customer = Customer::where('cus_mobile' , $request->username)->first();

    if($customer)
    {
    if(!$customer || !Hash::check($request->password , $customer->cus_pwd))
    {

        return redirect()->intended('/login_site')->with(['message' => 'not match']);

    }else{

    Auth::guard('customer')->login($customer);
    return redirect('/');

    }
    return redirect()->intended('/login_site')->with(['message' => 'not match']);
    }

  //  return redirect()->intended('/login_site')->with(['message' => 'not match']);

      if($user)
    {
     if(!$user || !Hash::check($request->password , $user->use_pwd)){

        return redirect()->intended('/login')->with(['message' => 'not match']);
    }else{

    Auth::guard('web')->login($user);

    return redirect('/home');

     }
   
    }
   // return redirect()->intended('/login')->with(['message' => 'not match']);
   
   

    }
   
}
