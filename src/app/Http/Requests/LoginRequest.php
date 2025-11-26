<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * 認可（今回は誰でも OK）
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * エラーメッセージ（日本語）
     */
    public function messages(): array
    {
        return [
            'email.required'    => 'メールアドレスを入力してください。',
            'email.email'       => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください。',
            'password.required' => 'パスワードを入力してください。',
        ];
    }
}
