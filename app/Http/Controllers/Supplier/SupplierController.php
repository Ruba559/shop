<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use ImageResize;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Supplier;
use Illuminate\Support\Facades\Hash;


class SupplierController extends Controller
{


 public function __construct()
    {
         
           $this->middleware('permission:supplier-list|supplier-create|supplier-edit|supplier-delete', ['only' => ['show']]);
           $this->middleware('permission:supplier-create', ['only' => ['create','store']]);
           $this->middleware('permission:supplier-edit', ['only' => ['edit','update']]);
           $this->middleware('permission:supplier-delete', ['only' => ['destroy']]);  
    }



    public function index()
    {
        
        return view('dashboard.Supplier.supplier');
    }


    public function indexAdd()
    {

        return view('dashboard.Supplier.add-supplier');

    }


    public function fetchSupplier()
    {
        $supplier = Supplier::get();

        return response()->json([
            'supplier'=>$supplier,
        ]);

    }


   public function store(Request $request)
    { 
       
        $validator = Validator::make($request->all(), [
            'sup_name'=> 'required|max:191',
            'sup_pwd'=> 'required|max:191',
            'sup_mobile'=> 'required',
            'sup_email'=> 'nullable',
            'sup_address'=> 'required',
            'sup_note'=> 'nullable',

        ]);
       
        if($validator->fails())
        {
            return redirect('/add_product')->withErrors($validator)
            ->withInput();
        }

                $supplier = new Supplier();

                $supplier->sup_name = $request->sup_name;
                $supplier->sup_pwd = Hash::make( $request->sup_pwd);
                $supplier->sup_mobile = $request->sup_mobile;
                $supplier->sup_email = $request->sup_email;
                $supplier->sup_block = '0';
                $supplier->sup_token = '0';
                $supplier->sup_address = $request->sup_address;
                $supplier->sup_note = $request->sup_note;
                $supplier->sup_regdate = Carbon::now();
                            
                $supplier->save();

               
             return redirect('/supplier');

    }


    public function edit($id)
    {
        $supplier = Supplier::where('sup_id' , $id)->first();

        if($supplier)
        {
            return response()->json([
                'status'=>200,
                'supplier'=> $supplier,
    
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Supplier Found.'
            ]);
        }

    }


    public function update(Request $request)
    {

        if($request->sup_pwd != $request->sup_pwd_confirm)
        {
            return response()->json([
                'status'=>4000,
                'message'=>'not match',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'sup_name'=> 'required|max:191',
            
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
            $supplier = Supplier::where('sup_id' ,  $request->sup_id)->first();

            if($supplier )
            {
                $supplier->sup_name =  $request->sup_name;
                $supplier->sup_mobile = $request->sup_mobile;
                $supplier->sup_pwd = Hash::make( $request->sup_pwd);
                $supplier->sup_note = $request->sup_note;
                $supplier->sup_email = $request->sup_email;
                $supplier->sup_address = $request->sup_address;


              $supplier->update();

                return response()->json([
                    'status'=>200,
                    'message'=>'User Supplier Successfully.'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Supplier Found.'
                ]);
            }

        }
    }


    public function destroy($id)
    {

        $supplier = Supplier::where('sup_id' , $id)->first();
            
    
        if($supplier)
        {
            $supplier->delete();
            
            return response()->json([
                'status'=>200,
                'message'=>'Supplier Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Supplier Found.'
            ]);
        }

    }
    
   


}
