<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationFormValidation extends FormRequest
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

        switch($this->method())
        {
            case 'POST':
                return [
                    'name' => 'required|max:200',
                    'email_id' => 'required|email|unique:User_Details',
                    'phone_number'=> 'required|integer|unique:User_Details|digits:10',
                    'password' => 'required|min:6',
                    'password_confirmation' => 'required|min:6|same:password',
                ];
            case 'PUT':
                return [
                    'name' => 'required|max:200',
                    'email_id' => 'required|email|unique:User_Details',
                ];
        }
    }
}
