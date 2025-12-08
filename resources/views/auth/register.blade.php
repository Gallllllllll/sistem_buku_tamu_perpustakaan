<!-- Font Tema -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Instrument Sans', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        padding: 20px;
    }

    .register-box {
        width: 100%;
        max-width: 420px;
        background: white;
        padding: 28px;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }

    .title {
        font-weight: 700;
        font-size: 24px;
        text-align: center;
        margin-bottom: 25px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        color: transparent;
    }

    .input-group-custom {
        margin-bottom: 16px;
    }

    .input-group-custom input {
        width: 100%;
        padding: 13px 16px;
        border: 1px solid #ccc;
        border-radius: 12px;
        font-size: 15px;
        transition: 0.2s;
    }

    .input-group-custom input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 6px rgba(102, 126, 234, 0.4);
    }

    .btn-submit {
        width: 100%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 13px;
        font-size: 17px;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.2s;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        opacity: 0.95;
    }

    .error-box {
        background: #ffe5e5;
        border-left: 4px solid #ff4d4d;
        padding: 12px;
        margin-bottom: 18px;
        border-radius: 8px;
        color: #b10000;
        font-size: 14px;
    }
</style>


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
