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
        $request->validate([
            'target_weight' => ['required', 'numeric', 'between:20,200']
        ]);

        $user = Auth::user();
        $user->target_weight = $request->target_weight;
        $user->save();

        return redirect()->route('weight_logs.index')
            ->with('success', '目標体重を更新しました');
    }
}
