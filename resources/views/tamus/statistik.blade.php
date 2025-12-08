<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Statistik - Sistem Buku Tamu</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <!-- Font Tema -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <script src="https://code.highcharts.com/highcharts.js"></script>


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
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px;
        }

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

        /* ========================= Local statistik styles (kept but adjusted) ========================= */
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
            border-top: 4px solid #667eea;
        }

        .stat-card h3 { margin: 0; font-size: 14px; color: #6b6b6b; }
        .stat-card .number { font-size: 28px; font-weight: 700; color: #333; }

        .section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.04);
            padding: 18px;
            margin-bottom: 20px;
        }

        .section h2 { font-size:16px; margin-bottom:12px; color:#333; }

        .stats-list { display: grid; gap: 12px; }

        .stat-item { background:#f9f9f9; border-left:4px solid #667eea; padding:10px; border-radius:6px; display:grid; align-items:center; gap:10px; width:100%; grid-template-columns: 300px 1fr auto; }

        .progress-bar { background: #e3e3e0; height: 18px; border-radius: 10px; overflow: hidden; }
        .progress-fill { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height:100%; }

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
    <a href="{{ route('tamus.index') }}">Daftar Tamu</a>
    <a href="{{ route('tamus.statistik') }}" class="active">Statistik</a>

    <form action="{{ route('admin.logout') }}" method="POST" class="mt-3 px-3">
        @csrf
        <button type="submit" class="btn w-100 btn-light text-dark fw-semibold">Logout</button>
    </form>
</div>

<!-- Main Content -->
<div class="main-content" id="main">

    <div class="navbar mb-3">
        <div class="navbar-actions">
            <a href="{{ route('admin.export-statistik-pdf') }}" class="btn-action" target="_blank">Export Statistik PDF</a>
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

            <div class="stat-card">
                <h3>Tamu Bulan Ini</h3>
                <div class="number">{{ $tamu_bulan_ini }}</div>
            </div>

            <div class="stat-card">
                <h3>Tamu Tahun Ini</h3>
                <div class="number">{{ $tamu_tahun_ini }}</div>
            </div>
        </div>

        <div class="section">
            <h2>10 Nama yang Sering Berkunjung</h2>
            <div class="stats-list">
                @php $max_nama = $top_nama->max('count') ?? 1; @endphp
                @forelse ($top_nama as $index => $item)
                    <div class="stat-item">
                        <div class="stat-item-label">{{ $index + 1 }}. {{ $item->nama ?? 'Tidak Diketahui' }}</div>
                        <div class="progress-bar" style="width:40%;">
                            <div class="progress-fill" style="width: {{ ($item->count / $max_nama) * 100 }}%;"></div>
                        </div>
                        <div style="font-weight:700; margin-left:10px;">{{ $item->count }}</div>
                    </div>
                @empty
                    <p style="text-align:center; padding:15px; color:#666;">Belum ada data nama</p>
                @endforelse
            </div>
        </div>

        <div class="section">
            <h2>Statistik Berdasarkan Tujuan Kunjungan</h2>
            <div class="stats-list">
                @php $max_count = $by_tujuan->max('count') ?? 1; @endphp
                @foreach ($by_tujuan as $item)
                    <div class="stat-item">
                        <div class="stat-item-label">{{ $item->tujuan }}</div>
                        <div class="progress-bar" style="width:60%;">
                            <div class="progress-fill" style="width: {{ ($item->count / $max_count) * 100 }}%;"></div>
                        </div>
                        <div style="font-weight:700; margin-left:10px;">{{ $item->count }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="section">
            <h2>10 Instansi Terbanyak Berkunjung</h2>
            <div class="stats-list">
                @php $max_instansi = $top_instansi->max('count') ?? 1; @endphp
                @forelse ($top_instansi as $index => $item)
                    <div class="stat-item">
                        <div class="stat-item-label">{{ $index + 1 }}. {{ $item->instansi ?? 'Tidak Diketahui' }}</div>
                        <div class="progress-bar" style="width:50%;">
                            <div class="progress-fill" style="width: {{ ($item->count / $max_instansi) * 100 }}%;"></div>
                        </div>
                        <div style="font-weight:700; margin-left:10px;">{{ $item->count }}</div>
                    </div>
                @empty
                    <p style="text-align:center; padding:15px; color:#666;">Belum ada data instansi</p>
                @endforelse
            </div>
        </div>

        <div class="section">
            <h2>Statistik Kunjungan 30 Hari Terakhir</h2>
            @php $max_daily = $daily_stats->max('count') ?? 1; @endphp
            @if ($daily_stats->count() > 0)
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th class="text-center">Jumlah Tamu</th>
                            <th>Visualisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daily_stats as $stat)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($stat->tanggal)->format('d M Y') }}</td>
                                <td class="text-center fw-bold">{{ $stat->count }}</td>
                                <td>
                                    <div style="background:#e3e3e0; height:14px; border-radius:6px; overflow:hidden;">
                                        <div style="background:linear-gradient(135deg,#667eea 0%,#764ba2 100%); height:100%; width: {{ ($stat->count / $max_daily) * 100 }}%;"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align:center; padding:15px; color:#666;">Belum ada data untuk 30 hari terakhir</p>
            @endif
        </div>
        <div class="section">

    <!-- GRAFIK HIGHCHART -->
    <div id="dailyChart" style="width:100%; height:350px; margin-bottom:25px;"></div>


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
<script>
    // Konversi data dari PHP ke JS
    const dates = @json($daily_stats->pluck('tanggal')->map(fn($t) => \Carbon\Carbon::parse($t)->format('d M')));
    const counts = @json($daily_stats->pluck('count'));

    Highcharts.chart('dailyChart', {
        chart: {
            type: 'line',
            backgroundColor: '#ffffff',
            borderRadius: 10,
        },
        title: {
            text: 'Grafik Pengunjung 30 Hari Terakhir',
            style: { color: '#333', fontSize: '16px', fontWeight: '700' }
        },
        xAxis: {
            categories: dates,
            title: { text: 'Tanggal' },
            labels: { style: { fontSize: '11px' } }
        },
        yAxis: {
            title: { text: 'Jumlah Tamu' }
        },
        colors: ['#667eea'],
        series: [{
            name: 'Jumlah Tamu',
            data: counts,
            lineWidth: 3,
            marker: {
                radius: 4,
                fillColor: '#764ba2'
            }
        }]
    });
</script>


</body>
</html>
