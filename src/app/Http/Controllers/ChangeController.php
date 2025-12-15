<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TargetWeight;

class ChangeContoroller extends Controller
{
    // 目標体重設定画面 表示
    public function edit()
    {
        $targetWeight = TargetWeight::where('user_id', Auth::id())->first();

        return view('change', compact('targetWeight'));
    }

    // 目標体重 更新処理
    public function update(Request $request)
    {
        $request->validate([
            'target_weight' => ['required', 'numeric', 'between:20,300'],
        ], [
            'target_weight.required' => '目標体重を入力してください',
            'target_weight.numeric' => '数字で入力してください',
            'target_weight.between' => '20〜300kgの範囲で入力してください',
        ]);

        TargetWeight::updateOrCreate(
            ['user_id' => Auth::id()],
            ['target_weight' => $request->target_weight]
        );

        return redirect()->route('weight_logs.index');
    }
}
