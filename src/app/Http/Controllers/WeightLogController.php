<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use App\Http\Requests\WeightLogRequest;
use Illuminate\Support\Facades\Auth;

class WeightLogController extends Controller
{
    public function store(WeightLogRequest $request)
    {
        $validated = $request->validated();

        WeightLog::create([
            'user_id' => Auth::id(),
            'date' => $validated['date'],
            'weight' => $validated['weight'],
            'calories' => $validated['calories'],
            'exercise_time' => $validated['exercise_time'],
            'exercise_content' => $validated['exercise_content'] ?? null,
        ]);

        return redirect()
            ->route('weight_logs.index')
            ->with('success', 'データを登録しました');
    }

    public function show(WeightLog $weightLog)
    {
        return view('detail', compact('weightLog'));
    }
}
