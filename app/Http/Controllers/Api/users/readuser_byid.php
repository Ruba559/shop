<?php

namespace App\Http\Controllers\Api\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class readuser_byid extends Controller
{
   
    public function getUser()
    { 
  
        $user = User::select('use_name', 'use_mobile' , 'use_pwd' , 'use_active' , 'use_note' )->where( 'use_id' , $_GET['use_id'])->first();

        return response()->json($user);

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
