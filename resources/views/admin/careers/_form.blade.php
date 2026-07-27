@php
    $isEdit = $career !== null;
    $repeaterFields = [
        'projects' => 'Portfolio Projects',
        'roadmap' => 'Learning Roadmap Phases',
        'strengths' => 'SWOT: Strengths',
        'weaknesses' => 'SWOT: Weaknesses',
        'opportunities' => 'SWOT: Opportunities',
        'threats' => 'SWOT: Threats',
    ];
    $swot = $isEdit ? ($career->swot ?? []) : [];
@endphp

@if(!$isEdit)
    <div class="mb-4">
        <label for="code" class="form-label-custom">Career Code (unique, e.g. AI, DevOps)</label>
        <input type="text" name="code" id="code" class="form-control form-control-custom @error('code') is-invalid @enderror" value="{{ old('code') }}" required>
        @error('code')
            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
        @enderror
    </div>
@endif

<div class="mb-4">
    <label for="name" class="form-label-custom">Career Name</label>
    <input type="text" name="name" id="name" class="form-control form-control-custom @error('name') is-invalid @enderror" value="{{ old('name', $career->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="description" class="form-label-custom">Description</label>
    <textarea name="description" id="description" rows="3" class="form-control form-control-custom @error('description') is-invalid @enderror" required>{{ old('description', $career->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
    @enderror
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <label for="salary_range" class="form-label-custom">Salary Range</label>
        <input type="text" name="salary_range" id="salary_range" class="form-control form-control-custom @error('salary_range') is-invalid @enderror" value="{{ old('salary_range', $career->salary_range ?? '') }}" placeholder="e.g. $90,000 - $150,000" required>
        @error('salary_range')
            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="demand_status" class="form-label-custom">Demand Status</label>
        <input type="text" name="demand_status" id="demand_status" class="form-control form-control-custom @error('demand_status') is-invalid @enderror" value="{{ old('demand_status', $career->demand_status ?? '') }}" placeholder="e.g. High, Very High" required>
        @error('demand_status')
            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-4">
    <label for="skills" class="form-label-custom">Skills (comma-separated)</label>
    <input type="text" name="skills" id="skills" class="form-control form-control-custom @error('skills') is-invalid @enderror" value="{{ old('skills', $isEdit ? implode(', ', $career->skills ?? []) : '') }}" required>
    @error('skills')
        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
    @enderror
</div>

<div class="mb-5">
    <label for="certifications" class="form-label-custom">Certifications (comma-separated)</label>
    <input type="text" name="certifications" id="certifications" class="form-control form-control-custom @error('certifications') is-invalid @enderror" value="{{ old('certifications', $isEdit ? implode(', ', $career->certifications ?? []) : '') }}" required>
    @error('certifications')
        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
    @enderror
</div>

<hr class="border-secondary my-5">

@foreach($repeaterFields as $field => $label)
    @php
        $items = old($field, $isEdit ? ($field === 'strengths' || $field === 'weaknesses' || $field === 'opportunities' || $field === 'threats'
            ? ($swot[$field] ?? [])
            : ($career->{$field} ?? [])) : []);
        if (empty($items)) {
            $items = ['', '', ''];
        }
    @endphp
    <div class="mb-4">
        <label class="form-label-custom d-block mb-2">{{ $label }}</label>
        <div class="repeater" data-field="{{ $field }}">
            @foreach($items as $item)
                <div class="input-group mb-2 repeater-row">
                    <input type="text" name="{{ $field }}[]" class="form-control form-control-custom" value="{{ $item }}">
                    <button type="button" class="btn btn-glass-secondary repeater-remove" title="Remove"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-glass-secondary btn-sm repeater-add" data-target="{{ $field }}">
            <i class="fa-solid fa-plus me-1"></i> Add line
        </button>
    </div>
@endforeach
