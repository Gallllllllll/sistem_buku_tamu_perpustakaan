<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            display: flex;
            width: 900px;
            height: 550px;
            background-color: #ffffff; 
            border-radius: 15px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.25);
        }

        .login-left {
            background: linear-gradient(135deg, #764ba2 80%);
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 20px;
        }

        .login-left img {
            width: 90%;
            max-width: 300px;
        }

        .login-left .logo {
            width: 100px;
            margin-bottom: 10px;
        }

        .login-right {
            flex: 1.2;
            padding: 50px 60px;
        }

        h2 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 40px;
            margin-top: 20px;
            color: #444;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 10px;
            width: 100%;
            margin-top: 15px;
            font-size: 1.1rem;
            border: none;
        }

        .btn-login:hover {
            opacity: 0.85;
        }

        .btn-back {
            display: block;
            width: 150px;
            margin: 40px auto 0;
            border-radius: 10px;
            padding: 8px 25px;
            color: #764ba2;
            border: 1px solid #764ba2;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-back:hover {
            background-color: #764ba2;
            color: white;
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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <img src="{{ asset('images/librain-logo.png') }}" class="logo" alt="LIBRAIN Logo">
            <img src="{{ asset('images/login-illustration.png') }}" alt="Welcome Image">
        </div>

        <div class="login-right">
            <h2>Log In Administrator</h2>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
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

                <button type="submit" class="btn btn-login">Login</button>
            </form>

            <a href="{{ url()->previous() }}" class="btn-back">⬅️ Kembali</a>
        </div>
    </div>
</body>
</html>