<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 0; }
        body {
            margin: 0;
            font-family: {!! $template === 'modern' ? "'DejaVu Sans', sans-serif" : "'DejaVu Serif', serif" !!};
            color: #1e293b;
            font-size: 11px;
        }
        h1 { font-size: 22px; margin: 0; }
        h2 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 0 0 6px 0;
            color: {{ $template === 'modern' ? '#3730a3' : '#1e293b' }};
        }
        p { margin: 0 0 4px 0; line-height: 1.5; }
        .section { margin-top: 16px; }
        .entry { margin-bottom: 10px; }
        .entry-header { width: 100%; }
        .entry-title { font-weight: bold; }
        .entry-period { color: #64748b; font-size: 10px; }
        .muted { color: #64748b; }
        table.layout { width: 100%; border-collapse: collapse; }
        table.layout td { vertical-align: top; }
    </style>
</head>
<body>

@if ($template === 'modern')
    <table class="layout">
        <tr>
            <td style="width: 36%; background: #312e81; color: #e0e7ff; padding: 28px 20px;">
                <h1 style="color: #ffffff;">{{ $personal['first_name'] }} {{ $personal['last_name'] }}</h1>
                @if (!empty($personal['title']))
                    <p style="color: #c7d2fe;">{{ $personal['title'] }}</p>
                @endif

                <div class="section">
                    @if (!empty($personal['email']))<p>{{ $personal['email'] }}</p>@endif
                    @if (!empty($personal['phone']))<p>{{ $personal['phone'] }}</p>@endif
                    @if (!empty($personal['city']))<p>{{ $personal['city'] }}</p>@endif
                </div>

                @if (!empty($skills))
                    <div class="section">
                        <h2 style="color: #c7d2fe;">Umiejętności</h2>
                        @foreach ($skills as $skill)
                            <p>{{ $skill }}</p>
                        @endforeach
                    </div>
                @endif
            </td>
            <td style="width: 64%; padding: 28px 24px;">
                @include('pdf.partials.body', ['personal' => $personal, 'experience' => $experience, 'education' => $education])
            </td>
        </tr>
    </table>
@else
    <div style="padding: 32px 40px;">
        <h1>{{ $personal['first_name'] }} {{ $personal['last_name'] }}</h1>
        @if (!empty($personal['title']))
            <p class="muted" style="font-size: 13px;">{{ $personal['title'] }}</p>
        @endif
        <p class="muted">{{ implode(' · ', array_filter([$personal['email'] ?? null, $personal['phone'] ?? null, $personal['city'] ?? null])) }}</p>

        @include('pdf.partials.body', ['personal' => $personal, 'experience' => $experience, 'education' => $education])

        @if (!empty($skills))
            <div class="section">
                <h2>Umiejętności</h2>
                <p>{{ implode(' · ', $skills) }}</p>
            </div>
        @endif
    </div>
@endif

</body>
</html>
