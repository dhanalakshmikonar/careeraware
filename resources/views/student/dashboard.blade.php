@extends('layouts.app')

@section('title', 'My Dashboard - CareerAware')

@section('content')
<div class="row mb-5">
    <div class="col">
        <h1 class="fw-bold text-glow-cyan">Welcome, {{ Auth::user()->name }}</h1>
        <p class="text-muted">Track your awareness session, take the assessment, and view your career recommendations.</p>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="glass-card p-4 h-100">
            <div class="fs-1 text-muted opacity-50 mb-3"><i class="fa-solid fa-chalkboard-user"></i></div>
            <h5 class="fw-bold text-white mb-2">Current Session</h5>
            @if($currentSession)
                <p class="text-muted mb-3">{{ $currentSession->title }}</p>
                <span class="badge {{ $currentSession->is_active ? 'bg-success' : 'bg-secondary' }}">
                    {{ $currentSession->is_active ? 'Active' : 'Closed' }}
                </span>
            @else
                <p class="text-muted mb-3">You haven't joined a session yet.</p>
                <a href="{{ route('student.session.join') }}" class="btn btn-premium btn-sm">Join a Session</a>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="glass-card p-4 h-100">
            <div class="fs-1 text-muted opacity-50 mb-3"><i class="fa-solid fa-clipboard-question"></i></div>
            <h5 class="fw-bold text-white mb-2">Assessment</h5>
            @if($currentSession)
                <p class="text-muted mb-3">Answer scenario-based questions to discover your ideal tech career.</p>
                <a href="{{ route('student.assessment') }}" class="btn btn-premium-cyan btn-sm">Take Assessment</a>
            @else
                <p class="text-muted mb-3">Join a session first to unlock the assessment.</p>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="glass-card p-4 h-100">
            <div class="fs-1 text-muted opacity-50 mb-3"><i class="fa-solid fa-file-invoice"></i></div>
            <h5 class="fw-bold text-white mb-2">My Report</h5>
            @if($latestResult)
                <p class="text-muted mb-3">Your career recommendations are ready.</p>
                <a href="{{ route('student.results') }}" class="btn btn-glass-secondary btn-sm">View Report</a>
            @else
                <p class="text-muted mb-3">Complete the assessment to generate your report.</p>
            @endif
        </div>
    </div>
</div>

<div class="glass-card p-4">
    <h5 class="fw-bold text-white mb-2"><i class="fa-solid fa-circle-info me-2 text-cyan"></i>Your Activity</h5>
    <p class="text-muted mb-0">You have joined {{ $joinedSessionsCount }} {{ \Illuminate\Support\Str::plural('session', $joinedSessionsCount) }} so far.</p>
</div>
@endsection
