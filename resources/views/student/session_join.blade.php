@extends('layouts.app')

@section('title', 'Join a Session - WatyAssessment')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="glass-card p-5 text-center">
            <div class="fs-1 mb-3 text-glow-cyan" style="color: var(--accent-secondary);">
                <i class="fa-solid fa-right-to-bracket"></i>
            </div>
            <h2 class="fw-bold mb-2">Join an Awareness Session</h2>
            <p class="text-muted mb-5">Enter the 6-character code shared by your instructor to unlock the career assessment.</p>

            <form action="{{ route('student.session.submit') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <input type="text" name="code" id="code"
                        class="form-control form-control-custom text-center text-uppercase fs-4 @error('code') is-invalid @enderror"
                        style="letter-spacing: 4px;"
                        maxlength="6"
                        placeholder="ABC123"
                        value="{{ old('code', $prefilledCode ?? '') }}"
                        required autofocus>
                    @error('code')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-premium w-100 py-2">
                    <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Join Session
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
