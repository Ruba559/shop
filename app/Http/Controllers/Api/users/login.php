<?php

namespace App\Http\Controllers\Api\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;


class login extends Controller
{

   
    public function loginUser(Request $request)
    {

       
        $user = User::where('use_mobile' , $_GET["use_mobile"])->first();

        if(!$user || !Hash::check($_GET["use_pwd"], $user->use_pwd))
        {
            return $this -> returnError('not found', '100');
        }
           Auth::guard('web')->login($user);

        return $this -> returnSuccessMessage('Successful' , '200');
     
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
