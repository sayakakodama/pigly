<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeightLogRequest;
use App\Models\WeightLog;

class RecordController extends Controller
{
    // 追加画面表示
    public function create()
    {
        return view('records.create');
    }

    // 登録処理
    public function store(WeightLogRequest $request)
    {
        WeightLog::create([
            'user_id' => auth()->id(),
            'date' => $request->date,
            'weight' => $request->weight,
            'calories' => $request->calories,
            'exercise_time' => $request->exercise_time,
            'exercise_content' => $request->exercise_content,
        ]);

        return redirect()
            ->route('weight_logs.index')
            ->with('success', '登録しました');
    }
}
