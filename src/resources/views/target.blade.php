<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>目標体重設定 | PiGLy</title>

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/target.css') }}">
</head>
<body>

<header class="header">
    <div class="header-inner">
        <div class="header-logo">PiGLy</div>

        <div class="header-actions">
            <a href="{{ route('weight_logs.index') }}" class="header-btn">
                戻る
            </a>

            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="header-btn header-btn-outline">ログアウト</button>
            </form>
        </div>
    </div>
</header>

<main class="main">
    <div class="card">

        <h2 class="title">目標体重設定</h2>

        <form action="{{ route('target.update') }}" method="POST" class="form">
            @csrf

            <div class="form-group">
                <input
                    type="text"
                    name="target_weight"
                    value="{{ old('target_weight', $target_weight) }}"
                    class="input"
                >
                <span class="unit">kg</span>
            </div>

            @error('target_weight')
                <p class="error">{{ $message }}</p>
            @enderror

            <div class="buttons">
                <a href="{{ route('weight_logs.index') }}" class="btn-cancel">戻る</a>
                <button type="submit" class="btn-submit">更新</button>
            </div>
        </form>

    </div>
</main>

</body>
</html>
