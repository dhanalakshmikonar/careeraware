@extends('layouts.app')

@section('title', 'Manage Sessions - CareerAware')

@section('content')
<div class="row mb-5 align-items-center">
    <div class="col-md-8">
        <h1 class="fw-bold text-glow-cyan">Awareness Sessions</h1>
        <p class="text-muted">Generate codes, share registration links/QRs, and monitor live attendance.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="{{ route('admin.sessions.create') }}" class="btn btn-premium">
            <i class="fa-solid fa-plus me-2"></i> Create New Session
        </a>
    </div>
</div>

<div class="glass-card p-4">
    @if($sessions->isEmpty())
        <div class="text-center py-5">
            <i class="fa-solid fa-calendar-xmark fs-1 text-muted mb-3"></i>
            <h4 class="fw-bold text-muted">No Sessions Found</h4>
            <p class="text-muted mb-4">Start by creating your first career awareness session.</p>
            <a href="{{ route('admin.sessions.create') }}" class="btn btn-premium btn-sm">Create Session</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Session Code</th>
                        <th>Date</th>
                        <th>Participants</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                        <tr>
                            <td>
                                <span class="fw-semibold text-white">{{ $session->title }}</span>
                            </td>
                            <td>
                                <code class="badge bg-dark border border-secondary text-glow-cyan px-3 py-2 fs-6" style="color: var(--accent-secondary);">
                                    {{ $session->session_code }}
                                </code>
                            </td>
                            <td>{{ $session->date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge bg-secondary px-3 py-2 rounded">
                                    <i class="fa-solid fa-users me-1"></i> {{ $session->students_count }}
                                </span>
                            </td>
                            <td>
                                @if($session->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success px-2.5 py-1.5 rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-muted border border-secondary px-2.5 py-1.5 rounded-pill">Closed</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group gap-2">
                                    <a href="{{ route('admin.sessions.show', $session->id) }}" class="btn btn-premium-cyan btn-sm py-1 px-3">
                                        <i class="fa-solid fa-eye me-1"></i> View & Share
                                    </a>
                                    <a href="{{ route('admin.sessions.edit', $session->id) }}" class="btn btn-glass-secondary btn-sm py-1 px-3">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.sessions.destroy', $session->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this session? All joined records will be deleted.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm py-1 px-3">
                                            <i class="fa-solid fa-trash"></i>
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
            {{ $sessions->links() }}
        </div>
    @endif
</div>
@endsection
