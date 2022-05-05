<?php

namespace App\Http\Controllers\Api\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class delete_user extends Controller
{
  

    public function deleteUser()
    { 
  
        $user = User::where('use_id' , $_GET['use_id']);
       
       if (!$user)
        {

        return $this->returnError('002', 'لا يوجد بيانات');
        }

        $user->delete();

        return $this->returnSuccessMessage('Successful');

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
