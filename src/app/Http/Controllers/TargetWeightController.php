<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TargetWeightController extends Controller
{
    public function edit()
    {
        return view('target', [
            'target_weight' => Auth::user()->target_weight
        ]);
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'target_weight' => [
                    'required',
                    'numeric',
                    'max:9999',
                    'regex:/^\d{1,4}(\.\d)?$/',
                ],
            ],
            [
                'target_weight.required' => '目標の体重を入力してください',
                'target_weight.numeric'  => '数字で入力してください',
                'target_weight.max'      => '4桁までの数字で入力してください',
                'target_weight.regex'    => '小数点は1桁で入力してください',
            ]
        );

        $user = Auth::user();
        $user->target_weight = $request->target_weight;
        $user->save();

        return redirect()->route('weight_logs.index')
            ->with('success', '目標体重を更新しました');
    }
}
