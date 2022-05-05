<?php

namespace App\Http\Controllers\Api\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class update_user extends Controller
{
  

      public function editUser(Request $request)
    { 
  
        $validated = $request->validate([
            'use_mobile' => 'required|unique:users',
            'use_pwd' => 'required',
            'use_note' => 'nullable',
        ]);

        $user = User::where('use_id' ,  $_GET['use_id'])->first();

            $user->update([
                'use_name' => $request->use_name,
                'use_mobile' => $request->use_mobile,
                'use_note' => $request->use_note,
                'use_pwd' => Hash::make( $request->use_pwd),
                'use_lastdate' => Carbon::now(),
              ]);

        return $this -> returnSuccessMessage('Successful');

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
