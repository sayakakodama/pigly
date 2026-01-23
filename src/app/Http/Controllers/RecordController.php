<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeightLogRequest;
use App\Models\WeightLog;
use Illuminate\Support\Facades\Auth;

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
            ->with('success', '登録しました');
    }

    // 編集画面（今回は detail を編集画面として使う）
    public function edit(WeightLog $record)
    {
        // 自分のデータ以外を触れないように
        abort_if($record->user_id !== Auth::id(), 403);

        // detail.blade を編集画面として使う
        return view('detail', ['weightLog' => $record]);
    }

    // 更新処理
    public function update(WeightLogRequest $request, WeightLog $record)
    {
        abort_if($record->user_id !== Auth::id(), 403);

        $validated = $request->validated();

        $record->update([
            'date' => $validated['date'],
            'weight' => $validated['weight'],
            'calories' => $validated['calories'],
            'exercise_time' => $validated['exercise_time'],
            'exercise_content' => $validated['exercise_content'] ?? null,
        ]);

        return redirect()
            ->route('weight_logs.show', $record->id)
            ->with('success', '更新しました');
    }

    // 削除処理
    public function destroy(WeightLog $record)
    {
        abort_if($record->user_id !== Auth::id(), 403);

        $record->delete();

        return redirect()
            ->route('weight_logs.index')
            ->with('success', '削除しました');
    }
}
