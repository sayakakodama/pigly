<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiGLy 管理画面</title>

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<header class="header">
    <div class="header-inner">
        <div class="header-logo">PiGLy</div>

        <div class="header-actions">
            <a href="{{ route('goal_setting.edit') }}" class="header-btn">
                <span class="header-btn-icon">⚙</span> 目標体重設定
            </a>

            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="header-btn header-btn-outline">
                    <span class="header-btn-icon">⏻</span> ログアウト
                </button>
            </form>
        </div>
    </div>
</header>

<main class="main">
    <div class="main-inner">

        <section class="summary-card">
            <div class="summary-item">
                <p class="summary-label">目標体重</p>
                <p class="summary-value">
                    {{ number_format($summary['target_weight'], 1) }}
                    <span class="summary-unit">kg</span>
                </p>
            </div>

            <div class="summary-divider"></div>

            <div class="summary-item">
                <p class="summary-label">目標まで</p>
                <p class="summary-value">
                    {{ $summary['to_target'] > 0 ? '+' : '' }}
                    {{ number_format($summary['to_target'], 1) }}
                    <span class="summary-unit">kg</span>
                </p>
            </div>

            <div class="summary-divider"></div>

            <div class="summary-item">
                <p class="summary-label">最新体重</p>
                <p class="summary-value">
                    {{ number_format($summary['latest_weight'], 1) }}
                    <span class="summary-unit">kg</span>
                </p>
            </div>
        </section>

        <section class="records-card">

            <div class="records-header">
                {{-- search --}}
                <form action="{{ route('weight_logs.index') }}" method="GET" class="search-form">
                    <div class="search-range">
                        <div class="search-field">
                            <select name="from" class="search-select">
                                <option value="">年/月/日</option>
                                @foreach($dateOptions as $date)
                                    <option value="{{ $date }}" {{ request('from') === $date ? 'selected' : '' }}>
                                        {{ $date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <span class="search-range-separator">〜</span>

                        <div class="search-field">
                            <select name="to" class="search-select">
                                <option value="">年/月/日</option>
                                @foreach($dateOptions as $date)
                                    <option value="{{ $date }}" {{ request('to') === $date ? 'selected' : '' }}>
                                        {{ $date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="search-buttons">
                        <button type="submit" class="search-btn">検索</button>
                        <a href="{{ route('weight_logs.index') }}" class="reset-btn">リセット</a>
                    </div>
                </form>

                <div class="records-actions">
                    <button type="button" class="add-btn" id="openModalBtn">データ追加</button>
                </div>
            </div>

            @if(!empty($searchInfo))
                <p class="search-info">
                    {{ $searchInfo['from'] }}〜{{ $searchInfo['to'] }} の検索結果
                    {{ $searchInfo['count'] }}件
                </p>
            @endif

            <div class="table-wrapper">
                <table class="records-table">
                    <thead>
                        <tr>
                            <th>日付</th>
                            <th>体重</th>
                            <th>食事摂取カロリー</th>
                            <th>運動時間</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($records as $record)
                            <tr>
                                <td>{{ $record->date->format('Y/m/d') }}</td>
                                <td>{{ $record->weight }}kg</td>
                                <td>{{ $record->calories }}cal</td>
                                <td>{{ $record->exercise_time }}</td>
                                <td class="table-edit-column">
                                    <a href="{{ route('records.edit', $record) }}" class="edit-icon">✏︎</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="table-empty">データがありません。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-area">

    @if ($records->hasPages())
        <ul class="pagination">

            @if ($records->onFirstPage())
                <li class="disabled"><span>&lsaquo;</span></li>
            @else
                <li><a href="{{ $records->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
            @endif

            @foreach ($records->getUrlRange(1, $records->lastPage()) as $page => $url)
                @if ($page == $records->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($records->hasMorePages())
                <li><a href="{{ $records->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
            @else
                <li class="disabled"><span>&rsaquo;</span></li>
            @endif

        </ul>
    @endif

<div id="weightLogModal" class="modal-overlay">

    <div class="modal-content">

        <h2 class="modal-title">Weight Logを追加</h2>

        <form action="{{ route('records.store') }}" method="POST">
            @csrf

            <div class="modal-form-group">
                <label>日付 <span class="required">必須</span></label>
                <input type="date" name="date" value="{{ old('date') }}">
                @error('date')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="modal-form-group">
                <label>体重 <span class="required">必須</span></label>
                <div class="modal-input-unit">
                    <input type="text" name="weight" value="{{ old('weight') }}">
                    <span class="unit">kg</span>
                </div>
                @error('weight')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="modal-form-group">
                <label>摂取カロリー <span class="required">必須</span></label>
                <div class="modal-input-unit">
                    <input type="text" name="calories" value="{{ old('calories') }}">
                    <span class="unit">cal</span>
                </div>
                @error('calories')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="modal-form-group">
                <label>運動時間 <span class="required">必須</span></label>
                <input type="time" name="exercise_time" value="{{ old('exercise_time') }}">
                @error('exercise_time')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="modal-form-group">
                <label>運動内容</label>
                <textarea name="exercise_content">{{ old('exercise_content') }}</textarea>
                @error('exercise_content')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="modal-buttons">
                <button type="button" class="modal-cancel" id="closeModalBtn">戻る</button>
                <button type="submit" class="modal-submit">登録</button>
            </div>

        </form>
    </div>
</div>

<script>
document.getElementById('openModalBtn').addEventListener('click', function () {
    document.getElementById('weightLogModal').style.display = 'flex';
});

document.getElementById('closeModalBtn').addEventListener('click', function () {
    document.getElementById('weightLogModal').style.display = 'none';
});

@if ($errors->any())
    document.getElementById('weightLogModal').style.display = 'flex';
@endif
</script>
</div>
