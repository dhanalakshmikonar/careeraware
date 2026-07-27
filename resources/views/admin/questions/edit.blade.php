@extends('layouts.app')

@section('title', 'Edit Question - CareerAware')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="mb-4">
            <a href="{{ route('admin.questions.index') }}" class="text-decoration-none text-muted">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to list
            </a>
        </div>

        <div class="glass-card p-5">
            <h2 class="fw-bold mb-4 text-glow-cyan" style="color: var(--accent-secondary);">Edit Question</h2>
            <p class="text-muted mb-5">Modify the scenario text, category, options, or weight scoring profiles.</p>

            <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Question Text -->
                <div class="mb-4">
                    <label for="question_text" class="form-label-custom">Scenario Text</label>
                    <textarea name="question_text" id="question_text" rows="3" 
                        class="form-control form-control-custom @error('question_text') is-invalid @enderror" 
                        required>{{ old('question_text', $question->question_text) }}</textarea>
                    @error('question_text')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-5">
                    <label for="category" class="form-label-custom">Question Category</label>
                    <select name="category" id="category" class="form-select form-control-custom @error('category') is-invalid @enderror" required>
                        <option value="" disabled>Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $question->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="border-secondary my-5">

                <!-- 4 Options -->
                <h4 class="fw-bold text-white mb-4">Question Options & Career Weights</h4>

                @foreach($question->options as $index => $option)
                    @php
                        $letter = chr(65 + $index); // A, B, C, D
                    @endphp
                    <div class="p-4 bg-dark rounded-4 mb-4 border border-secondary">
                        <h5 class="fw-bold text-glow-violet mb-3" style="color: var(--accent-primary);">Option {{ $letter }}</h5>
                        
                        <!-- Hidden ID Field -->
                        <input type="hidden" name="options[{{ $index }}][id]" value="{{ $option->id }}">

                        <!-- Option Text -->
                        <div class="mb-4">
                            <label class="form-label-custom">Option Text</label>
                            <input type="text" name="options[{{ $index }}][text]" 
                                class="form-control form-control-custom" 
                                value="{{ old("options.{$index}.text", $option->option_text) }}" required>
                        </div>

                        <!-- Weights Grid -->
                        <div>
                            <label class="form-label-custom d-block mb-3">Career Weights Mapping (Enter values from 1 to 5, leave blank/0 for none)</label>
                            <div class="row g-3">
                                @foreach($careers as $career)
                                    @php
                                        // Retrieve pre-existing weight
                                        $weight = $option->career_weights[$career->code] ?? 0;
                                    @endphp
                                    <div class="col-md-2.4 col-sm-4 col-6">
                                        <div class="p-2 rounded bg-secondary border border-secondary-subtle">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="small text-white fw-semibold">{{ $career->code }}</span>
                                                <input type="number" name="options[{{ $index }}][weights][{{ $career->code }}]" 
                                                    class="form-control form-control-custom py-1 px-2 border-0 text-center" 
                                                    style="width: 45px; background: rgba(0,0,0,0.2) !important;" 
                                                    min="0" max="5" value="{{ $weight }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Submit Buttons -->
                <div class="d-flex gap-3 mt-5">
                    <button type="submit" class="btn-premium">
                        <i class="fa-solid fa-save me-2"></i> Update Question
                    </button>
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-glass-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Custom grid column width for career weights */
@media (min-width: 576px) {
    .col-md-2\.4 {
        flex: 0 0 20%;
        max-width: 20%;
    }
}
</style>
@endsection
