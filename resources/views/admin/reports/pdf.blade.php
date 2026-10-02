<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; }
        h1 { font-size: 18px; color: #1B4332; margin: 0 0 4px; }
        .meta { color: #64748b; font-size: 10px; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #1B4332; color: #fff; text-align: left; padding: 6px 8px; font-size: 10px; }
        td { padding: 6px 8px; border-bottom: 1px solid #e2e8f0; }
        tr:nth-child(even) td { background: #f8fafc; }
        .empty { text-align: center; color: #94a3b8; padding: 20px; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="meta">
        {{ ucfirst($type) }} report &middot; Generated {{ now()->format('M d, Y H:i') }} by {{ auth()->user()->name }}
        &middot; {{ count($rows) }} {{ \Illuminate\Support\Str::plural('row', count($rows)) }}
    </div>

    <table>
        <thead>
            <tr>
                @foreach($headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td class="empty" colspan="{{ count($headings) }}">No data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
