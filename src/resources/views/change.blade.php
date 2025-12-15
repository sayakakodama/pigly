<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>目標体重設定 | PiGLy</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/change.css') }}">
</head>
<body>

<header class="header">
    <div class="header-left">
        <h1 class="logo">PiGLy</h1>
    </div>

    <div class="header-right">
        <a href="{{ route('target.edit') }}" class="header-btn">
            ⚙ 目標体重設定
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="header-btn">⎋ ログアウト</button>
        </form>
    </div>
</header>

<main class="main">
    <div class="change-container">
        <h2 class="change-title">目標体重設定</h2>

        <form action="{{ route('target.update') }}" method="POST" class="change-form">
            @csrf
            @method('PUT')

            <div class="input-group">
                <input
                    type="number"
                    step="0.1"
                    name="target_weight"
                    value="{{ old('target_weight', $targetWeight->target_weight ?? '') }}"
                    class="weight-input"
                >
                <span class="kg">kg</span>
            </div>

            @error('target_weight')
                <p class="error">{{ $message }}</p>
            @enderror

            <div class="btn-group">
                <a href="{{ route('weight_logs.index') }}" class="back-btn">戻る</a>
                <button type="submit" class="update-btn">更新</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>
