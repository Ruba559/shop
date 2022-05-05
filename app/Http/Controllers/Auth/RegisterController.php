<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Customer;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
   

    use RegistersUsers;

    
    protected $redirectTo = RouteServiceProvider::HOME;

   
    public function __construct()
    {
        $this->middleware('guest');
    }

   
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'cus_name' => ['required', 'string', 'max:255'],
            'cus_mobile' => ['required', 'string', 'max:255', 'unique:customer'],
            'cus_pwd' => ['required', 'string', 'min:6'],
            'cus_address' => ['required', 'string', 'max:255'],

        ]);
    }

   
    protected function create(array $data)
    {
        return Customer::create([
            'cus_name' => $data['cus_name'],
            'cus_email' => $data['cus_email'],
            'cus_pwd' => Hash::make($data['cus_pwd']),
            'cus_mobile' => $data['cus_mobile'],
            'cus_address' => $data['cus_address'],
        ]);

    }
}
