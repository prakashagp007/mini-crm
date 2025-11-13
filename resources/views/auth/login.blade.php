@extends('layouts.app')

@section('content')
    <style>
        .login-card {
            background: #fff;
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            padding: 40px 30px;
            width: 100%;
            max-width: 420px;
            margin: 70px auto;
            transition: all 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.2);
        }

        .login-card h3 {
            font-weight: 700;
            color: #7b4397;
            text-align: center;
            margin-bottom: 25px;
            font-family: merienda;

        }

        label {
            font-family: Emblema;
            color: grey;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
        }

        .btn-login {
            width: 100%;
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
            background: linear-gradient(135deg, #7b4397, #dc2430);
            border: none;
            color: #fff;
            transition: 0.3s;
            font-family: Keania;
        }

        .btn-login:hover {
            background: linear-gradient(90deg, #2563eb, #7e22ce);
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 30px 20px;
            }
        }
    </style>

    <div class="container">
        <div class="login-card">
            <h3>🔐 Login to Your Account</h3>
            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">Login</button>

                {{-- <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}" class="text-decoration-none small text-muted">
                        Forgot your password?
                    </a>
                </div> --}}
            </form>
        </div>
    </div>
@endsection
