<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Daftar Item') · Evolusi PL</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, -apple-system, "Segoe UI", sans-serif; background: #f3f4f6; color: #1f2937; }
        .container { max-width: 760px; margin: 48px auto; padding: 0 16px; }
        h1 { font-size: 1.5rem; margin: 0 0 4px; color: #0c2d48; }
        .subtitle { color: #6b7280; margin: 0 0 24px; font-size: .9rem; }
        .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 20px; margin-bottom: 20px; }
        .alert { padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; font-size: .9rem; }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert-error ul { margin: 0; padding-left: 18px; }
        label { display: block; font-size: .85rem; font-weight: 600; margin-bottom: 4px; }
        input, textarea { width: 100%; padding: 8px 10px; border: 1px solid #d1d5db; border-radius: 6px; font: inherit; margin-bottom: 12px; }
        .btn { display: inline-block; border: 0; border-radius: 6px; padding: 7px 14px; font-size: .8rem; font-weight: 600; cursor: pointer; text-decoration: none; color: #fff; }
        .btn-primary { background: #1e4f7a; }
        .btn-edit { background: #f59e0b; }
        .btn-delete { background: #dc2626; }
        .btn-muted { background: #9ca3af; }
        table { width: 100%; border-collapse: collapse; font-size: .9rem; }
        th, td { text-align: left; padding: 10px 8px; border-bottom: 1px solid #f0f0f0; vertical-align: top; }
        th { color: #6b7280; font-weight: 600; font-size: .8rem; text-transform: uppercase; letter-spacing: .04em; }
        .actions { white-space: nowrap; display: flex; gap: 6px; }
        .actions form { margin: 0; }
        .empty { color: #9ca3af; text-align: center; padding: 24px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Aplikasi Web Evolusi PL</h1>
        <p class="subtitle">Pengelolaan data item sederhana dengan Laravel</p>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
