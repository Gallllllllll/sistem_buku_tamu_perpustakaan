<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <title>Register Member</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-box {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            padding: 32px;
            border-radius: 18px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.18);
            animation: fadeIn 0.45s ease;
            border-top: 4px solid #667eea;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(10px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 22px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            color: transparent;
        }

        .input-group-custom {
            margin-bottom: 16px;
        }

        .input-group-custom input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #d4d4d2;
            background: #fafafa;
            font-size: 15px;
            transition: 0.2s;
            font-family: inherit;
        }

        .input-group-custom input:focus {
            border-color: #667eea;
            background: #ffffff;
            outline: none;
            box-shadow: 0 0 6px rgba(102, 126, 234, 0.35);
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            font-weight: 700;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            cursor: pointer;
            transition: 0.25s;
            margin-top: 8px;
        }

        .btn-submit:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .error-box {
            background: #ffe9e9;
            border-left: 4px solid #ff5a5a;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            color: #b63131;
            font-size: 14px;
            animation: fadeIn 0.3s ease;
        }
    </style>
</head>

<body>

    <div class="register-box">

        <div class="title">Buat Akun Member</div>

        @if ($errors->any())
            <div class="error-box">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <div class="input-group-custom">
                <input type="text" name="name" placeholder="Nama Lengkap" required>
            </div>

            <div class="input-group-custom">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-group-custom">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="input-group-custom">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
            </div>

            <button type="submit" class="btn-submit">Daftar</button>

        </form>

    </div>

</body>
</html>
