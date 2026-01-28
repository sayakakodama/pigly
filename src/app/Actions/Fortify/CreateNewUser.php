<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input)
    {
        try {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                // ここが厳しい可能性が高い（プロジェクトによって rules が違う）
                'password' => ['required', 'string', 'min:8'],
            ])->validate();
        } catch (ValidationException $e) {
            Log::error('FORTIFY VALIDATION ERROR', [
                'errors' => $e->errors(),
                'input' => [
                    'name' => $input['name'] ?? null,
                    'email' => $input['email'] ?? null,
                    'password_len' => isset($input['password']) ? strlen($input['password']) : null,
                ],
            ]);
            throw $e;
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
