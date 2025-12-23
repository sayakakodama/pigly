<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}?v={{ time() }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="register-container">
        <h1 class="logo">PiGLy</h1>
        <h2 class="title">新規会員登録</h2>
        <p class="step-text">アカウント情報の登録</p>

        {{-- ★ Fortifyの正解 --}}
        <form method="POST" action="/register" novalidate>
            @csrf

            <div class="form-group">
                <label for="name">お名前</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password">
                @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="submit-btn">アカウント作成</button>

            <p class="login-link">
                <a href="/login">ログインはこちら</a>
            </p>
        </form>
    </div>
</body>
</html>
