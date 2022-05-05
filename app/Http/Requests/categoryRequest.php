<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class categoryRequest extends FormRequest
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
           
            'cat_name_en' => 'required_without:id',
            'cat_name' => 'required_without:id',
            'cat_image' => 'mimes:jpg,jpeg,png',
          
           
        ];
    }


    public function messages()
    {
        return [

            'required' =>  'This field is required',
           
        ];
    
    }
}
