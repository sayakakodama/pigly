<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>PiGLy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">

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

<main class="main">
<div class="container">

    {{-- ===== サマリー ===== --}}
    <section class="summary-card">
        <div class="summary-item">
            <p class="summary-label">目標体重</p>
            <p class="summary-value">
                {{ number_format($summary['target_weight'], 1) }}<span>kg</span>
            </p>
        </div>

        <div class="summary-divider"></div>

        <div class="summary-item">
            <p class="summary-label">目標まで</p>
            <p class="summary-value">
                {{ number_format($summary['to_target'], 1) }}<span>kg</span>
            </p>
        </div>

        <div class="summary-divider"></div>

        <div class="summary-item">
            <p class="summary-label">最新体重</p>
            <p class="summary-value">
                {{ number_format($summary['latest_weight'], 1) }}<span>kg</span>
            </p>
        </div>
    </section>

    {{-- ===== 一覧 ===== --}}
    <section class="records-card">

        {{-- 検索 + 追加 --}}
        <div class="records-header">
            <form method="GET" action="{{ route('weight_logs.index') }}" class="search-form">
                <input type="date" name="from" value="{{ request('from') }}">
                <span>〜</span>
                <input type="date" name="to" value="{{ request('to') }}">
                <button type="submit" class="search-btn">検索</button>

                @if(request()->filled('from') || request()->filled('to'))
                <button type="button" class="reset-btn"onclick="location.href='{{ route('weight_logs.index') }}'">
                リセット
                </button>
            @endif
        </form>

            <button type="button" class="add-btn" id="openModalBtn">
                データ追加
            </button>
        </div>

        {{-- 検索情報 --}}
        @if ($searchInfo)
            <p class="search-info">
                {{ $searchInfo['from'] }} 〜 {{ $searchInfo['to'] }}
                ：{{ $searchInfo['count'] }}件
            </p>
        @endif

        {{-- 一覧テーブル --}}
        <table class="records-table">
            <thead>
                <tr>
                    <th>日付</th>
                    <th>体重</th>
                    <th>摂取カロリー</th>
                    <th>運動時間</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr>
                        <td>{{ $record->date->format('Y/m/d') }}</td>
                        <td>{{ $record->weight }}kg</td>
                        <td>{{ $record->calories }}cal</td>
                        <td>{{ $record->exercise_time ? \Carbon\Carbon::parse($record->exercise_time)->format('H:i') : '' }}
</td>

                        <td class="table-edit-column">
    <a href="{{ route('records.edit', $record->id) }}" class="edit-icon">✏︎</a>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-data">
                            該当するデータがありません
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- ページネーション --}}
        <div class="pagination">
            {{ $records->links() }}
        </div>

    </section>
</div>
</main>

{{-- ================= モーダル ================= --}}
<div class="modal-overlay" id="weightLogModal">

    <div class="modal-box">

        <h2 class="modal-title">Weight Logを追加</h2>

        <form action="{{ route('weight_logs.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>日付 <span class="required">必須</span></label>
                <input type="date"
                name="date" value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}"
>

                @error('date')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>体重 <span class="required">必須</span></label>
                <div class="unit-input">
                    <input type="text" name="weight" value="{{ old('weight') }}">
                    <span>kg</span>
                </div>
                @error('weight')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>摂取カロリー <span class="required">必須</span></label>
                <div class="unit-input">
                    <input type="text" name="calories" value="{{ old('calories') }}">
                    <span>cal</span>
                </div>
                @error('calories')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>運動時間 <span class="required">必須</span></label>
                <input type="time" name="exercise_time" value="{{ old('exercise_time') }}">
                @error('exercise_time')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>運動内容</label>
                <textarea name="exercise_content">{{ old('exercise_content') }}</textarea>

                @error('exercise_content')
                  <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="modal-buttons">
                <button type="button" class="btn-cancel" id="closeModalBtn">戻る</button>
                <button type="submit" class="btn-submit">登録</button>
            </div>
        </form>

    </div>
</div>

{{-- ===== JS ===== --}}
<script>
const modal = document.getElementById('weightLogModal');
const openBtn = document.getElementById('openModalBtn');
const closeBtn = document.getElementById('closeModalBtn');

openBtn.addEventListener('click', () => {
    modal.classList.add('is-active');
});

closeBtn.addEventListener('click', () => {
    modal.classList.remove('is-active');
});

modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.classList.remove('is-active');
    }
});
</script>

{{-- バリデーションエラー時：自動でモーダル再表示 --}}
@if ($errors->any())
<script>
    window.onload = () => {
        document.getElementById('weightLogModal').classList.add('is-active');
    };
</script>
@endif

</body>
</html>
