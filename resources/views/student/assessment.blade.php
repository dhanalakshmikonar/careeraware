@extends('layouts.app')

@section('title', 'Take Assessment - CareerAware')

@section('content')
<div class="row mb-5">
    <div class="col">
        <h1 class="fw-bold text-glow-cyan">Career Assessment</h1>
        <p class="text-muted">Session: <span class="text-white fw-semibold">{{ $session->title }}</span> &mdash; Answer every scenario honestly to get the most accurate recommendations.</p>
    </div>
</div>

<div class="glass-card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <span class="text-muted small">Progress</span>
        <span class="text-white small" id="progressLabel">{{ count($savedAnswers) }} / {{ $questions->count() }} answered</span>
    </div>
    <div class="progress bg-dark" style="height: 8px;">
        <div class="progress-bar" id="progressBar" role="progressbar"
            style="width: {{ $questions->count() > 0 ? (count($savedAnswers) / $questions->count()) * 100 : 0 }}%; background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));"></div>
    </div>
</div>

<form id="assessmentForm" action="{{ route('student.assessment.complete') }}" method="POST">
    @csrf

    @foreach($questions as $index => $question)
        <div class="glass-card p-4 mb-4">
            <span class="badge-premium mb-3">{{ $question->category }}</span>
            <h5 class="fw-bold text-white mb-4">{{ $index + 1 }}. {{ $question->question_text }}</h5>

            <div class="d-flex flex-column gap-2">
                @foreach($question->options as $option)
                    <label class="p-3 bg-dark rounded border border-secondary d-flex align-items-center gap-3 answer-option" style="cursor: pointer;">
                        <input type="radio"
                            name="question_{{ $question->id }}"
                            value="{{ $option->id }}"
                            class="form-check-input answer-input"
                            data-question-id="{{ $question->id }}"
                            data-option-id="{{ $option->id }}"
                            {{ ($savedAnswers[$question->id] ?? null) == $option->id ? 'checked' : '' }}>
                        <span class="text-muted">{{ $option->option_text }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="text-center mt-5 mb-5">
        <button type="submit" id="submitBtn" class="btn-premium px-5 py-3">
            <i class="fa-solid fa-flag-checkered me-2"></i> Submit Assessment
        </button>
        <p class="text-muted small mt-3">Answers are saved automatically as you select them.</p>
    </div>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const totalQuestions = {{ $questions->count() }};
    let answeredCount = {{ count($savedAnswers) }};
    const progressBar = document.getElementById('progressBar');
    const progressLabel = document.getElementById('progressLabel');
    const answeredQuestions = new Set({!! json_encode(array_keys($savedAnswers->toArray())) !!});

    function updateProgress() {
        answeredCount = answeredQuestions.size;
        const pct = totalQuestions > 0 ? (answeredCount / totalQuestions) * 100 : 0;
        progressBar.style.width = pct + '%';
        progressLabel.textContent = answeredCount + ' / ' + totalQuestions + ' answered';
    }

    document.querySelectorAll('.answer-input').forEach(function (input) {
        input.addEventListener('change', function () {
            const questionId = input.getAttribute('data-question-id');
            const optionId = input.getAttribute('data-option-id');

            fetch("{{ route('student.assessment.save') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    question_id: questionId,
                    question_option_id: optionId
                })
            }).then(function () {
                answeredQuestions.add(String(questionId));
                updateProgress();
            });
        });
    });

    document.getElementById('assessmentForm').addEventListener('submit', function (e) {
        if (answeredQuestions.size < totalQuestions) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Almost done!',
                text: 'Please answer all questions before submitting.',
                background: '#131a26',
                color: '#f8fafc',
                confirmButtonColor: '#8b5cf6'
            });
        }
    });
});
</script>
@endsection
