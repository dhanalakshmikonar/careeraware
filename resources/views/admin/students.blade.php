@extends('layouts.app')

@section('title', 'Manage Students - CareerAware')

@section('content')
<div class="row mb-5">
    <div class="col-md-8">
        <h1 class="fw-bold text-glow-cyan">Student Management</h1>
        <p class="text-muted">View student profiles, review completed assessments, and export results data.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="{{ route('admin.exports.students.csv') }}" class="btn btn-glass-secondary text-success border-success-subtle">
            <i class="fa-solid fa-file-excel me-2"></i> Export Excel (CSV)
        </a>
    </div>
</div>

<!-- Search & Filter Card -->
<div class="glass-card p-4 mb-5">
    <form action="{{ route('admin.students') }}" method="GET" class="row g-3 align-items-end">
        <!-- Search Input -->
        <div class="col-md-5">
            <label for="search" class="form-label-custom">Search Student</label>
            <div class="input-group">
                <span class="input-group-text bg-slate border-slate text-muted" style="border: 1px solid var(--border-color); background-color: var(--bg-tertiary);">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" id="search" class="form-control form-control-custom" placeholder="Search by name, email, or phone..." value="{{ request('search') }}">
            </div>
        </div>

        <!-- Department Filter -->
        <div class="col-md-4">
            <label for="department" class="form-label-custom">Filter by Department</label>
            <select name="department" id="department" class="form-select form-control-custom">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                @endforeach
            </select>
        </div>

        <!-- Buttons -->
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn-premium w-100 py-2.5">
                <i class="fa-solid fa-filter me-1"></i> Filter
            </button>
            <a href="{{ route('admin.students') }}" class="btn btn-glass-secondary w-100 py-2.5">Reset</a>
        </div>
    </form>
</div>

<!-- Students Table -->
<div class="glass-card p-4">
    @if($students->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="fa-solid fa-users-slash fs-1 mb-3"></i>
            <p class="mb-0">No student records found matching the criteria.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Mobile Number</th>
                        <th>Email Address</th>
                        <th>Department</th>
                        <th>Registered Date</th>
                        <th>Assessment Result</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>
                                <span class="fw-semibold text-white">{{ $student->name }}</span>
                            </td>
                            <td>
                                <span class="text-muted"><i class="fa-solid fa-phone me-1 small"></i>{{ $student->phone ?? 'N/A' }}</span>
                            </td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <span class="badge bg-secondary px-3 py-1.5">{{ $student->department ?? 'Other' }}</span>
                            </td>
                            <td>{{ $student->created_at->format('M d, Y') }}</td>
                            <td>
                                @php
                                    $result = $student->results->first();
                                @endphp
                                @if($result)
                                    @php
                                        $topCareer = $result->top_careers[0] ?? null;
                                    @endphp
                                    @if($topCareer)
                                        <span class="badge-premium-cyan">
                                            {{ $topCareer['name'] }} ({{ $topCareer['confidence'] }}%)
                                        </span>
                                    @else
                                        <span class="badge bg-success">Completed</span>
                                    @endif
                                @else
                                    <span class="badge bg-dark text-muted border border-secondary">Not Attempted</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group gap-2">
                                    @if($result)
                                        <a href="{{ route('admin.students.results', $student->id) }}" class="btn btn-premium btn-sm py-1 px-3">
                                            <i class="fa-solid fa-chart-pie me-1"></i> Report
                                        </a>
                                    @endif
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student? All their responses and results will be permanently removed.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm py-1 px-3">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $students->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
