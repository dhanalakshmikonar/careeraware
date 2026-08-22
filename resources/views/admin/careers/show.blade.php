@extends('layouts.app')

@section('title', $career->name . ' - WatyAssessment')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <a href="{{ route('admin.careers.index') }}" class="text-decoration-none text-muted">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to career paths
        </a>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="{{ route('admin.careers.edit', $career->id) }}" class="btn btn-premium-cyan">
            <i class="fa-solid fa-pen me-2"></i> Edit
        </a>
    </div>
</div>

<div class="glass-card p-5 mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <span class="badge bg-secondary mb-2">{{ $career->code }}</span>
            <h1 class="fw-bold mb-2 text-glow-cyan" style="color: var(--accent-secondary);">{{ $career->name }}</h1>
            <p class="text-muted fs-5 mb-0">{{ $career->description }}</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="p-3 bg-dark rounded border border-secondary d-inline-block text-start w-100">
                <div class="mb-1"><span class="text-muted small">Demand:</span> <span class="badge bg-success float-end">{{ $career->demand_status }}</span></div>
                <div><span class="text-muted small">Salary:</span> <span class="text-white fw-bold float-end">{{ $career->salary_range }}</span></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <h5 class="fw-bold text-white mb-3"><i class="fa-solid fa-brain me-2 text-violet"></i>Key Skills</h5>
        <div class="d-flex flex-wrap gap-2">
            @foreach(($career->skills ?? []) as $skill)
                <span class="badge bg-secondary px-3 py-2 rounded">{{ $skill }}</span>
            @endforeach
        </div>
    </div>
    <div class="col-md-6">
        <h5 class="fw-bold text-white mb-3"><i class="fa-solid fa-certificate me-2 text-warning"></i>Certifications</h5>
        <ul class="small text-muted ps-3 mb-0">
            @foreach(($career->certifications ?? []) as $cert)
                <li>{{ $cert }}</li>
            @endforeach
        </ul>
    </div>
</div>

<div class="mb-4">
    <h5 class="fw-bold text-white mb-3"><i class="fa-solid fa-diagram-project me-2 text-cyan"></i>Portfolio Projects</h5>
    <div class="row g-3">
        @foreach(($career->projects ?? []) as $proj)
            <div class="col-12">
                <div class="p-3 bg-dark rounded border border-secondary">{{ $proj }}</div>
            </div>
        @endforeach
    </div>
</div>

<div class="mb-4">
    <h5 class="fw-bold text-white mb-3"><i class="fa-solid fa-route me-2 text-cyan"></i>Learning Roadmap</h5>
    <div class="position-relative ps-4" style="border-left: 2px solid var(--border-color);">
        @foreach(($career->roadmap ?? []) as $stepIndex => $step)
            <div class="mb-3 position-relative">
                <div class="position-absolute rounded-circle bg-dark d-flex align-items-center justify-content-center"
                    style="width: 26px; height: 26px; left: -37px; top: -2px; border: 2px solid var(--accent-primary);">
                    <span class="text-white small fw-bold">{{ $stepIndex + 1 }}</span>
                </div>
                <p class="text-muted small mb-0">{{ $step }}</p>
            </div>
        @endforeach
    </div>
</div>

@php $swot = $career->swot ?? []; @endphp
<div class="row g-3">
    <div class="col-md-6">
        <div class="p-3 bg-dark rounded border border-success-subtle h-100">
            <h6 class="text-success fw-bold"><i class="fa-solid fa-circle-plus me-1"></i> Strengths</h6>
            <ul class="small text-muted mb-0 ps-3">
                @foreach(($swot['strengths'] ?? []) as $str)
                    <li>{{ $str }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="p-3 bg-dark rounded border border-danger-subtle h-100">
            <h6 class="text-danger fw-bold"><i class="fa-solid fa-circle-minus me-1"></i> Weaknesses</h6>
            <ul class="small text-muted mb-0 ps-3">
                @foreach(($swot['weaknesses'] ?? []) as $weak)
                    <li>{{ $weak }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="p-3 bg-dark rounded border border-info-subtle h-100">
            <h6 class="text-info fw-bold"><i class="fa-solid fa-arrow-trend-up me-1"></i> Opportunities</h6>
            <ul class="small text-muted mb-0 ps-3">
                @foreach(($swot['opportunities'] ?? []) as $opp)
                    <li>{{ $opp }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="p-3 bg-dark rounded border border-warning-subtle h-100">
            <h6 class="text-warning fw-bold"><i class="fa-solid fa-triangle-exclamation me-1"></i> Threats</h6>
            <ul class="small text-muted mb-0 ps-3">
                @foreach(($swot['threats'] ?? []) as $threat)
                    <li>{{ $threat }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
