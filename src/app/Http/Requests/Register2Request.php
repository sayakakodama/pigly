<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Register2Request extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'current_weight' => is_string($this->current_weight) ? trim($this->current_weight) : $this->current_weight,
            'target_weight'  => is_string($this->target_weight)  ? trim($this->target_weight)  : $this->target_weight,
        ]);
    }

    public function rules()
    {
        return [
            'current_weight' => ['required', 'numeric', 'between:1,999.9'],
            'target_weight'  => ['required', 'numeric', 'between:1,999.9'],
        ];
    }

    public function messages()
    {
        return [
            'current_weight.required' => '現在の体重を入力してください',
            'current_weight.numeric'  => '数値で入力してください',
            'current_weight.between'  => '1〜9_
