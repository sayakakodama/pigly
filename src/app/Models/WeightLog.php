<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeightLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'weight',
        'calories',
        'exercise_time',
        'exercise_content',
    ];

    protected $casts = [
        'date' => 'date',              // ← format() を使えるようにする
        'exercise_time' => 'datetime:H:i', // time型を Carbon として扱える
    ];
}
