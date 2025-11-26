<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightLogRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認可OK
    }

    public function rules()
    {
        return [
            'date' => ['required', 'date'],
            'weight' => ['required', 'numeric', 'between:0,300'],
            'calories' => ['required', 'integer', 'min:0'],
            'exercise_time' => ['required'],
            'exercise_content' => ['nullable', 'string', 'max:200'],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付は必須です。',
            'date.date' => '正しい日付を選択してください。',

            'weight.required' => '体重は必須です。',
            'weight.numeric' => '体重は数値で入力してください。',
            'weight.between' => '体重は0〜300kgの範囲で入力してください。',

            'calories.required' => '摂取カロリーは必須です。',
            'calories.integer' => 'カロリーは整数で入力してください。',

            'exercise_time.required' => '運動時間は必須です。',

            'exercise_content.max' => '運動内容は120文字以内で入力してください。',
        ];
    }
}
