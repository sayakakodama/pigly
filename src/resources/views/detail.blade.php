<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weight Log</title>

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}?v={{ time() }}">
</head>
<body>

{{-- ===== ヘッダー ===== --}}
<header class="header">
    <div class="header-inner">
        <h1 class="logo">PiGLy</h1>

        <div class="header-actions">
            <a href="{{ route('goal_setting.edit') }}" class="header-btn">
                ⚙ 目標体重設定
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="header-btn">⏻ ログアウト</button>
            </form>
        </div>
    </div>
</header>

<main class="detail-main">
    <section class="detail-card">
        <h2 class="detail-title">Weight Log</h2>

        {{-- 更新（PUT） --}}
        <form action="{{ route('records.update', $weightLog->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">日付</label>
                <input
                    class="form-input {{ $errors->has('date') ? 'is-error' : '' }}"
                    type="date"
                    name="date"
                    value="{{ old('date', optional($weightLog->date)->format('Y-m-d')) }}"
                >
                @error('date')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">体重</label>
                <div class="input-unit">
                    <input
                        class="form-input {{ $errors->has('weight') ? 'is-error' : '' }}"
                        type="text"
                        name="weight"
                        value="{{ old('weight', $weightLog->weight) }}"
                        inputmode="decimal"
                    >
                    <span class="unit">kg</span>
                </div>
                @error('weight')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">摂取カロリー</label>
                <div class="input-unit">
                    <input
                        class="form-input {{ $errors->has('calories') ? 'is-error' : '' }}"
                        type="text"
                        name="calories"
                        value="{{ old('calories', $weightLog->calories) }}"
                        inputmode="numeric"
                    >
                    <span class="unit">cal</span>
                </div>
                @error('calories')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">運動時間</label>
                <input
                    class="form-input {{ $errors->has('exercise_time') ? 'is-error' : '' }}"
                    type="time"
                    name="exercise_time"
                    value="{{ old('exercise_time', $weightLog->exercise_time) }}"
                >
                @error('exercise_time')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">運動内容</label>
                <textarea
                    class="form-textarea {{ $errors->has('exercise_content') ? 'is-error' : '' }}"
                    name="exercise_content"
                >{{ old('exercise_content', $weightLog->exercise_content) }}</textarea>
                @error('exercise_content')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="detail-actions">
                <a href="{{ route('weight_logs.index') }}" class="btn btn-gray">戻る</a>

                <button type="submit" class="btn btn-gradient">更新</button>
            </div>
          </form>

                <form action="{{ route('records.destroy', $weightLog->id) }}"
                      method="POST"
                      class="delete-form"
                      onsubmit="return confirm('削除しますか？')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" aria-label="削除">🗑</button>
                </form>
            </div>
        </form>
    </section>
</main>

</body>
</html>
