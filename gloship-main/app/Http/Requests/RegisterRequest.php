<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'username' => 'required|alpha_dash|min:3|max:15|unique:users,username',
            'phone' => 'required',
            'firstname' => 'required|string|min:2|max:40',
            'lastname' => 'required|string|min:2|max:40',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'country' => 'exists:App\Models\Countries,id'
        ];
    }
}