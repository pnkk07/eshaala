<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'lastname' =>'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' =>'string|min:8|confirmed|regex:/[a-z]/|regex:/[A-z]/|regex:/[@$!%*#?&]/|regex:/[0-9]/',
        ];
    }
    public function messages(){
        return [
            'password.regex' => 'Password must have 
            - one uppercase letter,
               one lowercase letter,
               one numeric value,
               one special character (@$!%*#?&)'
        ];
    }
}
