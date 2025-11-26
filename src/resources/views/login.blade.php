<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PiGLy ログイン</title>

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-bg">
        <div class="login-container">
            <h1 class="logo">PiGLy</h1>
            <h2 class="title">ログイン</h2>

            @if (session('error'))
                <p class="error-message global-error">{{ session('error') }}</p>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group @error('email') has-error @enderror">
                    <label for="email">メールアドレス</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="メールアドレスを入力"
                    >
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group @error('password') has-error @enderror">
                    <label for="password">パスワード</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="パスワードを入力"
                    >
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="button-area">
                    <button type="submit" class="login-button">ログイン</button>
                </div>
            </form>

            <p class="link-text">
                <a href="{{ route('register.step1') }}">アカウント作成はこちら</a>
            </p>
        </div>
    </div>
</body>
</html>
