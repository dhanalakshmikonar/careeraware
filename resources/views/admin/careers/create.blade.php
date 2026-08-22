@extends('layouts.app')

@section('title', 'Add Career Path - WatyAssessment')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="mb-4">
            <a href="{{ route('admin.careers.index') }}" class="text-decoration-none text-muted">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to list
            </a>
        </div>

        <div class="glass-card p-5">
            <h2 class="fw-bold mb-4 text-glow-cyan" style="color: var(--accent-secondary);">Add Career Path</h2>

            <form action="{{ route('admin.careers.store') }}" method="POST" id="careerForm">
                @csrf
                @include('admin.careers._form', ['career' => null])
                <div class="d-flex gap-3 mt-5">
                    <button type="submit" class="btn-premium"><i class="fa-solid fa-save me-2"></i> Save Career Path</button>
                    <a href="{{ route('admin.careers.index') }}" class="btn btn-glass-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/career-form-repeater.js') }}"></script>
@endsection
