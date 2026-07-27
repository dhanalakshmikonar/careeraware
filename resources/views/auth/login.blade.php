@extends('layouts.app')

@section('title', 'Login - CareerAware')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-5">
        <div class="glass-card p-5">
            <div class="text-center mb-5">
                <i class="fa-solid fa-rocket fs-1 text-glow-cyan mb-3" style="color: var(--accent-secondary);"></i>
                <h2 class="fw-bold">Welcome Back</h2>
                <p class="text-muted">Sign in to continue to your career portal</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="form-label-custom">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text border-slate bg-slate text-muted" style="border: 1px solid var(--border-color); background-color: var(--bg-tertiary);">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" 
                            class="form-control form-control-custom @error('email') is-invalid @enderror" 
                            placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label for="password" class="form-label-custom">Password</label>
                    <div class="input-group">
                        <span class="input-group-text border-slate bg-slate text-muted" style="border: 1px solid var(--border-color); background-color: var(--bg-tertiary);">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" 
                            class="form-control form-control-custom" 
                            placeholder="Enter password" required autocomplete="current-password">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="mb-4 form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input bg-dark border-secondary">
                    <label class="form-check-label text-muted small" for="remember">Remember me on this device</label>
                </div>

                <!-- Login Button -->
                <div class="d-grid mb-4">
                    <button type="submit" class="btn-premium py-3">
                        <i class="fa-solid fa-right-to-bracket me-2"></i> Log In
                    </button>
                </div>

                <!-- Registration Link -->
                <div class="text-center">
                    <span class="text-muted small">New to CareerAware?</span>
                    <a href="{{ route('register') }}" class="text-glow-cyan ms-1 text-decoration-none small" style="color: var(--accent-secondary); font-weight: 500;">
                        Create Student Account
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
