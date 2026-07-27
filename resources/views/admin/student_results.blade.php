@extends('layouts.app')

@section('title', 'Student Career Report - CareerAware')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <a href="{{ route('admin.students') }}" class="text-decoration-none text-muted">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to students list
        </a>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-lg-12">
        <div class="glass-card p-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <span class="badge bg-primary mb-2 text-uppercase">{{ $student->department }}</span>
                    <h1 class="fw-bold mb-1 text-glow-cyan" style="color: var(--accent-secondary);">{{ $student->name }}</h1>
                    <p class="text-muted mb-0">
                        Email: {{ $student->email }}
                        @if($result)
                            | Assessment taken on {{ $result->created_at->format('M d, Y') }}
                        @endif
                    </p>
                </div>
                <div>
                    <!-- Print Button -->
                    <button onclick="window.print()" class="btn btn-glass-secondary me-2">
                        <i class="fa-solid fa-print me-1"></i> Print Report
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!$result || empty($result->top_careers))
    <div class="glass-card p-5 text-center text-muted">
        <i class="fa-solid fa-file-invoice fs-1 mb-3"></i>
        <p>No assessment result found for this student.</p>
    </div>
@else
    <div class="row g-4">
        <!-- Left: Career DNA (Full Scores) -->
        <div class="col-lg-4">
            <div class="glass-card p-4">
                <h4 class="fw-bold mb-4"><i class="fa-solid fa-dna text-violet me-2" style="color: var(--accent-primary);"></i>Career DNA</h4>
                <p class="text-muted small mb-4">Raw interest scores calculated across all 15 technical career paths.</p>

                <div class="d-flex flex-column gap-3">
                    @php
                        $scores = $result->career_scores ?? [];
                        arsort($scores); // Sort descending
                        $maxScore = max($scores) > 0 ? max($scores) : 1;
                    @endphp

                    @foreach($scores as $code => $score)
                        <div>
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="fw-semibold text-white">{{ $code }}</span>
                                <span class="text-muted">{{ $score }} pts</span>
                            </div>
                            <div class="progress bg-dark" style="height: 6px; border: 1px solid rgba(255, 255, 255, 0.05);">
                                <div class="progress-bar" role="progressbar" 
                                    style="width: {{ ($score / $maxScore) * 100 }}%; background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));" 
                                    aria-valuenow="{{ $score }}" aria-valuemin="0" aria-valuemax="{{ $maxScore }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Top 3 Recommendations & Details -->
        <div class="col-lg-8">
            <h3 class="fw-bold mb-4 text-glow-cyan"><i class="fa-solid fa-medal text-warning me-2"></i>Top 3 Career Recommendations</h3>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs border-secondary mb-4" id="recommendationTabs" role="tablist">
                @foreach($result->top_careers as $index => $career)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $index === 0 ? 'active text-glow-cyan text-white' : 'text-muted' }} fw-bold" 
                            id="tab-{{ $career['code'] }}" 
                            data-bs-toggle="tab" 
                            data-bs-target="#panel-{{ $career['code'] }}" 
                            type="button" role="tab" 
                            aria-controls="panel-{{ $career['code'] }}" 
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                            #{{ $index + 1 }} {{ $career['name'] }}
                            <span class="badge bg-secondary ms-1 small">{{ $career['confidence'] }}%</span>
                        </button>
                    </li>
                @endforeach
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="recommendationTabsContent">
                @foreach($result->top_careers as $index => $career)
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                        id="panel-{{ $career['code'] }}" 
                        role="tabpanel" 
                        aria-labelledby="tab-{{ $career['code'] }}">
                        
                        <div class="glass-card p-5">
                            <!-- Header Info -->
                            <div class="row mb-5 align-items-center">
                                <div class="col-md-8">
                                    <h2 class="fw-bold text-white mb-2">{{ $career['name'] }}</h2>
                                    <p class="text-muted fs-5 mb-0">{{ $career['description'] }}</p>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <div class="p-3 bg-dark rounded border border-secondary d-inline-block text-start w-100">
                                        <div class="mb-1"><span class="text-muted small">Demand:</span> <span class="badge bg-success float-end">{{ $career['demand_status'] }}</span></div>
                                        <div><span class="text-muted small">Salary:</span> <span class="text-white fw-bold float-end">{{ $career['salary_range'] }}</span></div>
                                    </div>
                                </div>
                            </div>

                            <!-- SWOT Analysis -->
                            <div class="mb-5">
                                <h4 class="fw-bold mb-4 text-glow-cyan"><i class="fa-solid fa-chart-pie me-2 text-cyan"></i>SWOT Analysis</h4>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="p-3 bg-dark rounded border border-success-subtle h-100">
                                            <h6 class="text-success fw-bold"><i class="fa-solid fa-circle-plus me-1"></i> Strengths</h6>
                                            <ul class="small text-muted mb-0 ps-3">
                                                @foreach(($career['swot']['strengths'] ?? []) as $str)
                                                    <li>{{ $str }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-dark rounded border border-danger-subtle h-100">
                                            <h6 class="text-danger fw-bold"><i class="fa-solid fa-circle-minus me-1"></i> Weaknesses</h6>
                                            <ul class="small text-muted mb-0 ps-3">
                                                @foreach(($career['swot']['weaknesses'] ?? []) as $weak)
                                                    <li>{{ $weak }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-dark rounded border border-info-subtle h-100">
                                            <h6 class="text-info fw-bold"><i class="fa-solid fa-arrow-trend-up me-1"></i> Opportunities</h6>
                                            <ul class="small text-muted mb-0 ps-3">
                                                @foreach(($career['swot']['opportunities'] ?? []) as $opp)
                                                    <li>{{ $opp }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 bg-dark rounded border border-warning-subtle h-100">
                                            <h6 class="text-warning fw-bold"><i class="fa-solid fa-triangle-exclamation me-1"></i> Threats</h6>
                                            <ul class="small text-muted mb-0 ps-3">
                                                @foreach(($career['swot']['threats'] ?? []) as $threat)
                                                    <li>{{ $threat }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Skills & Certifications -->
                            <div class="row g-4 mb-5">
                                <div class="col-md-6">
                                    <h5 class="fw-bold text-white mb-3"><i class="fa-solid fa-brain me-2 text-violet"></i>Key Skills to Acquire</h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach(($career['skills'] ?? []) as $skill)
                                            <span class="badge bg-secondary px-3 py-2 rounded">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="fw-bold text-white mb-3"><i class="fa-solid fa-certificate me-2 text-warning"></i>Industry Certifications</h5>
                                    <ul class="small text-muted ps-3 mb-0">
                                        @foreach(($career['certifications'] ?? []) as $cert)
                                            <li>{{ $cert }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <!-- Projects -->
                            <div class="mb-5">
                                <h5 class="fw-bold text-white mb-3"><i class="fa-solid fa-diagram-project me-2 text-cyan"></i>Recommended Portfolio Projects</h5>
                                <div class="row g-3">
                                    @foreach(($career['projects'] ?? []) as $proj)
                                        <div class="col-12">
                                            <div class="p-3 bg-dark rounded border border-secondary">
                                                <h6 class="text-white fw-bold mb-1">{{ $proj }}</h6>
                                                <p class="text-muted small mb-0">Build this practical application to prove your competency to recruiters.</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Learning Roadmap -->
                            <div>
                                <h4 class="fw-bold mb-4 text-glow-cyan"><i class="fa-solid fa-route me-2 text-cyan"></i>Learning Roadmap</h4>
                                <div class="position-relative ps-4" style="border-left: 2px solid var(--border-color);">
                                    @foreach(($career['roadmap'] ?? []) as $stepIndex => $step)
                                        <div class="mb-4 position-relative">
                                            <div class="position-absolute rounded-circle bg-dark d-flex align-items-center justify-content-center" 
                                                style="width: 28px; height: 28px; left: -39px; top: -2px; border: 2px solid var(--accent-primary);">
                                                <span class="text-white small fw-bold">{{ $stepIndex + 1 }}</span>
                                            </div>
                                            <h6 class="text-white fw-bold mb-1">Phase {{ $stepIndex + 1 }}</h6>
                                            <p class="text-muted small mb-0">{{ $step }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
@endsection
