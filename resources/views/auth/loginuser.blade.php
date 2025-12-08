<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Member - Buku Tamu Digital</title>

    <!-- Font Tema -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* ========== CARD LOGIN ========== */
        .card-login {
            width: 380px;
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 26px rgba(0,0,0,0.18);
            animation: fadeIn 0.45s ease;
            border-top: 4px solid #667eea;
        }

        .title {
            text-align: center;
            font-weight: 700;
            font-size: 20px;
            color: #667eea;
            margin-bottom: 25px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #d4d4d2;
            background: #fafafa;
            font-size: 14px;
            font-family: inherit;
            transition: border 0.2s ease;
        }

        .form-input:focus {
            border-color: #667eea;
            outline: none;
        }

        /* BUTTON LOGIN */
        .btn-login {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity .25s ease;
        }

        .btn-login:hover {
            opacity: 0.85;
        }

        /* BACK LINK */
        .btn-back {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #667eea;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
        }

        .btn-back:hover {
            text-decoration: underline;
        }

        /* ALERT BOX */
        .alert {
            padding: 12px;
            font-size: 14px;
            border-radius: 8px;
            margin-bottom: 18px;
            animation: fade 0.3s ease;
        }

        .alert-danger {
            background: #ffe9e9;
            border-left: 4px solid #ff5a5a;
            color: #b83131;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <div class="card-login">
        <h2 class="title">Login Member</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('loginuser') }}">
            @csrf

            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" required autofocus>

            <label class="form-label" style="margin-top: 12px;">Password</label>
            <input type="password" name="password" class="form-input" required>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <a href="{{ url()->previous() }}" class="btn-back">← Kembali</a>
    </div>

</body>
</html>
