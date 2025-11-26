<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use Illuminate\Http\Request;

class WeightLogController extends Controller
{
    public function show(WeightLog $weightLog)
    {
        return view('detail', compact('weightLog'));
    }
}
