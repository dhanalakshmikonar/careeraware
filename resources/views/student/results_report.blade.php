<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Report - {{ $student->name }}</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #0b0f19; color: #f8fafc; padding: 40px; line-height: 1.6; }
        h1, h2, h3 { color: #f8fafc; }
        .header { border-bottom: 2px solid #334155; padding-bottom: 20px; margin-bottom: 30px; }
        .career-block { background: #131a26; border: 1px solid #334155; border-radius: 12px; padding: 24px; margin-bottom: 24px; }
        .badge { display: inline-block; background: #1b2436; border: 1px solid #334155; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; color: #94a3b8; }
        .grid { display: flex; gap: 20px; flex-wrap: wrap; margin-top: 16px; }
        .col { flex: 1; min-width: 220px; }
        ul { padding-left: 20px; color: #94a3b8; }
        .skill { display: inline-block; background: #1b2436; padding: 4px 10px; border-radius: 6px; margin: 2px; font-size: 0.85rem; }
        .score-row { display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 6px; color: #94a3b8; }
        @media (max-width: 600px) {
            body { padding: 20px 16px; }
            .header { padding-bottom: 14px; margin-bottom: 20px; }
            .career-block { padding: 16px; margin-bottom: 16px; }
            .col { min-width: 100%; }
            h1 { font-size: 1.65rem; }
            h2 { font-size: 1.35rem; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Career Recommendation Report</h1>
        <p>Prepared for <strong>{{ $student->name }}</strong> ({{ $student->email }}) &mdash; generated {{ $result->created_at->format('M d, Y') }}</p>
    </div>

    <h2>Career DNA (Raw Scores)</h2>
    @php
        $scores = $result->career_scores ?? [];
        arsort($scores);
    @endphp
    <div class="career-block">
        @foreach($scores as $code => $score)
            <div class="score-row"><span>{{ $code }}</span><span>{{ $score }} pts</span></div>
        @endforeach
    </div>

    <h2>Top {{ count($result->top_careers ?? []) }} Career Recommendations</h2>

    @foreach(($result->top_careers ?? []) as $index => $career)
        <div class="career-block">
            <span class="badge">#{{ $index + 1 }} Match &mdash; {{ $career['confidence'] }}% confidence</span>
            <h3>{{ $career['name'] }}</h3>
            <p>{{ $career['description'] }}</p>
            <p><strong>Salary Range:</strong> {{ $career['salary_range'] }} &nbsp;|&nbsp; <strong>Demand:</strong> {{ $career['demand_status'] }}</p>

            <div class="grid">
                <div class="col">
                    <h4>Key Skills</h4>
                    <div>
                        @foreach(($career['skills'] ?? []) as $skill)
                            <span class="skill">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="col">
                    <h4>Certifications</h4>
                    <ul>
                        @foreach(($career['certifications'] ?? []) as $cert)
                            <li>{{ $cert }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <h4>Recommended Projects</h4>
            <ul>
                @foreach(($career['projects'] ?? []) as $proj)
                    <li>{{ $proj }}</li>
                @endforeach
            </ul>

            <h4>Learning Roadmap</h4>
            <ul>
                @foreach(($career['roadmap'] ?? []) as $step)
                    <li>{{ $step }}</li>
                @endforeach
            </ul>

            @php $swot = $career['swot'] ?? []; @endphp
            <div class="grid">
                <div class="col">
                    <h4>Strengths</h4>
                    <ul>
                        @foreach(($swot['strengths'] ?? []) as $s)
                            <li>{{ $s }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col">
                    <h4>Weaknesses</h4>
                    <ul>
                        @foreach(($swot['weaknesses'] ?? []) as $s)
                            <li>{{ $s }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col">
                    <h4>Opportunities</h4>
                    <ul>
                        @foreach(($swot['opportunities'] ?? []) as $s)
                            <li>{{ $s }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col">
                    <h4>Threats</h4>
                    <ul>
                        @foreach(($swot['threats'] ?? []) as $s)
                            <li>{{ $s }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>
