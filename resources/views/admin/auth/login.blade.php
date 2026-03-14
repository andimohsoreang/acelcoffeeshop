<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            color: #1a1a2e;
            padding: 1.5rem;
            -webkit-font-smoothing: antialiased;
        }

        .login-wrapper {
            width: 100%;
            max-width: 380px;
        }

        /* ── Branding ── */
        .brand {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: linear-gradient(135deg, #3ecf8e 0%, #24b47e 100%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 8px 24px rgba(62, 207, 142, 0.25);
            margin-bottom: 1.25rem;
        }

        .brand h1 {
            font-size: 1.375rem;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: #111827;
        }

        .brand p {
            font-size: 0.875rem;
            color: #9ca3af;
            margin-top: 0.25rem;
        }

        /* ── Alert ── */
        .alert-error {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            font-size: 0.8125rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .alert-error svg {
            flex-shrink: 0;
            width: 18px;
            height: 18px;
        }

        /* ── Form ── */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 0.6875rem 0.875rem;
            font-size: 0.875rem;
            font-family: inherit;
            color: #111827;
            background: #ffffff;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input:focus {
            border-color: #3ecf8e;
            box-shadow: 0 0 0 3px rgba(62, 207, 142, 0.12);
        }

        .form-group input::placeholder {
            color: #c9cdd4;
        }

        .form-error {
            font-size: 0.75rem;
            color: #ef4444;
            margin-top: 0.375rem;
        }

        /* ── Remember ── */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1.5px solid #d1d5db;
            accent-color: #3ecf8e;
            cursor: pointer;
        }

        .remember-row label {
            font-size: 0.8125rem;
            color: #6b7280;
            cursor: pointer;
        }

        /* ── Button ── */
        .btn-login {
            width: 100%;
            padding: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: inherit;
            color: #fff;
            background: linear-gradient(135deg, #3ecf8e 0%, #24b47e 100%);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
            box-shadow: 0 4px 14px rgba(62, 207, 142, 0.3);
        }

        .btn-login:hover {
            opacity: 0.92;
            box-shadow: 0 6px 20px rgba(62, 207, 142, 0.35);
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        /* ── Back link ── */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 2rem;
            font-size: 0.8125rem;
            color: #9ca3af;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #6b7280;
        }

        /* ── Divider line ── */
        .divider {
            width: 100%;
            height: 1px;
            background: #f3f4f6;
            margin: 1.5rem 0;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">

        {{-- Branding --}}
        <div class="brand">
            <div class="brand-icon">☕</div>
            <h1>{{ \App\Models\Setting::get('shop_name', 'Coffee Shop') }}</h1>
            <p>Admin Panel</p>
        </div>

        {{-- Error --}}
        @if(session('error'))
        <div class="alert-error">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="nama@email.com">
                @error('email')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan password">
                @error('password')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <a href="{{ route('home') }}" class="back-link">← Kembali ke toko</a>

    </div>
</body>

</html>