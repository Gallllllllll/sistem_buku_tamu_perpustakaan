@extends('layouts.app')

@section('title', 'Form Tamu Baru')

@section('content')
<div class="container">
    <h1>Form Pendaftaran Tamu Baru</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('tamu.store') }}">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" required>
        </div>

        <div class="mb-3">
            <label for="instansi" class="form-label">Instansi</label>
            <input type="text" name="instansi" class="form-control" id="instansi" required>
        </div>

        <div class="mb-3">
            <label for="tujuan" class="form-label">Tujuan</label>
            <input type="text" name="tujuan" class="form-control" id="tujuan" required>
        </div>

        <div class="mb-3">
            <label for="waktu_kedatangan" class="form-label">Waktu Kedatangan</label>
            <input type="datetime-local" name="waktu_kedatangan" class="form-control" id="waktu_kedatangan">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
