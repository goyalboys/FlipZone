<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketFormValidation extends FormRequest
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
            'name' => 'required|max:255',
            'problem' => 'required|max:255',
            'phone_number'=> 'required|integer|digits:10|min:0',
            'subject' => 'required|max:255'
        ];
    }
}
