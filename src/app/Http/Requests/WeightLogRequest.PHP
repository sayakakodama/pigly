<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightLogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => ['required', 'date'],

            // 体重：必須 / 数値 / 0〜9999 / 小数1桁まで
            'weight' => [
                'required',
                'numeric',
                'min:0',
                'max:9999',
                'regex:/^\d{1,4}(\.\d{1})?$/',
            ],

            // 摂取カロリー：必須 / 数字（整数）
            'calories' => ['required', 'integer', 'min:0'],

            // 運動時間：必須（time input想定）
            'exercise_time' => ['required'],

            // 運動内容：任意 / 120文字以内
            'exercise_content' => ['nullable', 'string', 'max:120'],
        ];
    }

    public function messages()
    {
        return [
            // 日付
            'date.required' => '日付を入力してください',
            'date.date' => '日付を正しく入力してください',

            // 体重
            'weight.required' => '体重を入力してください',
            'weight.numeric' => '4桁までの数字で入力してください',
            'weight.max' => '4桁までの数字で入力してください',
            'weight.regex' => '小数点は1桁で入力してください',
            'weight.min' => '4桁までの数字で入力してください',

            // カロリー
            'calories.required' => '摂取カロリーを入力してください',
            'calories.integer' => '数字で入力してください',
            'calories.min' => '数字で入力してください',

            // 運動時間
            'exercise_time.required' => '運動時間を入力してください',

            // 運動内容
            'exercise_content.max' => '120文字以内で入力してください',
        ];
    }
}
