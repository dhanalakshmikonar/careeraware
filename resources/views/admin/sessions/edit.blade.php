@extends('layouts.app')

@section('title', 'Edit Session - WatyAssessment')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="mb-4">
            <a href="{{ route('admin.sessions.index') }}" class="text-decoration-none text-muted">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to list
            </a>
        </div>

        <div class="glass-card p-5">
            <h2 class="fw-bold mb-4 text-glow-cyan" style="color: var(--accent-secondary);">Edit Session Details</h2>
            <p class="text-muted mb-5">Update session titles, description, dates, or active status.</p>

            <form action="{{ route('admin.sessions.update', $session->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Session Title -->
                <div class="mb-4">
                    <label for="title" class="form-label-custom">Session Title</label>
                    <input type="text" name="title" id="title" 
                        class="form-control form-control-custom @error('title') is-invalid @enderror" 
                        value="{{ old('title', $session->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Session Description -->
                <div class="mb-4">
                    <label for="description" class="form-label-custom">Description (Optional)</label>
                    <textarea name="description" id="description" rows="4" 
                        class="form-control form-control-custom">{{ old('description', $session->description) }}</textarea>
                </div>

                <!-- Date -->
                <div class="mb-4">
                    <label for="date" class="form-label-custom">Session Date</label>
                    <input type="date" name="date" id="date" 
                        class="form-control form-control-custom @error('date') is-invalid @enderror" 
                        value="{{ old('date', $session->date->format('Y-m-d')) }}" required>
                    @error('date')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Active Toggle -->
                <div class="mb-5">
                    <label for="is_active" class="form-label-custom d-block">Session Status</label>
                    <select name="is_active" id="is_active" class="form-select form-control-custom" required>
                        <option value="1" {{ $session->is_active ? 'selected' : '' }}>Active (Students can join & take assessment)</option>
                        <option value="0" {{ !$session->is_active ? 'selected' : '' }}>Closed (Archived, no longer joinable)</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-3">
                    <button type="submit" class="btn-premium">
                        <i class="fa-solid fa-save me-2"></i> Update Session
                    </button>
                    <a href="{{ route('admin.sessions.index') }}" class="btn btn-glass-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
