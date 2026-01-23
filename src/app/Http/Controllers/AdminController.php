<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightLog;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // 仮の目標体重（※後でDB化してOK）
        $targetWeight = auth()->user()->target_weight ?? 0;

        // 検索条件
        $from = $request->input('from');
        $to   = $request->input('to');

        // ===== 一覧クエリ =====
        $query = WeightLog::where('user_id', auth()->id())
            ->orderByDesc('date');

        if ($from) {
            $query->whereDate('date', '>=', $from);
        }

        if ($to) {
            $query->whereDate('date', '<=', $to);
        }

        $records = $query
            ->paginate(8)
            ->withQueryString(); // ← 検索条件をページ送りでも保持

        // ===== 最新体重 =====
        $latest = WeightLog::where('user_id', auth()->id())
            ->orderByDesc('date')
            ->first();

        $latestWeight = $latest?->weight ?? 0;

        // ===== サマリー =====
        $summary = [
            'target_weight' => $targetWeight,
            'latest_weight' => $latestWeight,
            'to_target'     => $targetWeight - $latestWeight
        ];

        // ===== 検索情報表示用 =====
        $searchInfo = null;

        if ($from || $to) {
            $searchInfo = [
                'from'  => $from ?: '指定なし',
                'to'    => $to ?: '指定なし',
                'count' => $records->total(),
            ];
        }

        return view('admin', compact(
            'summary',
            'records',
            'searchInfo'
        ));
    }
}
