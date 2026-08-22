@extends('layouts.app')

@section('title', 'Create Session - WatyAssessment')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="mb-4">
            <a href="{{ route('admin.sessions.index') }}" class="text-decoration-none text-muted">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to list
            </a>
        </div>

        <div class="glass-card p-5">
            <h2 class="fw-bold mb-4 text-glow-cyan" style="color: var(--accent-secondary);">Create Awareness Session</h2>
            <p class="text-muted mb-5">After creation, a unique access code and QR code registration link will be generated automatically.</p>

            <form action="{{ route('admin.sessions.store') }}" method="POST">
                @csrf

                <!-- Session Title -->
                <div class="mb-4">
                    <label for="title" class="form-label-custom">Session Title</label>
                    <input type="text" name="title" id="title" 
                        class="form-control form-control-custom @error('title') is-invalid @enderror" 
                        placeholder="e.g., Annual Tech Careers Awareness 2026" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Session Description -->
                <div class="mb-4">
                    <label for="description" class="form-label-custom">Description (Optional)</label>
                    <textarea name="description" id="description" rows="4" 
                        class="form-control form-control-custom" 
                        placeholder="Provide details about the session agenda, speaker, or location...">{{ old('description') }}</textarea>
                </div>

                <!-- Date -->
                <div class="mb-4">
                    <label for="date" class="form-label-custom">Session Date</label>
                    <input type="date" name="date" id="date" 
                        class="form-control form-control-custom @error('date') is-invalid @enderror" 
                        value="{{ old('date', date('Y-m-d')) }}" required>
                    @error('date')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Active Toggle -->
                <div class="mb-5 form-check form-switch">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                    <label class="form-check-label text-muted" for="is_active">Make this session active immediately</label>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-3">
                    <button type="submit" class="btn-premium">
                        <i class="fa-solid fa-save me-2"></i> Save Session
                    </button>
                    <a href="{{ route('admin.sessions.index') }}" class="btn btn-glass-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
