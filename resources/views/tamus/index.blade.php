<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Daftar Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            font-family: "Poppins", sans-serif;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            height: 100vh;
            background-color: #8b0000;
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
            color: white;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: 500;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #a52a2a;
            border-radius: 8px;
        }

        .sidebar.hidden {
            transform: translateX(-230px);
        }

        /* ===== OVERLAY ===== */
        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 1500;
            display: none;
        }

        .overlay.show {
            display: block;
        }

        /* ===== TOPBAR ===== */
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
            flex-grow: 1;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #8b0000;
            cursor: pointer;
            margin-right: 15px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 240px;
            padding: 80px 20px 20px;
            transition: margin-left 0.3s ease;
        }

        .main-content.full {
            margin-left: 0;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-230px);
                position: fixed;
                width: 230px;
                top: 0;
                left: 0;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Additional tidy admin styles (navbar, actions, cards, search, table) */
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 18px 24px; display:flex; justify-content:space-between; align-items:center; border-radius:8px; }
        .navbar h1 { margin:0; font-size:18px; font-weight:600; }
        .navbar-actions { display:flex; gap:12px; align-items:center; }
        .btn-action { padding:8px 14px; border-radius:8px; border:2px solid white; background:transparent; color:white; text-decoration:none; font-weight:600; }
        .btn-action:hover { background:white; color:#667eea; }

        .container { max-width:1200px; margin:0 auto; padding:20px; }
        .stats { display:grid; grid-template-columns: repeat(auto-fit,minmax(180px,1fr)); gap:18px; margin-bottom:20px; }
        .stat-card { background:white; padding:18px; border-radius:10px; box-shadow:0 6px 18px rgba(0,0,0,0.06); text-align:center; }
        .stat-card h3 { margin:0; font-size:13px; color:#6b6b6b; }
        .stat-card .number { font-size:26px; font-weight:700; color: #333; }

        .search-section { background:white; border-radius:10px; padding:16px; box-shadow:0 6px 18px rgba(0,0,0,0.04); margin-bottom:18px; }
        .search-grid { display:grid; grid-template-columns: repeat(auto-fit,minmax(200px,1fr)); gap:12px; }
        .search-group label { display:block; font-weight:600; margin-bottom:6px; font-size:13px; }
        .search-group input, .search-group select { width:100%; padding:8px 10px; border:1px solid #e6e6e6; border-radius:6px; }
        .search-actions { margin-top:12px; display:flex; gap:8px; }
        .btn-search { padding:8px 16px; border-radius:8px; background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:white; border:none; font-weight:700; }
        .btn-reset { padding:8px 16px; border-radius:8px; background:#fff; border:1px solid #667eea; color:#667eea; font-weight:700; }

        .table-section { background:white; border-radius:10px; box-shadow:0 6px 18px rgba(0,0,0,0.04); overflow:hidden; }
        .table-header { background: linear-gradient(135deg,#667eea 0%,#764ba2 100%); color:white; padding:14px 18px; }
        table { width:100%; border-collapse:collapse; }
        th { text-align:left; padding:12px; background:#fafafa; border-bottom:1px solid #eee; }
        td { padding:12px; border-bottom:1px solid #f1f1f1; }
        .badge { display:inline-block; padding:6px 10px; border-radius:20px; font-size:12px; }

        @media (max-width:768px) {
            .navbar { flex-direction:column; gap:10px; align-items:flex-start; }
            .search-grid { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Navbar -->
    <div class="navbar-custom">
        <button class="toggle-btn" id="toggleBtn">☰</button>
        <h4 class="fw-bold text-danger">📚 E-Library</h4>
        <h4 class="center flex-grow-1 fw-bold">📖 Daftar Tamu</h4>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="{{ route('tamus.index') }}" class="active">📖 Daftar Tamu</a>
        <a href="{{ route('tamus.statistik') }}">📊 Statistik</a>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>



    </div>
    

    <!-- Main Content -->
    <div class="main-content" id="main">
        {{-- Tombol aksi --}}
        <div class="mb-3 d-flex flex-wrap gap-2">
            <div class="navbar">
                <h1>📊 Admin Dashboard - Buku Tamu Digital</h1>
                <div class="navbar-actions">
                    <a href="{{ route('tamus.exportPDF', request()->query()) }}" class="btn-action" target="_blank">
                        📄 Export PDF
                    </a>
                    <a href="{{ route('tamus.exportExcel', request()->query()) }}" class="btn-action" target="_blank">
                        📊 Export Excel
                    </a>
                    <a href="{{ route('tamus.statistik') }}" class="btn-action">
                        📈 Statistik
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-action" onclick="return confirm('Yakin ingin logout?')">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            </div>

            <div class="container">
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

                <div class="search-section">
                    <h3>🔍 Pencarian & Filter</h3>
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="search-form">
                        <div class="search-grid">
                            <div class="search-group">
                                <label>Nama / Instansi</label>
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}" 
                                    placeholder="Cari nama atau instansi..."
                                >
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
                                <input 
                                    type="date" 
                                    name="tanggal_dari" 
                                    value="{{ request('tanggal_dari') }}"
                                >
                            </div>

                            <div class="search-group">
                                <label>Sampai Tanggal</label>
                                <input 
                                    type="date" 
                                    name="tanggal_sampai" 
                                    value="{{ request('tanggal_sampai') }}"
                                >
                            </div>
                        </div>

                        <div class="search-actions">
                            <button type="submit" class="btn-search">🔍 Cari</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn-reset">↻ Reset</a>
                        </div>
                    </form>
                </div>

                <div class="table-section">
                    <div class="table-header">
                        <h2>📋 Daftar Tamu Pengunjung</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Asal Instansi</th>
                                <th>Tujuan Kunjungan</th>
                                <th>Waktu Kedatangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tamus as $index => $tamu)
                                <tr>
                                    <td>{{ ($tamus->currentPage() - 1) * $tamus->perPage() + $index + 1 }}</td>
                                    <td>{{ $tamu->nama }}</td>
                                    <td>{{ $tamu->instansi }}</td>
                                    <td>
                                        <span class="badge badge-{{ strtolower(str_replace(' ', '-', $tamu->tujuan)) }}">
                                            {{ $tamu->tujuan }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($tamu->waktu_kedatangan)->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('tamus.edit', $tamu->id) }}" class="btn-action" title="Edit {{ $tamu->nama }}">✏️ Edit</a>
                                        <form method="POST" action="{{ route('tamus.destroy', $tamu->id) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data tamu ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action" style="border-color:#dc2626; background:#fff; color:#dc2626;">🗑️ Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 30px;">
                                        Belum ada data tamu
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($tamus->hasPages())
                        <div class="pagination">
                            {{ $tamus->links('pagination::simple-bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
