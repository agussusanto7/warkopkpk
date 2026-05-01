<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Warkop KPK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .login-page{min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--bg-dark);padding:20px}
        .login-card{width:100%;max-width:420px;padding:48px;background:var(--bg-card);border:1px solid rgba(200,149,108,.1);border-radius:var(--radius-lg)}
        .login-logo{text-align:center;margin-bottom:32px}
        .login-logo .logo-icon{font-size:3rem;display:block;margin-bottom:8px}
        .login-logo h1{font-family:var(--font-heading);font-size:1.8rem;color:var(--cream)}
        .login-logo p{color:var(--text-secondary);font-size:.85rem;margin-top:4px}
        .login-card .form-group{margin-bottom:20px}
        .login-card .btn{margin-top:8px}
        .login-error{padding:12px 16px;background:rgba(231,76,60,.1);border:1px solid rgba(231,76,60,.3);border-radius:8px;color:#e74c3c;font-size:.85rem;margin-bottom:16px}
        .login-footer{text-align:center;margin-top:24px}
        .login-footer a{color:var(--gold);font-size:.85rem}
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-card">
            <div class="login-logo">
                <span class="logo-icon">☕</span>
                <h1>Warkop KPK</h1>
                <p>Admin Panel Login</p>
            </div>

            @if($errors->any())
            <div class="login-error">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@warkopkpk.com">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Masukkan password">
                </div>
                <div class="form-group" style="display:flex;align-items:center;gap:8px">
                    <input type="checkbox" id="remember" name="remember" style="width:auto">
                    <label for="remember" style="margin:0;font-size:.85rem;color:var(--text-secondary)">Ingat saya</label>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Masuk</button>
            </form>

            <div class="login-footer">
                <a href="{{ route('home') }}">← Kembali ke Website</a>
            </div>
        </div>
    </div>
</body>
</html>
