<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Tamu Baru - Buku Tamu Digital</title>

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
            background: #f5f5f5;
            min-height: 100vh;
            color: #1b1b18;
        }

        /* =============== NAV TOP =============== */
        .navbar-top {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .navbar-title {
            font-size: 20px;
            font-weight: 600;
        }

        .navbar-actions {
            display: flex;
            gap: 12px;
        }

        .btn-nav {
            padding: 8px 15px;
            border-radius: 6px;
            border: 2px solid white;
            background: transparent;
            color: white;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .btn-nav:hover {
            background: white;
            color: #667eea;
        }

        /* ================= CONTENT ================= */
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome {
            text-align: center;
            margin-bottom: 25px;
        }

        .welcome h2 {
            font-weight: 700;
            font-size: 22px;
            color: #667eea;
            margin-bottom: 8px;
        }

        .welcome p {
            font-size: 14px;
            color: #706f6c;
        }

        /* ================= CARD FORM ================= */
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
            border-top: 4px solid #667eea;
        }

        .form-card h3 {
            text-align: center;
            font-size: 16px;
            color: #667eea;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
            display: block;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #d4d4d2;
            font-size: 14px;
            color: #333;
            background: #fafafa;
            transition: border 0.2s ease;
            font-family: inherit;
        }

        .form-input:focus, .form-select:focus {
            border-color: #667eea;
            outline: none;
        }

        .btn-submit {
            width: 100%;
            margin-top: 10px;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.25s ease;
        }

        .btn-submit:hover {
            opacity: 0.85;
        }

        /* Alert */
        .alert {
            margin-bottom: 18px;
            padding: 15px;
            border-radius: 8px;
            font-size: 14px;
            animation: fade 0.3s ease;
        }

        .alert-success {
            background: #e8f7ee;
            border-left: 4px solid #3bb273;
            color: #256f4d;
        }

        .alert-danger {
            background: #ffe9e9;
            border-left: 4px solid #ff5a5a;
            color: #b83131;
        }

        @keyframes fade {
            from { opacity: 0; transform: translateY(-3px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .navbar-top {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- =============== NAVBAR =============== -->
    <div class="navbar-top">
        <div class="navbar-title">Buku Tamu Digital</div>

        <div class="navbar-actions">
            @guest
                <a href="{{ route('login.admin') }}" class="btn-nav">Login Admin</a>
                <a href="{{ route('register') }}" class="btn-nav">Daftar</a>
                <a href="{{ route('loginuser') }}" class="btn-nav">Login</a>
            @else
                <a href="{{ route('tamus.index') }}" class="btn-nav">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn-nav" type="submit">Logout</button>
                </form>
            @endguest
        </div>
    </div>

    <!-- =============== CONTENT =============== -->
    <div class="container">

        <div class="welcome">
            <h2>Selamat Datang di E-Library</h2>
            <p>Silakan isi data kunjunganmu pada formulir berikut.</p>
        </div>

        <div class="form-card">
            <h3>Tambah Tamu Baru</h3>

            @if(session('success'))
                <div class="alert alert-success">
                    Terima kasih! Data berhasil disimpan.
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-left: 15px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tamus.store') }}" method="POST">
                @csrf

                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-input" placeholder="Masukkan nama lengkap" required>

                <label class="form-label" style="margin-top: 12px;">Instansi</label>
                <input type="text" name="instansi" class="form-input" placeholder="Masukkan nama instansi" required>

                <label class="form-label" style="margin-top: 12px;">Tujuan Kunjungan</label>
                <select name="tujuan" class="form-select" required>
                    <option value="">-- Pilih Tujuan --</option>
                    <option value="Membaca">Membaca</option>
                    <option value="Meminjam Buku">Meminjam Buku</option>
                    <option value="Mengembalikan Buku">Mengembalikan Buku</option>
                    <option value="Mencari Referensi">Mencari Referensi</option>
                    <option value="Diskusi/Belajar Kelompok">Diskusi / Belajar Kelompok</option>
                    <option value="Menggunakan Fasilitas (Komputer/Internet)">Menggunakan Fasilitas</option>
                    <option value="Lainnya">Lainnya</option>
                </select>

                <button class="btn-submit" type="submit">Simpan Data Tamu</button>
            </form>
        </div>
    </div>

</body>
</html>
