<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Biodata Tamu</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="icon" href="{{ asset('images/librain-logo.png') }}" type="image/x-icon">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
            font-family: 'Instrument Sans', sans-serif;
            color: #333;
        }

        /* HEADER */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px 30px;
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            margin-bottom: 40px;
        }

        .page-header h2 {
            font-size: 20px;
            margin: 0;
            font-weight: 700;
        }

        /* CARD */
        .form-card {
            background: white;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.12);
            border-top: 4px solid #667eea;
            animation: fade 0.3s ease;
        }

        @keyframes fade {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 6px;
            color: #444;
        }

        input, select {
            border-radius: 10px !important;
            padding: 12px !important;
            border: 1px solid #ccc !important;
            background: #fafafa !important;
            transition: 0.2s ease;
        }

        input:focus, select:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 7px rgba(102, 126, 234, 0.35) !important;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 700;
            padding: 12px 18px;
            border-radius: 10px;
            width: 100%;
            margin-top: 8px;
            text-align: center;
        }

        .btn-submit:hover {
            opacity: 0.9;
        }

        .btn-cancel {
            border: 1px solid #764ba2;
            color: #764ba2;
            font-weight: 600;
            padding: 11px 18px;
            border-radius: 10px;
            width: 100%;
            margin-top: 8px;
            background: white;
            text-align: center;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background: #764ba2;
            color: white;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="page-header">
        <h2>Edit Biodata Tamu</h2>
    </div>

    <div class="container" style="max-width: 650px;">

        <div class="form-card">

            <!-- Alert Error -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ms-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tamus.update', $tamu->id) }}" method="POST">
                @csrf

                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control"
                    value="{{ old('nama', $tamu->nama) }}" required>

                <label class="form-label mt-3">Instansi</label>
                <input type="text" name="instansi" class="form-control"
                    value="{{ old('instansi', $tamu->instansi) }}" required>

                <label class="form-label mt-3">Tujuan Kunjungan</label>
                <select name="tujuan" class="form-control" required>
                    <option value="">-- Pilih Tujuan --</option>
                    <option value="Membaca" {{ old('tujuan', $tamu->tujuan) == 'Membaca' ? 'selected' : '' }}>Membaca</option>
                    <option value="Meminjam Buku" {{ old('tujuan', $tamu->tujuan) == 'Meminjam Buku' ? 'selected' : '' }}>Meminjam Buku</option>
                    <option value="Mengembalikan Buku" {{ old('tujuan', $tamu->tujuan) == 'Mengembalikan Buku' ? 'selected' : '' }}>Mengembalikan Buku</option>
                    <option value="Mencari Referensi" {{ old('tujuan', $tamu->tujuan) == 'Mencari Referensi' ? 'selected' : '' }}>Mencari Referensi</option>
                    <option value="Diskusi / Belajar Kelompok" {{ old('tujuan', $tamu->tujuan) == 'Diskusi / Belajar Kelompok' ? 'selected' : '' }}>Diskusi / Belajar Kelompok</option>
                    <option value="Menggunakan Fasilitas (Komputer/Internet)" {{ old('tujuan', $tamu->tujuan) == 'Menggunakan Fasilitas (Komputer/Internet)' ? 'selected' : '' }}>Menggunakan Fasilitas (Komputer/Internet)</option>
                    <option value="Lainnya" {{ old('tujuan', $tamu->tujuan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>

                <label class="form-label mt-3">Waktu Kedatangan</label>
                <input type="datetime-local" name="waktu_kedatangan" class="form-control"
                    value="{{ old('waktu_kedatangan', $tamu->waktu_kedatangan ? date('Y-m-d\TH:i', strtotime($tamu->waktu_kedatangan)) : '') }}">

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn-submit flex-fill">Perbarui Data</button>
                    <a href="{{ route('tamus.index') }}" class="btn-cancel flex-fill">Batal</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>
