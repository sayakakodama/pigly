<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\Register2Request;

class RegisterController extends Controller
{
    public function showStep1()
    {
        return view('register');
    }

    public function postStep1(RegisterRequest $request)
    {
        $validated = $request->validated();

        return redirect()->route('register.step2.show');
    }

    public function showStep2()
    {
        return view('register2');
    }

    public function storeStep2(Register2Request $request)
    {
        $data = $request->validated();

        return redirect()->route('login.show')
            ->with('success', '登録が完了しました！');
    }
}
