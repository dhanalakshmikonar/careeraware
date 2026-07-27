@extends('layouts.app')

@section('title', 'Admin Dashboard - CareerAware')

@section('content')
<div class="row mb-5">
    <div class="col">
        <h1 class="fw-bold text-glow-cyan">Admin Dashboard</h1>
        <p class="text-muted">Real-time system insights, analytics, and session participation statistics</p>
    </div>
</div>

<!-- Metrics Row -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted d-block small mb-1 uppercase fw-semibold">Total Students</span>
                <h2 class="fw-bold mb-0 text-glow-cyan" style="color: var(--accent-secondary);">{{ $totalStudents }}</h2>
            </div>
            <div class="fs-1 text-muted opacity-50"><i class="fa-solid fa-users"></i></div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted d-block small mb-1 uppercase fw-semibold">Awareness Sessions</span>
                <h2 class="fw-bold mb-0 text-glow-violet" style="color: var(--accent-primary);">{{ $totalSessions }}</h2>
            </div>
            <div class="fs-1 text-muted opacity-50"><i class="fa-solid fa-chalkboard-user"></i></div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted d-block small mb-1 uppercase fw-semibold">Active Sessions</span>
                <h2 class="fw-bold mb-0 text-glow-cyan" style="color: var(--accent-success);">{{ $activeSessionsCount }}</h2>
            </div>
            <div class="fs-1 text-muted opacity-50"><i class="fa-solid fa-circle-play text-success"></i></div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted d-block small mb-1 uppercase fw-semibold">Assessments Taken</span>
                <h2 class="fw-bold mb-0 text-glow-violet" style="color: var(--accent-primary);">{{ $totalAssessmentsCompleted }}</h2>
            </div>
            <div class="fs-1 text-muted opacity-50"><i class="fa-solid fa-clipboard-check"></i></div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mb-5">
    <!-- Chart 1: Career Distribution -->
    <div class="col-lg-6">
        <div class="glass-card p-4 h-100">
            <h4 class="fw-bold mb-4"><i class="fa-solid fa-pie-chart text-primary me-2"></i>Career Distribution (#1 Match)</h4>
            <div class="chart-container" style="position: relative; height: 350px;">
                <canvas id="careerChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart 2: Session Participation -->
    <div class="col-lg-6">
        <div class="glass-card p-4 h-100">
            <h4 class="fw-bold mb-4"><i class="fa-solid fa-chart-bar text-cyan me-2"></i>Session-wise Participation</h4>
            <div class="chart-container" style="position: relative; height: 350px;">
                <canvas id="sessionChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Chart 3: Department-wise Interest -->
    <div class="col-lg-12">
        <div class="glass-card p-4">
            <h4 class="fw-bold mb-4"><i class="fa-solid fa-graduation-cap text-success me-2"></i>Department-wise Career Interest</h4>
            <div class="chart-container" style="position: relative; height: 400px;">
                <canvas id="deptChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action shortcuts -->
<div class="row g-4 mb-4">
    <div class="col text-center">
        <h4 class="fw-bold mb-4">Quick Management Actions</h4>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('admin.sessions.create') }}" class="btn btn-premium"><i class="fa-solid fa-plus me-2"></i>Create Session</a>
            <a href="{{ route('admin.students') }}" class="btn btn-premium-cyan"><i class="fa-solid fa-users me-2"></i>View Student List</a>
            <a href="{{ route('admin.questions.create') }}" class="btn btn-glass-secondary"><i class="fa-solid fa-circle-question me-2"></i>Add Question</a>
            <a href="{{ route('admin.exports.students.csv') }}" class="btn btn-glass-secondary text-success border-success-subtle"><i class="fa-solid fa-file-excel me-2"></i>Export Students (CSV)</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Styling constants
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.08)';
    Chart.defaults.font.family = "'Outfit', sans-serif";

    // 1. Career Distribution Chart (Doughnut)
    const careerCtx = document.getElementById('careerChart').getContext('2d');
    const careerLabels = {!! json_encode($careerLabels) !!};
    const careerCounts = {!! json_encode($careerCounts) !!};

    const hasCareerData = careerCounts.some(c => c > 0);

    if (!hasCareerData) {
        // Render placeholder when empty
        new Chart(careerCtx, {
            type: 'doughnut',
            data: {
                labels: ['No Data Available'],
                datasets: [{
                    data: [1],
                    backgroundColor: ['rgba(255, 255, 255, 0.05)'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    } else {
        new Chart(careerCtx, {
            type: 'doughnut',
            data: {
                labels: careerLabels,
                datasets: [{
                    data: careerCounts,
                    backgroundColor: [
                        '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444',
                        '#ec4899', '#3b82f6', '#14b8a6', '#6366f1', '#a855f7',
                        '#eab308', '#f97316', '#0ea5e9', '#d946ef', '#64748b'
                    ],
                    borderWidth: 1,
                    borderColor: '#131a26'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            padding: 10
                        }
                    }
                }
            }
        });
    }

    // 2. Session Participation Chart (Bar)
    const sessionCtx = document.getElementById('sessionChart').getContext('2d');
    const sessionLabels = {!! json_encode($sessionLabels) !!};
    const sessionCounts = {!! json_encode($sessionCounts) !!};

    new Chart(sessionCtx, {
        type: 'bar',
        data: {
            labels: sessionLabels,
            datasets: [{
                label: 'Participants Count',
                data: sessionCounts,
                backgroundColor: 'rgba(6, 182, 212, 0.6)',
                borderColor: 'var(--accent-secondary)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // 3. Department-wise Career Interest Chart (Stacked Bar)
    const deptCtx = document.getElementById('deptChart').getContext('2d');
    
    // Parse the PHP double array structure for Javascript
    const deptInterest = {!! json_encode($deptInterest) !!};
    const depts = Object.keys(deptInterest);
    
    // Get list of all distinct careers that appeared as recommendations
    const allInterestCareers = new Set();
    depts.forEach(dept => {
        Object.keys(deptInterest[dept]).forEach(career => {
            allInterestCareers.add(career);
        });
    });
    const interestCareers = Array.from(allInterestCareers);

    // Build datasets for each career
    const colors = [
        '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444',
        '#ec4899', '#3b82f6', '#14b8a6', '#6366f1', '#a855f7',
        '#eab308', '#f97316', '#0ea5e9', '#d946ef', '#64748b'
    ];

    const datasets = interestCareers.map((career, index) => {
        const data = depts.map(dept => {
            return deptInterest[dept][career] || 0;
        });

        return {
            label: career,
            data: data,
            backgroundColor: colors[index % colors.length],
            borderWidth: 0,
            stack: 'Stack 0'
        };
    });

    new Chart(deptCtx, {
        type: 'bar',
        data: {
            labels: depts.length > 0 ? depts : ['No Data'],
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { stacked: true },
                y: { 
                    stacked: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15
                    }
                }
            }
        }
    });
});
</script>
@endsection
