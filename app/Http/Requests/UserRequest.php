<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
           
            'use_mobile' => 'required_without:id|unique:users|max:10', Rule::unique('delivery')->ignore('del_id'),
            'use_pwd' => 'required_without:id',
          
           
        ];
    }

    public function messages()
    {
        return [

            'required' =>  'This field is required',
            'use_mobile.max' => 'You cannot enter more than 10 characters',
           
        ];
    
    }
}
