<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>

    <!-- Font Tema Global -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Instrument Sans', sans-serif !important;
        }

        .login-container {
            display: flex;
            width: 900px;
            height: 550px;
            background-color: #ffffff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.22);
            overflow: hidden;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #5a3d9e 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
            color: white;
        }

        .login-left .logo {
            width: 95px;
            margin-bottom: 15px;
        }

        .login-left img {
            width: 95%;
            max-width: 320px;
        }

        .login-right {
            flex: 1.2;
            padding: 50px 60px;
        }

        h2 {
            text-align: center;
            font-weight: 700;
            font-size: 26px;
            margin-bottom: 35px;
            color: #444;
        }

        .form-label {
            font-weight: 600;
            color: #555;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
            font-size: 15px;
            border: 1px solid #ccc;
            transition: 0.2s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 6px rgba(102, 126, 234, 0.4);
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 14px;
            padding: 12px;
            width: 100%;
            font-size: 17px;
            font-weight: 600;
            border: none;
            margin-top: 15px;
            transition: 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            opacity: 0.92;
        }

        .btn-back {
            display: block;
            width: 160px;
            margin: 35px auto 0;
            border-radius: 10px;
            padding: 9px 25px;
            color: #764ba2;
            border: 1px solid #764ba2;
            text-decoration: none;
            text-align: center;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-back:hover {
            background-color: #764ba2;
            color: white;
        }

        /* Alert Custom */
        .alert-custom {
            background: #ffe8e8;
            border-left: 5px solid #ff4d4d;
            padding: 12px 16px;
            border-radius: 12px;
            color: #b10000;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            animation: fadeIn 0.3s ease;
        }

        .alert-custom i {
            font-size: 18px;
        }


        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 95%;
                height: auto;
            }
            .login-left {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        
        <div class="login-left">
            <img src="{{ asset('images/librain-logo.png') }}" class="logo" alt="LIBRAIN Logo">
            <img src="{{ asset('images/login-illustration.png') }}" alt="Illustration">
        </div>

        <div class="login-right">
            <h2>Login Administrator</h2>

            @if(session('error'))
                <div class="alert-custom">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.admin') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>

            <a href="{{ route('tamus.create') }}" class="btn-back">⬅ Kembali</a>
        </div>

    </div>

</body>
</html>
