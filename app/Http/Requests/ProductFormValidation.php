<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormValidation extends FormRequest
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
            'product_name' => 'required|max:200',
            'description' => 'required',
            'price'=> 'required|integer',
            'quantity' => 'required|max:99|integer',
            'discount' => 'required|integer|max:99',
            'company_name'=>'required',
            'image'=>'required',
            'offer'=>'required',
        ];
    }
}