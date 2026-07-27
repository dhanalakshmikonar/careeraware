<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Career Awareness & Recommendation System')</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --bg-primary: #0b0f19;
            --bg-secondary: #131a26;
            --bg-tertiary: #1b2436;
            --accent-primary: #8b5cf6; /* Violet */
            --accent-secondary: #06b6d4; /* Cyan */
            --accent-success: #10b981; /* Emerald */
            --accent-warning: #f59e0b; /* Amber */
            --accent-danger: #ef4444; /* Rose */
            --text-main: #f8fafc;
            --text-muted: #f3f5f8;
            --border-color: #334155;
            --glass-bg: rgba(19, 26, 38, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
            --font-sans: 'Outfit', 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        .text-muted {
            color: #ffffff !important;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-main);
            font-family: var(--font-sans);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            
        }

        .glass-card:hover {
            border-color: rgba(139, 92, 246, 0.3);
            box-shadow: 0 12px 40px 0 rgba(139, 92, 246, 0.15);
            transform: translateY(-2px);
        }

        /* Premium Buttons */
        .btn-premium {
            background: linear-gradient(135deg, var(--accent-primary) 0%, #6d28d9 100%);
            border: none;
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
            transition: all 0.2s ease;
        }

        .btn-premium:hover, .btn-premium:focus {
            background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.5);
            transform: translateY(-1px);
        }

        .btn-premium-cyan {
            background: linear-gradient(135deg, var(--accent-secondary) 0%, #0891b2 100%);
            border: none;
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);
            transition: all 0.2s ease;
        }

        .btn-premium-cyan:hover, .btn-premium-cyan:focus {
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(6, 182, 212, 0.5);
            transform: translateY(-1px);
        }

        .btn-glass-secondary {
    background: #3b82f6;
    border: 1px solid #3b82f6;
    color: #1e1e3b;
    padding: 10px 24px;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn-glass-secondary:hover {
    background: #2563eb;
    color: white;
    border-color: #2563eb;
}

        /* Glowing text & badges */
        .text-glow-violet {
            text-shadow: 0 0 10px rgba(139, 92, 246, 0.5);
        }
        .text-glow-cyan {
            text-shadow: 0 0 10px rgba(6, 182, 212, 0.5);
        }

        .badge-premium {
            background: rgba(139, 92, 246, 0.15);
            border: 1px solid rgba(139, 92, 246, 0.3);
            color: #c084fc;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 30px;
        }

        .badge-premium-cyan {
            background: rgba(6, 182, 212, 0.15);
            border: 1px solid rgba(6, 182, 212, 0.3);
            color: #22d3ee;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 30px;
        }

        /* Navigation Bar */
        .navbar-custom {
            background-color: rgba(11, 15, 25, 0.85);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            padding: 15px 0;
        }

        .navbar-custom .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: white;
            letter-spacing: -0.5px;
        }

        .navbar-custom .nav-link {
            color: var(--text-muted);
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .navbar-custom .nav-link:hover, 
        .navbar-custom .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
        }

        /* Forms styling */
        .form-control-custom {
            background-color: var(--bg-tertiary) !important;
            border: 1px solid var(--border-color) !important;
            color: white !important;
            border-radius: 8px !important;
            padding: 12px 16px !important;
            transition: all 0.2s ease !important;
        }

        .form-control-custom:focus {
            border-color: var(--accent-primary) !important;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.25) !important;
            outline: none !important;
        }

        .form-label-custom {
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        /* Table styling */
        .table-custom {
            color: var(--text-main) !important;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table-custom tr {
            background-color: var(--bg-secondary);
            border-radius: 8px;
        }

        .table-custom th {
    background-color: var(--bg-secondary);
    color: #ffffff;
    font-weight: 500;
    border-bottom: none;
    padding: 16px;
}

        .table-custom td {
            background-color: var(--bg-secondary);
    color: #ffffff;
            padding: 16px;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .table-custom td:first-child {
            border-left: 1px solid var(--border-color);
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .table-custom td:last-child {
            border-right: 1px solid var(--border-color);
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--border-color);
            padding: 24px 0;
            background-color: var(--bg-secondary);
            margin-top: auto;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-primary);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Navigation Header -->
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <i class="fa-solid fa-graduation-cap me-2 text-glow-cyan" style="color: var(--accent-secondary);"></i>
                <span>Career<span style="color: var(--accent-primary);">Aware</span></span>
            </a>
            
            <button class="navbar-expand-lg navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="fa-solid fa-chart-line me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.sessions.*') ? 'active' : '' }}" href="{{ route('admin.sessions.index') }}">
                                    <i class="fa-solid fa-calendar-days me-1"></i> Sessions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.students') || Route::is('admin.students.results') ? 'active' : '' }}" href="{{ route('admin.students') }}">
                                    <i class="fa-solid fa-users-line me-1"></i> Students
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.questions.*') ? 'active' : '' }}" href="{{ route('admin.questions.index') }}">
                                    <i class="fa-solid fa-clipboard-question me-1"></i> Questions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('admin.careers.*') ? 'active' : '' }}" href="{{ route('admin.careers.index') }}">
                                    <i class="fa-solid fa-briefcase me-1"></i> Career Paths
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
                                    <i class="fa-solid fa-house me-1"></i> Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('student.session.join') ? 'active' : '' }}" href="{{ route('student.session.join') }}">
                                    <i class="fa-solid fa-right-to-bracket me-1"></i> Join Session
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('student.assessment') ? 'active' : '' }}" href="{{ route('student.assessment') }}">
                                    <i class="fa-solid fa-star me-1"></i> Take Assessment
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('student.results') ? 'active' : '' }}" href="{{ route('student.results') }}">
                                    <i class="fa-solid fa-file-invoice me-1"></i> My Report
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
                
                <div class="d-flex align-items-center">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-link text-decoration-none text-white dropdown-toggle d-flex align-items-center" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user-astronaut me-2 fs-5" style="color: var(--accent-secondary);"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <span class="ms-2 badge {{ Auth::user()->role === 'admin' ? 'bg-danger' : 'bg-primary' }} text-capitalize">{{ Auth::user()->role }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark border-secondary bg-secondary" aria-labelledby="userMenuButton">
                                @if(Auth::user()->role === 'student')
                                    <li class="px-3 py-2 border-bottom border-secondary text-muted small">
                                        Dept: {{ Auth::user()->department }}
                                    </li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-link text-white text-decoration-none me-3">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-premium">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="container py-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-1">&copy; {{ date('Y') }} CareerAware. All rights reserved.</p>
            <p class="mb-0 small">Powered by Waty AI Technologies.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS (Includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Session Notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    background: '#131a26',
                    color: '#f8fafc',
                    confirmButtonColor: '#8b5cf6',
                    timer: 3000
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    background: '#131a26',
                    color: '#f8fafc',
                    confirmButtonColor: '#ef4444',
                    timer: 4000
                });
            @endif
        });
    </script>
    @yield('scripts')
</body>
</html>
