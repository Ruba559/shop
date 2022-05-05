<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DeliveryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           
            'del_mobile' => 'required_without:id|min:10|numeric' , Rule::unique('delivery')->ignore('del_id'),
            'del_pwd' => 'required_without:id',
            'del_name' => 'required|string',
            'del_image' => 'nullable|mimes:jpg,jpeg,png',
           
        ];
    }

    public function messages()
    {
        return [

            'required' =>  'This field is required',
          
           
        ];
    
    }
}