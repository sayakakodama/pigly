<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightLog;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $targetWeight = 45.0;
        $from = $request->input('from');
        $to   = $request->input('to');

        $query = WeightLog::query()->orderByDesc('date');

        if ($from) {
            $query->whereDate('date', '>=', $from);
        }
        if ($to) {
            $query->whereDate('date', '<=', $to);
        }

        $records = $query->paginate(8);

        $latest = WeightLog::orderByDesc('date')->first();
        $latestWeight = $latest ? $latest->weight : 0;

        $summary = [
            'target_weight' => $targetWeight,
            'latest_weight' => $latestWeight,
            'to_target'     => $latestWeight - $targetWeight,
        ];

        $dateOptions = WeightLog::orderByDesc('date')
            ->limit(30)
            ->pluck('date')
            ->map(fn ($d) => $d->format('Y-m-d'));

        $searchInfo = null;
        if ($from || $to) {
            $searchInfo = [
                'from'  => $from ?: '指定なし',
                'to'    => $to ?: '指定なし',
                'count' => $records->total(),
            ];
        }

        return view('admin', compact('summary', 'records', 'dateOptions', 'searchInfo'));
    }
}
