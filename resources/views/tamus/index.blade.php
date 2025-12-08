<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Daftar Tamu</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Tema -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            font-family: "Instrument Sans", sans-serif !important;
            overflow-x: hidden;
        }

        /* ========================= SIDEBAR ========================= */
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding-top: 80px;
            position: fixed;
            top: 0;
            left: 0;
            width: 230px;
            z-index: 2000;
            transition: transform 0.3s ease;
        }

        .sidebar a {
            color: #ffffff;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: background 0.2s ease, padding-left 0.2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.18);
            padding-left: 26px;
            border-radius: 8px;
        }

        .sidebar.hidden {
            transform: translateX(-230px);
        }

        /* ========================= OVERLAY ========================= */
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1500;
            display: none;
        }
        .overlay.show { display: block; }

        /* ========================= TOPBAR ========================= */
        .navbar-custom {
            background-color: white;
            border-bottom: 1px solid #ddd;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 2500;
            display: flex;
            align-items: center;
        }

        .navbar-custom h4 {
            margin: 0;
            font-weight: 600;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #667eea;
            cursor: pointer;
            margin-right: 15px;
        }

        /* ========================= MAIN ========================= */
        .main-content {
            margin-left: 240px;
            padding: 80px 20px 20px;
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-230px); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }

        /* ========================= DASHBOARD / TABLE ========================= */

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px;
        }

        .navbar h1 { margin: 0; font-size: 18px; font-weight: 600; }

        .navbar-actions { display:flex; gap:12px; align-items:center; }
        
        .btn-action {
            padding: 8px 14px;
            border-radius: 8px;
            border: 2px solid white;
            background: transparent;
            color: white;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .btn-action:hover {
            background: white;
            color: #667eea;
        }
        .btn-action2 {
            padding: 10px 14px;
            border-radius: 8px;
            border: 2px solid #667eea;
            background: transparent;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }
        .btn-action2:hover {
            background: white;
            color: black;
        }

        .container { max-width:1200px; margin:0 auto; padding:20px; }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 18px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 18px;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
            text-align: center;
        }

        .stat-card h3 {
            margin: 0;
            font-size: 14px;
            color: #6b6b6b;
        }
        .stat-card .number {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }

        .search-section {
            background: white;
            border-radius: 10px;
            padding: 16px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.04);
            margin-bottom: 18px;
        }

        .search-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; }

        .search-group label { font-weight: 600; margin-bottom: 6px; font-size: 13px; }

        .search-group input,
        .search-group select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #e6e6e6;
            border-radius: 6px;
        }

        .btn-search {
            padding: 8px 16px;
            border-radius: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            font-weight: 700;
            margin-top: 0px;
        }

        .btn-reset {
            padding: 10px 16px;
            border-radius: 8px;
            background: #fff;
            border: 1px solid #667eea;
            color: #667eea;
            font-weight: 700;
            text-decoration: none;
            margin-top: 0px;
            margin-left: 5px;
        }

        .table-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.04);
            overflow: hidden;
        }

        .table-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 18px;
        }

        table { width: 100%; border-collapse: collapse; }
        th { padding: 12px; background: #fafafa; border-bottom: 1px solid #eee; }
        td { padding: 12px; border-bottom: 1px solid #f1f1f1; }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            background: #e5e7eb;
            color: #374151;
        }
    </style>

</head>
<body>

<!-- Overlay -->
<div class="overlay" id="overlay"></div>

<!-- Topbar -->
<div class="navbar-custom">
    <button class="toggle-btn" id="toggleBtn">☰</button>

    <h4 style="
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        color: transparent;
        font-weight: 700;
    ">
        Librain
    </h4>

    <h4 class="flex-grow-1 fw-bold text-center">Dashboard Admin</h4>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <a href="{{ route('tamus.index') }}" class="active">Daftar Tamu</a>
    <a href="{{ route('tamus.statistik') }}">Statistik</a>

    <form action="{{ route('admin.logout') }}" method="POST" class="mt-3 px-3">
        @csrf
        <button type="submit" class="btn w-100 btn-light text-dark fw-semibold">Logout</button>
    </form>
</div>

<!-- Main Content -->
<div class="main-content" id="main">

    <div class="navbar mb-3">
        <div class="navbar-actions">
            <a href="{{ route('tamus.create') }}" class="btn-action" style="background:white; color:#667eea;">+ Tambah Tamu</a>
            <a href="{{ route('tamus.exportPDF', request()->query()) }}" class="btn-action" target="_blank">Export PDF</a>
            <a href="{{ route('tamus.exportExcel', request()->query()) }}" class="btn-action" target="_blank">Export Excel</a>
        </div>
    </div>

    <div class="container">

        <!-- Statistik Atas -->
        <div class="stats">
            <div class="stat-card">
                <h3>Total Tamu</h3>
                <div class="number">{{ $total_tamu }}</div>
            </div>

            <div class="stat-card">
                <h3>Tamu Hari Ini</h3>
                <div class="number">{{ $tamu_hari_ini }}</div>
            </div>
        </div>

        <!-- FILTER / SEARCH -->
        <div class="search-section">
            <h3 style="font-size:16px; font-weight:600;">Pencarian & Filter</h3>

            <form method="GET" action="{{ route('admin.dashboard') }}">
                <div class="search-grid">

                    <div class="search-group">
                        <label>Nama / Instansi</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau instansi...">
                    </div>

                    <div class="search-group">
                        <label>Tujuan Kunjungan</label>
                        <select name="tujuan">
                            <option value="">-- Semua Tujuan --</option>
                            @foreach ($tujuan_list as $tujuan)
                                <option value="{{ $tujuan }}" {{ request('tujuan') === $tujuan ? 'selected' : '' }}>
                                    {{ $tujuan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="search-group">
                        <label>Dari Tanggal</label>
                        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}">
                    </div>

                    <div class="search-group">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">
                    </div>

                </div>

                <div class="search-actions mt-3">
                    <button type="submit" class="btn-search">Cari</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-reset">Reset</a>
                </div>
            </form>
        </div>

        <!-- TABEL -->
        <div class="table-section">
            <div class="table-header">
                <h2 style="margin:0; font-size:18px; font-weight:600;">Daftar Tamu Pengunjung</h2>
            </div>

            <table>
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Asal Instansi</th>
                    <th>Tujuan Kunjungan</th>
                    <th>Waktu Kedatangan</th>
                    <th class="text-center">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($tamus as $index => $tamu)
                    <tr>
                        <td>{{ ($tamus->currentPage() - 1) * $tamus->perPage() + $index + 1 }}</td>
                        <td>{{ $tamu->nama }}</td>
                        <td>{{ $tamu->instansi }}</td>

                        <td><span class="badge">{{ $tamu->tujuan }}</span></td>

                        <td>{{ \Carbon\Carbon::parse($tamu->waktu_kedatangan)->format('d/m/Y H:i') }}</td>

                        <td class="text-center" style="white-space: nowrap;">
                            
                            <a href="{{ route('tamus.edit', $tamu->id) }}" class="btn-action2">Edit</a>

                            <form action="{{ route('tamus.destroy', $tamu->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data tamu ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action" style="border-color:#dc2626; color:#dc2626;">Hapus</button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:30px;">Belum ada data tamu</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            @if ($tamus->hasPages())
                <div class="pagination p-3">
                    {{ $tamus->links('pagination::simple-bootstrap-4') }}
                </div>
            @endif

        </div>

    </div>
</div>

<script>
    document.getElementById("toggleBtn").onclick = () => {
        document.getElementById("sidebar").classList.toggle("show");
        document.getElementById("overlay").classList.toggle("show");
    };
    document.getElementById("overlay").onclick = () => {
        document.getElementById("sidebar").classList.remove("show");
        document.getElementById("overlay").classList.remove("show");
    };
</script>

</body>
</html>
