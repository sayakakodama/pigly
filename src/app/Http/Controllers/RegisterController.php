<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\WeightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showStep1()
    {
        return view('auth.register');
    }

    public function postStep1(Request $request)
    {
        // STEP1 バリデーション
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        session([
            'register.name'     => $request->input('name'),
            'register.email'    => $request->input('email'),
            'register.password' => $request->input('password'),
        ]);

        return redirect()->route('register.step2.show');
    }

    public function showStep2()
    {
        return view('auth.register2');
    }

    public function storeStep2(Request $request, CreateNewUser $creator)
{
    Log::error('HIT storeStep2', $request->all());

    Log::error('SESSION register', [
        'name' => session('register.name'),
        'email' => session('register.email'),
        'password_exists' => session()->has('register.password'),
    ]);

    $validated = $request->validate([
        'current_weight' => ['required', 'numeric', 'between:1,999.9'],
        'target_weight'  => ['required', 'numeric', 'between:1,999.9'],
    ]);

    Log::error('VALIDATED OK', $validated);

    $data = [
        'name'     => session('register.name'),
        'email'    => session('register.email'),
        'password' => session('register.password'),
    ];

    if (!$data['name'] || !$data['email'] || !$data['password']) {
        Log::error('SESSION LOST', $data);

        return redirect()->route('register.step1')
            ->withErrors(['register' => 'セッションが切れました。最初からやり直してください。']);
    }

    try {
        Log::error('BEFORE create user', ['email' => $data['email']]);

        $user = $creator->create($data);

        Log::error('AFTER create user', ['user_id' => $user->id]);

        $user->target_weight = (float) $validated['target_weight'];
        $user->save();
        Log::error('AFTER save target_weight', ['user_id' => $user->id]);

        WeightLog::create([
            'user_id' => $user->id,
            'date'    => now()->toDateString(),
            'weight'  => (float) $validated['current_weight'],
        ]);
        Log::error('AFTER create weight_log', ['user_id' => $user->id]);

        Auth::login($user);
        Log::error('AFTER login', ['user_id' => $user->id]);

        session()->forget(['register.name','register.email','register.password']);
        Log::error('AFTER session forget');

        return redirect()->route('weight_logs.index');

    } catch (\Throwable $e) {
        Log::error('STORESTEP2 EXCEPTION', [
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ]);
        Log::error('STORESTEP2 TRACE', explode("\n", $e->getTraceAsString()));

        return back()->withErrors(['register' => '登録処理でエラーが発生しました。ログを確認してください。']);
    }
}
}