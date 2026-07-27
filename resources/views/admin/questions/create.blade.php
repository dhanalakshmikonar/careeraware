@extends('layouts.app')

@section('title', 'Add Question - CareerAware')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="mb-4">
            <a href="{{ route('admin.questions.index') }}" class="text-decoration-none text-muted">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to list
            </a>
        </div>

        <div class="glass-card p-5">
            <h2 class="fw-bold mb-4 text-glow-cyan" style="color: var(--accent-secondary);">Add Assessment Question</h2>
            <p class="text-muted mb-5">Define a scenario-driven prompt and exactly four options. Allocate weights (1-5) to indicate which careers are favored by each selection.</p>

            <form action="{{ route('admin.questions.store') }}" method="POST">
                @csrf

                <!-- Question Text -->
                <div class="mb-4">
                    <label for="question_text" class="form-label-custom">Scenario Scenario Text</label>
                    <textarea name="question_text" id="question_text" rows="3" 
                        class="form-control form-control-custom @error('question_text') is-invalid @enderror" 
                        placeholder="e.g., You encounter an unexplained spike in network traffic..." required>{{ old('question_text') }}</textarea>
                    @error('question_text')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-5">
                    <label for="category" class="form-label-custom">Question Category</label>
                    <select name="category" id="category" class="form-select form-control-custom @error('category') is-invalid @enderror" required>
                        <option value="" disabled selected>Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="border-secondary my-5">

                <!-- 4 Options -->
                <h4 class="fw-bold text-white mb-4">Question Options & Career Weights</h4>

                @for($i = 0; $i < 4; $i++)
                    @php
                        $letter = chr(65 + $i); // A, B, C, D
                    @endphp
                    <div class="p-4 bg-dark rounded-4 mb-4 border border-secondary">
                        <h5 class="fw-bold text-glow-violet mb-3" style="color: var(--accent-primary);">Option {{ $letter }}</h5>
                        
                        <!-- Option Text -->
                        <div class="mb-4">
                            <label class="form-label-custom">Option Text</label>
                            <input type="text" name="options[{{ $i }}][text]" 
                                class="form-control form-control-custom" 
                                placeholder="Describe the choice..." required>
                        </div>

                        <!-- Weights Grid -->
                        <div>
                            <label class="form-label-custom d-block mb-3">Career Weights Mapping (Enter values from 1 to 5, leave blank/0 for none)</label>
                            <div class="row g-3">
                                @foreach($careers as $career)
                                    <div class="col-md-2.4 col-sm-4 col-6">
                                        <div class="p-2 rounded bg-secondary border border-secondary-subtle">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="small text-white fw-semibold">{{ $career->code }}</span>
                                                <input type="number" name="options[{{ $i }}][weights][{{ $career->code }}]" 
                                                    class="form-control form-control-custom py-1 px-2 border-0 text-center" 
                                                    style="width: 45px; background: rgba(0,0,0,0.2) !important;" 
                                                    min="0" max="5" value="0">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endfor

                <!-- Submit Buttons -->
                <div class="d-flex gap-3 mt-5">
                    <button type="submit" class="btn-premium">
                        <i class="fa-solid fa-save me-2"></i> Save Question
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
