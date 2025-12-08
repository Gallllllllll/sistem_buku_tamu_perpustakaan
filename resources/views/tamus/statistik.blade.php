<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Statistik - Sistem Buku Tamu Digital</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                background: #f5f5f5;
                color: #1b1b18;
            }
            
            .navbar {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 20px 30px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }
            
            .navbar h1 {
                font-size: 20px;
                font-weight: 600;
            }
            
            .navbar-actions {
                display: flex;
                gap: 15px;
            }
            
            .btn-action {
                padding: 8px 15px;
                border-radius: 6px;
                border: 2px solid white;
                background: transparent;
                color: white;
                cursor: pointer;
                font-size: 13px;
                font-weight: 600;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                transition: all 0.3s ease;
                font-family: inherit;
            }
            
            .btn-action:hover {
                background: white;
                color: #667eea;
            }
            
            .container {
                max-width: 1000px;
                margin: 0 auto;
                padding: 30px 20px;
            }
            
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
                margin-bottom: 30px;
            }
            
            .stat-card {
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                text-align: center;
                border-top: 4px solid #667eea;
            }
            
            .stat-card h3 {
                color: #706f6c;
                font-size: 12px;
                font-weight: 500;
                margin-bottom: 15px;
                text-transform: uppercase;
            }
            
            .stat-card .number {
                font-size: 40px;
                font-weight: 700;
                color: #667eea;
            }
            
            .section {
                background: white;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                padding: 30px;
                margin-bottom: 20px;
            }
            
            .section h2 {
                font-size: 16px;
                margin-bottom: 20px;
                color: #667eea;
                border-bottom: 2px solid #e3e3e0;
                padding-bottom: 15px;
            }
            
            .stats-list {
                display: grid;
                gap: 15px;
            }
            
            .stat-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px;
                background: #f9f9f9;
                border-radius: 6px;
                border-left: 4px solid #667eea;
            }
            
            .stat-item-label {
                font-weight: 600;
                font-size: 13px;
            }
            
            .stat-item-value {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                font-weight: 700;
                font-size: 18px;
            }
            
            .progress-bar {
                background: #e3e3e0;
                height: 20px;
                border-radius: 10px;
                overflow: hidden;
                margin-top: 8px;
            }
            
            .progress-fill {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 11px;
                font-weight: 600;
            }
            
            .back-link {
                text-align: center;
                margin-top: 20px;
            }
            
            .back-link a {
                color: #667eea;
                text-decoration: none;
                font-size: 13px;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }
            
            .back-link a:hover {
                color: #764ba2;
            }
            
            @media (max-width: 768px) {
                .navbar {
                    flex-direction: column;
                    gap: 15px;
                    align-items: flex-start;
                }
                
                .stat-item {
                    flex-direction: column;
                    align-items: flex-start;
                }
            }
        </style>
    </head>
    <body>
        <div class="navbar">
            <h1>📈 Statistik - Buku Tamu Digital</h1>
            <div class="navbar-actions">
                <a href="{{ route('admin.export-statistik-pdf') }}" class="btn-action" target="_blank">
                    📄 Export Statistik PDF
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn-action">
                    ⬅️ Kembali Dashboard
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
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>👥 Total Tamu</h3>
                    <div class="number">{{ $total_tamu }}</div>
                </div>
                <div class="stat-card">
                    <h3>📅 Tamu Hari Ini</h3>
                    <div class="number">{{ $tamu_hari_ini }}</div>
                </div>
                <div class="stat-card">
                    <h3>📆 Tamu Bulan Ini</h3>
                    <div class="number">{{ $tamu_bulan_ini }}</div>
                </div>
                <div class="stat-card">
                    <h3>📊 Tamu Tahun Ini</h3>
                    <div class="number">{{ $tamu_tahun_ini }}</div>
                </div>
            </div>
            
            <div class="section">
                <h2>👤 10 Nama yang Sering Berkunjung</h2>
                <div class="stats-list">
                    @php
                        $max_nama = $top_nama->max('count') ?? 1;
                    @endphp
                    @forelse ($top_nama as $index => $item)
                        <div class="stat-item">
                            <div style="flex: 1;">
                                <div class="stat-item-label">
                                    {{ $index + 1 }}. {{ $item->nama ?? 'Tidak Diketahui' }}
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ ($item->count / $max_nama) * 100 }}%;">
                                        {{ $item->count }} kunjungan
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p style="text-align: center; color: #706f6c; padding: 20px;">
                            Belum ada data nama
                        </p>
                    @endforelse
                </div>
            </div>
            
            <div class="section">
                <h2>🎯 Statistik Berdasarkan Tujuan Kunjungan</h2>
                <div class="stats-list">
                    @php
                        $max_count = $by_tujuan->max('count') ?? 1;
                    @endphp
                    @foreach ($by_tujuan as $item)
                        <div class="stat-item">
                            <div style="flex: 1;">
                                <div class="stat-item-label">{{ $item->tujuan }}</div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ ($item->count / $max_count) * 100 }}%;">
                                        {{ $item->count }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="section">
                <h2>🏢 10 Instansi Terbanyak Berkunjung</h2>
                <div class="stats-list">
                    @php
                        $max_instansi = $top_instansi->max('count') ?? 1;
                    @endphp
                    @forelse ($top_instansi as $index => $item)
                        <div class="stat-item">
                            <div style="flex: 1;">
                                <div class="stat-item-label">
                                    {{ $index + 1 }}. {{ $item->instansi ?? 'Tidak Diketahui' }}
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ ($item->count / $max_instansi) * 100 }}%;">
                                        {{ $item->count }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p style="text-align: center; color: #706f6c; padding: 20px;">
                            Belum ada data instansi
                        </p>
                    @endforelse
                </div>
            </div>
            
            <div class="section">
                <h2>📊 Statistik Kunjungan 30 Hari Terakhir</h2>
                <div class="stats-list">
                    @php
                        $max_daily = $daily_stats->max('count') ?? 1;
                    @endphp
                    @if ($daily_stats->count() > 0)
                        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                            <thead>
                                <tr style="background: #f5f5f5; border-bottom: 2px solid #e3e3e0;">
                                    <th style="padding: 10px; text-align: left; font-weight: 600;">Tanggal</th>
                                    <th style="padding: 10px; text-align: center; font-weight: 600;">Jumlah Tamu</th>
                                    <th style="padding: 10px; text-align: left; font-weight: 600;">Visualisasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($daily_stats as $stat)
                                    <tr style="border-bottom: 1px solid #e3e3e0;">
                                        <td style="padding: 10px;">{{ \Carbon\Carbon::parse($stat->tanggal)->format('d M Y') }}</td>
                                        <td style="padding: 10px; text-align: center; font-weight: 600;">{{ $stat->count }}</td>
                                        <td style="padding: 10px;">
                                            <div style="background: #e3e3e0; height: 20px; border-radius: 4px; overflow: hidden;">
                                                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 100%; width: {{ ($stat->count / $max_daily) * 100 }}%;">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p style="text-align: center; color: #706f6c; padding: 20px;">
                            Belum ada data untuk 30 hari terakhir
                        </p>
                    @endif
                </div>
            </div>
            
            <div class="back-link">
                <a href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
            </div>
        </div>
    </body>
</html>
