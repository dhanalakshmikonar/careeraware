@extends('layouts.app')

@section('title', 'Session Details - CareerAware')

@section('content')
<div class="row mb-4">
    <div class="col">
        <a href="{{ route('admin.sessions.index') }}" class="text-decoration-none text-muted">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to sessions
        </a>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Session Details Column -->
    <div class="col-lg-7">
        <div class="glass-card p-5 h-100 d-flex flex-column justify-content-between">
            <div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <span class="badge-premium-cyan"><i class="fa-solid fa-calendar me-1"></i> {{ $session->date->format('M d, Y') }}</span>
                    @if($session->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-secondary">Closed</span>
                    @endif
                </div>

                <h1 class="fw-bold mb-3 text-glow-cyan" style="color: var(--accent-secondary);">{{ $session->title }}</h1>
                <p class="text-muted fs-5 mb-4">{{ $session->description ?? 'No description provided for this session.' }}</p>
            </div>

            <!-- Share Area -->
            <div class="border-top border-secondary pt-4 mt-4">
                <h5 class="fw-semibold text-white mb-3">Join Link & Code</h5>
                
                <div class="input-group mb-3">
                    <span class="input-group-text border-slate bg-slate text-muted" style="border: 1px solid var(--border-color); background-color: var(--bg-tertiary);">
                        <i class="fa-solid fa-link"></i>
                    </span>
                    <input type="text" id="joinUrl" class="form-control form-control-custom text-glow-cyan bg-dark border-secondary" value="{{ $joinUrl }}" readonly>
                    <button class="btn btn-premium-cyan" onclick="copyLink()">
                        <i class="fa-solid fa-copy me-1"></i> Copy
                    </button>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted">Direct Access Code:</span>
                    <code class="fs-4 bg-dark px-3 py-1.5 border border-secondary text-glow-violet rounded" style="color: var(--accent-primary); letter-spacing: 1px;">
                        {{ $session->session_code }}
                    </code>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code Card -->
    <div class="col-lg-5">
        <div class="glass-card p-5 text-center h-100 d-flex flex-column align-items-center justify-content-center">
            <h4 class="fw-bold mb-3">Registration QR Code</h4>
            <p class="text-muted small mb-4">Students can scan this QR code to join the session and start their assessment instantly.</p>
            
            <div class="bg-white p-3 rounded-4 shadow-lg mb-4 d-inline-block">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($joinUrl) }}" alt="Session QR Code" class="img-fluid" style="width: 220px; height: 220px;">
            </div>

            <div class="d-flex gap-2 w-100">
                <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ urlencode($joinUrl) }}" target="_blank" class="btn btn-glass-secondary w-100">
                    <i class="fa-solid fa-download me-1"></i> Open Full Size
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Participant List -->
<div class="glass-card p-4">
    <h3 class="fw-bold mb-4"><i class="fa-solid fa-users me-2 text-cyan"></i>Joined Participants ({{ $students->total() }})</h3>

    @if($students->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="fa-solid fa-users-slash fs-1 mb-3"></i>
            <p class="mb-0">No students have joined this session yet.</p>
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
                        <th>Joined At</th>
                        <th class="text-center">Assessment Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td><span class="text-white fw-semibold">{{ $student->name }}</span></td>
                            <td><span class="text-muted"><i class="fa-solid fa-phone me-1 small"></i>{{ $student->phone ?? 'N/A' }}</span></td>
                            <td>{{ $student->email }}</td>
                            <td><span class="badge bg-secondary">{{ $student->department }}</span></td>
                            <td>{{ $student->pivot->joined_at->format('M d, Y - h:i A') }}</td>
                            <td class="text-center">
                                @php
                                    $result = $student->results()->where('awareness_session_id', $session->id)->first();
                                @endphp
                                @if($result)
                                    <a href="{{ route('admin.students.results', $student->id) }}" class="btn btn-premium btn-sm py-1 px-3">
                                        <i class="fa-solid fa-square-poll-vertical me-1"></i> View Results
                                    </a>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning px-2.5 py-1.5 rounded-pill">In Progress / Pending</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function copyLink() {
    const copyText = document.getElementById("joinUrl");
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices
    navigator.clipboard.writeText(copyText.value);
    
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Join link copied to clipboard!',
        showConfirmButton: false,
        timer: 2000,
        background: '#131a26',
        color: '#f8fafc'
    });
}
</script>
@endsection
