@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="welcome-text text-center mb-4">
        <h2>📚 Selamat Datang, {{ auth()->user()->name }}</h2>
        <p>Total kunjungan/tamu yang sudah tercatat: <strong>{{ $totalTamu }}</strong></p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            🎉 {{ session('success') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-white bg-primary text-center">
                    <h4>➕ Tambah Tamu Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('member.dashboard.tamu') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="mb-3">
                            <label for="instansi" class="form-label">Instansi</label>
                            <input type="text" name="instansi" id="instansi" class="form-control" placeholder="Masukkan asal instansi" required>
                        </div>

                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan Kunjungan</label>
                            <select name="tujuan" id="tujuan" class="form-select" required>
                                <option value="">-- Pilih Tujuan --</option>
                                <option value="Membaca">Membaca</option>
                                <option value="Meminjam Buku">Meminjam Buku</option>
                                <option value="Mengembalikan Buku">Mengembalikan Buku</option>
                                <option value="Mencari Referensi">Mencari Referensi</option>
                                <option value="Diskusi/Belajar Kelompok">Diskusi / Belajar Kelompok</option>
                                <option value="Menggunakan Fasilitas (Komputer/Internet)">Menggunakan Fasilitas</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">💾 Simpan Tamu</button>
                        </div>
                    </form>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-3 text-end">
                @csrf
                <button type="submit" class="btn btn-danger">🚪 Logout</button>
            </form>
        </div>
    </div>
</div>
@endsection
