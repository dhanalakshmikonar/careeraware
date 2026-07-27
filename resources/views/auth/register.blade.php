@extends('layouts.app')

@section('title', 'Register - CareerAware')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-6">
        <div class="glass-card p-5">
            <div class="text-center mb-5">
                <i class="fa-solid fa-user-plus fs-1 text-glow-violet mb-3" style="color: var(--accent-primary);"></i>
                <h2 class="fw-bold">Student Registration</h2>
                <p class="text-muted">Create an account to discover your perfect career path</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Name Input -->
                <div class="mb-4">
                    <label for="name" class="form-label-custom">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text border-slate bg-slate text-muted" style="border: 1px solid var(--border-color); background-color: var(--bg-tertiary);">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="name" id="name" 
                            class="form-control form-control-custom @error('name') is-invalid @enderror" 
                            placeholder="John Doe" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                    @error('name')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Department Dropdown -->
                <div class="mb-4">
                    <label for="department" class="form-label-custom">Department / Stream</label>
                    <div class="input-group">
                        <span class="input-group-text border-slate bg-slate text-muted" style="border: 1px solid var(--border-color); background-color: var(--bg-tertiary);">
                            <i class="fa-solid fa-building-user"></i>
                        </span>
                        <select name="department" id="department" 
                            class="form-select form-control-custom @error('department') is-invalid @enderror" required>
                            <option value="" disabled selected>Select your department</option>
                            <option value="Science & Tech" {{ old('department') == 'Science & Tech' ? 'selected' : '' }}>Science & Tech</option>
                            <option value="Engineering" {{ old('department') == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                            <option value="Business & Finance" {{ old('department') == 'Business & Finance' ? 'selected' : '' }}>Business & Finance</option>
                            <option value="Arts & Design" {{ old('department') == 'Arts & Design' ? 'selected' : '' }}>Arts & Design</option>
                            <option value="Social Sciences" {{ old('department') == 'Social Sciences' ? 'selected' : '' }}>Social Sciences</option>
                            <option value="Other" {{ old('department') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    @error('department')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="form-label-custom">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text border-slate bg-slate text-muted" style="border: 1px solid var(--border-color); background-color: var(--bg-tertiary);">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" 
                            class="form-control form-control-custom @error('email') is-invalid @enderror" 
                            placeholder="john@example.com" value="{{ old('email') }}" required autocomplete="email">
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="form-label-custom">Password (Min 6 characters)</label>
                    <div class="input-group">
                        <span class="input-group-text border-slate bg-slate text-muted" style="border: 1px solid var(--border-color); background-color: var(--bg-tertiary);">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" 
                            class="form-control form-control-custom @error('password') is-invalid @enderror" 
                            placeholder="Create password" required autocomplete="new-password">
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-5">
                    <label for="password_confirmation" class="form-label-custom">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text border-slate bg-slate text-muted" style="border: 1px solid var(--border-color); background-color: var(--bg-tertiary);">
                            <i class="fa-solid fa-circle-check"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                            class="form-control form-control-custom" 
                            placeholder="Repeat password" required autocomplete="new-password">
                    </div>
                </div>

                <!-- Register Button -->
                <div class="d-grid mb-4">
                    <button type="submit" class="btn-premium py-3">
                        <i class="fa-solid fa-user-plus me-2"></i> Register & Start
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <span class="text-muted small">Already have an account?</span>
                    <a href="{{ route('login') }}" class="text-glow-violet ms-1 text-decoration-none small" style="color: var(--accent-primary); font-weight: 500;">
                        Log In
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
