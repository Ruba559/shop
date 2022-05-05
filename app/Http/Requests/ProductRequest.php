<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
           
            'foo_name' => 'required_without:id',
            'foo_name_en' => 'required_without:id',
            'foo_image' => 'mimes:jpg,jpeg,png',
            'cat_id' => 'required_without:id',
            'foo_price' => 'required',
            'foo_info_en' => 'nullable',
            'foo_offer' => 'nullable',
            'foo_info' => 'nullable',
        ];
    }

    public function messages()
    {
        return [

            'required' =>  'This field is required',
           
        ];
    
    }
}
