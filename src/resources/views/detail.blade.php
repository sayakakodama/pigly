<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weight Log 詳細</title>

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>
<body>

<header class="header">
    <div class="header-inner">
        <div class="header-logo">PiGLy</div>

        <div class="header-actions">
            <a href="{{ route('target.edit') }}" class="header-btn">
                ⚙ 目標体重設定
            </a>
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button class="header-btn header-btn-outline">⏻ ログアウト</button>
            </form>
        </div>
    </div>
</header>

<main class="detail-main">
    <div class="detail-card">

        <h2 class="detail-title">Weight Log</h2>

        <form action="#" method="POST">
            @csrf

            <div class="form-group">
                <label>日付</label>
                <input type="text" value="{{ $weightLog->date }}" disabled>
            </div>

            <div class="form-group">
                <label>体重</label>
                <div class="input-unit">
                    <input type="text" value="{{ $weightLog->weight }}" disabled>
                    <span class="unit">kg</span>
                </div>
            </div>

            <div class="form-group">
                <label>摂取カロリー</label>
                <div class="input-unit">
                    <input type="text" value="{{ $weightLog->calories }}" disabled>
                    <span class="unit">cal</span>
                </div>
            </div>

            <div class="form-group">
                <label>運動時間</label>
                <input type="text" value="{{ $weightLog->exercise_time }}" disabled>
            </div>

            <div class="form-group">
                <label>運動内容</label>
                <textarea disabled>{{ $weightLog->exercise_content }}</textarea>
            </div>

            <div class="detail-buttons">
                <a href="{{ route('weight_logs.index') }}" class="btn-gray">戻る</a>
                <a href="{{ route('records.edit', $weightLog->id) }}" class="btn-gradient">更新</a>

                <form action="{{ route('records.destroy', $weightLog->id) }}" method="POST" onsubmit="return confirm('削除しますか？')">
                    @csrf
                    @method('DELETE')
                    <button class="btn-delete">🗑</button>
                </form>
            </div>
        </form>

    </div>
</main>

</body>
</html>
