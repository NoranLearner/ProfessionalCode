<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
            'name_ar' => 'required|max:100|unique:Offers,name_ar',
            'name_en' => 'required|max:100|unique:Offers,name_en',
            'price' => 'required|numeric',
            'details_ar' => 'required',
            'details_en' => 'required'
        ];
    }

    public function messages()
    {
        return [
            // 'name.required' => 'اسم العرض مطلوب',
            'name_ar.required' => __('messages.offernameRequired'),
            // 'name.unique' => 'اسم العرض موجود',
            'name_ar.unique' => __('messages.offernameUnique'),
            // 'price.numeric' => 'سعر العرض يجب ان يكون ارقام',
            'price.numeric' =>  __('messages.offerpriceNumeric'),
        ];
    }
}
