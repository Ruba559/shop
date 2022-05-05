<?php

namespace App\Http\Controllers\Api\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class insert_user extends Controller
{
  

    public function addUser(Request $request)
    { 
  
        $validated = $request->validate([
            'use_mobile' => 'required|unique:users',
            'use_pwd' => 'required',
            'use_note' => 'nullable',
        ]);

        $token = Str::random(60);

        $user = User::create([
            'use_name' => $request->use_name,
            'use_mobile' => $request->use_mobile,
            'use_note' => $request->use_note,
            'use_active' => '0',
            'use_token' => hash('sha256', $token),
            'use_pwd' => Hash::make( $request->use_pwd),
            'use_datetime' => Carbon::now(),
            'use_lastdate' => Carbon::now(),
        ]);

        $user->save();

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
