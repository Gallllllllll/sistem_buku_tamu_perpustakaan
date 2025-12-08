<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #6a5acd, #7b8dec);
            font-family: 'Poppins', sans-serif;
        }

        .card-login {
            width: 400px;
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.5s ease;
        }

        h2 {
            text-align: center;
            font-weight: 600;
            font-size: 1.6rem;
            margin-bottom: 25px;
            color: #5a4cd6;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px;
        }

        .btn-login {
            background: linear-gradient(90deg, #6a5acd, #7a67ea);
            color: white;
            border-radius: 12px;
            padding: 12px;
            width: 100%;
            font-size: 1rem;
            border: none;
            margin-top: 10px;
            transition: 0.2s;
        }

        .btn-login:hover {
            background: linear-gradient(90deg, #5543d8, #5d4edb);
        }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #6a5acd;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-back:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <div class="card-login">
        <h2>Log In Member</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('loginuser') }}">
            @csrf

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <a href="{{ url()->previous() }}" class="btn-back">← Kembali</a>
    </div>

</body>
</html>
