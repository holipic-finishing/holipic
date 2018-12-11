<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSignupRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5', 
            'checkbox' => 'required'    
        ];
    }

    public function messages()
    {
        return [
            'first_name.required'   => 'The first name field is require',
            'last_name.required'    => 'The last name field is require',
            'company_name.required' => 'The company name field is require',

            'email.required'        => 'The email field is require',
            'email.email'           => 'The email must be a valid email address',

            'password.required'     => 'The password field is require',
            'password.email'        => 'The password must be least 5 characters',

            'checkbox.required'     => 'Please check terms and conditions of Holipic'

           
        ];
    }
}
