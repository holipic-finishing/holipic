<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginAPIRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:5',     
        ];
    }

    public function messages()
    {
        return [
            'email.required'   => 'Please type email',
            'email.email'      => 'Incorrect email', 
            'password.required' => 'Please type password',
            'password.min' => 'Enter at least 5 characters',
        ];
    }
}
