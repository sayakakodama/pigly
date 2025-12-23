<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Register2Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'current_weight' => [
                'required',
                'numeric',
                'max:9999.9', // 4桁まで
                'regex:/^\d+(\.\d{1})?$/', // 小数点1桁
            ],
            'target_weight' => [
                'required',
                'numeric',
                'max:9999.9',
                'regex:/^\d+(\.\d{1})?$/',
            ],
        ];
    }

    public function messages()
    {
        return [
            'current_weight.required' => '現在の体重を入力してください',
            'current_weight.numeric' => '数値で入力してください',
            'current_weight.max' => '4桁までの数字で入力してください',
            'current_weight.regex' => '小数点は1桁で入力してください',

            'target_weight.required' => '目標の体重を入力してください',
            'target_weight.numeric' => '数値で入力してください',
            'target_weight.max' => '4桁までの数字で入力してください',
            'target_weight.regex' => '小数点は1桁で入力してください',
        ];
    }
}
