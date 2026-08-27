@if (!empty($personal['summary']))
    <div class="section">
        <p>{{ $personal['summary'] }}</p>
    </div>
@endif

@if (!empty($experience))
    <div class="section">
        <h2>Doświadczenie zawodowe</h2>
        @foreach ($experience as $job)
            <div class="entry">
                <table class="entry-header">
                    <tr>
                        <td class="entry-title">{{ $job['position'] ?? '' }}</td>
                        <td class="entry-period" style="text-align: right;">{{ $job['period'] ?? '' }}</td>
                    </tr>
                </table>
                @if (!empty($job['company']))
                    <p class="muted">{{ $job['company'] }}</p>
                @endif
                @if (!empty($job['description']))
                    <p>{{ $job['description'] }}</p>
                @endif
            </div>
        @endforeach
    </div>
@endif

@if (!empty($education))
    <div class="section">
        <h2>Wykształcenie</h2>
        @foreach ($education as $school)
            <div class="entry">
                <table class="entry-header">
                    <tr>
                        <td class="entry-title">{{ $school['school'] ?? '' }}</td>
                        <td class="entry-period" style="text-align: right;">{{ $school['period'] ?? '' }}</td>
                    </tr>
                </table>
                @if (!empty($school['field']))
                    <p class="muted">{{ $school['field'] }}</p>
                @endif
            </div>
        @endforeach
    </div>
@endif
