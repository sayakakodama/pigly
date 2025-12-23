<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\Register2Request;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showStep1()
    {
        return view('auth.register');
    }

    public function postStep1(RegisterRequest $request)
    {
        // STEP1の入力をセッションに保存
        session([
            'register.name' => $request->name,
            'register.email' => $request->email,
            'register.password' => $request->password,
        ]);

        return redirect()->route('register.step2.show');
    }

    public function showStep2()
    {
        return view('auth.register2');
    }

    public function storeStep2(Register2Request $request, CreateNewUser $creator)
    {
        // Fortifyを使ってユーザー作成（←ここが超重要）
        $user = $creator->create([
            'name' => session('register.name'),
            'email' => session('register.email'),
            'password' => session('register.password'),
        ]);

        // 作成後すぐログイン
        Auth::login($user);

        // 体重データ保存（例）
        // WeightLog::create([...]);

        // セッション削除
        session()->forget('register');

        return redirect('/weight_logs');
    }
}
