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
            'email' => 'required',
            'password' => 'required|min:5',     
        ];
    }

    public function messages()
    {
        return [
            'email.required'   => 'Please enter email a address',
            'email.email'      => 'Email attribute must be in a valid format', 
            'password.required' => 'Please enter a password',
            'password.min' => 'Enter Password at least 5 characters',
        ];
    }
}
