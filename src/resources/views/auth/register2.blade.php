<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register2.css') }}">
</head>
<body>
    <div class="register-wrapper">
        <div class="register-container">
            <h1 class="logo">PiGLy</h1>
            <h2 class="title">新規会員登録</h2>
            <p class="step-text">STEP2 体重データの入力</p>

            <form action="{{ route('register.step2') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="current_weight">現在の体重</label>
                    <input type="text" id="current_weight" name="current_weight"
                        value="{{ old('current_weight') }}"
                        placeholder="現在の体重を入力">
                    <span class="kg">kg</span>

                    @error('current_weight')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="target_weight">目標の体重</label>
                    <input type="text" id="target_weight" name="target_weight"
                        value="{{ old('target_weight') }}"
                        placeholder="目標の体重を入力">
                    <span class="kg">kg</span>

                    @error('target_weight')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">アカウント作成</button>

            </form>
        </div>
    </div>
</body>
</html>
