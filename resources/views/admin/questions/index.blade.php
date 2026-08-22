@extends('layouts.app')

@section('title', 'Manage Questions - WatyAssessment')

@section('content')
<div class="row mb-5 align-items-center">
    <div class="col-md-8">
        <h1 class="fw-bold text-glow-cyan">Psychology-Based Questions</h1>
        <p class="text-muted">Manage scenario-driven questions, option texts, and career mapping weights.</p>
    </div>
    <div class="col-md-4 text-md-end">
        <a href="{{ route('admin.questions.create') }}" class="btn btn-premium">
            <i class="fa-solid fa-plus me-2"></i> Add New Question
        </a>
    </div>
</div>

<div class="glass-card p-4">
    @if($questions->isEmpty())
        <div class="text-center py-5">
            <i class="fa-solid fa-clipboard-question fs-1 text-muted mb-3"></i>
            <h4 class="fw-bold text-muted">No Questions Found</h4>
            <p class="text-muted mb-4">Seeding might have been skipped. Add a new question to start.</p>
            <a href="{{ route('admin.questions.create') }}" class="btn btn-premium btn-sm">Add Question</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th style="width: 45%;">Scenario / Question Text</th>
                        <th style="width: 20%;">Category</th>
                        <th style="width: 15%;">Options Count</th>
                        <th class="text-center" style="width: 20%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <td>
                                <div class="text-white fw-semibold text-wrap" style="max-width: 500px;">
                                    {{ $question->question_text }}
                                </div>
                            </td>
                            <td>
                                <span class="badge-premium">{{ $question->category }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary px-3 py-1.5 rounded-pill">
                                    {{ $question->options->count() }} Options
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group gap-2">
                                    <a href="{{ route('admin.questions.edit', $question->id) }}" class="btn btn-premium-cyan btn-sm py-1 px-3">
                                        <i class="fa-solid fa-edit me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this question and all its options?');">
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
            {{ $questions->links() }}
        </div>
    @endif
</div>
@endsection
