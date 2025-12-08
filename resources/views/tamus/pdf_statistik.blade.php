<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #8b0000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
        }
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Laporan Statistik Tamu</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                color: #333;
            }
        
            h1, h2 {
                color: #667eea;
                border-bottom: 2px solid #667eea;
                padding-bottom: 10px;
            }
        
            h1 {
                text-align: center;
                margin-bottom: 5px;
            }
        
            h2 {
                font-size: 14px;
                margin-top: 25px;
                margin-bottom: 15px;
            }
        
            .info {
                text-align: center;
                font-size: 12px;
                color: #666;
                margin-bottom: 20px;
            }
        
            .stats-header {
                display: flex;
                justify-content: space-around;
                margin: 20px 0;
                flex-wrap: wrap;
            }
        
            .stat-box {
                border: 1px solid #667eea;
                padding: 15px;
                margin: 5px;
                border-radius: 5px;
                text-align: center;
                min-width: 120px;
            }
        
            .stat-box .label {
                font-size: 11px;
                color: #666;
                margin-bottom: 5px;
            }
        
            .stat-box .value {
                font-size: 24px;
                font-weight: bold;
                color: #667eea;
            }
        
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }
        
            th {
                background-color: #667eea;
                color: white;
                padding: 10px;
                text-align: left;
                font-weight: bold;
                border: 1px solid #ddd;
                font-size: 11px;
            }
        
            td {
                padding: 8px 10px;
                border: 1px solid #ddd;
                font-size: 10px;
            }
        
            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
        
            .progress-bar {
                background: #e0e0e0;
                height: 20px;
                border-radius: 3px;
                overflow: hidden;
            }
        
            .progress-fill {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 9px;
                font-weight: bold;
            }
        
            .footer {
                margin-top: 30px;
                text-align: center;
                font-size: 10px;
                color: #999;
                border-top: 1px solid #ddd;
                padding-top: 15px;
            }
        </style>
    </head>
    <body>
        <h1> Laporan Statistik Tamu</h1>
        <div class="info">
            Laporan Lengkap - Tanggal: {{ now()->format('d/m/Y H:i') }}
        </div>
    
        <!-- Stats Header -->
        <div class="stats-header">
            <div class="stat-box">
                <div class="label">Total Tamu</div>
                <div class="value">{{ $total_tamu }}</div>
            </div>
            <div class="stat-box">
                <div class="label">Tamu Hari Ini</div>
                <div class="value">{{ $tamu_hari_ini }}</div>
            </div>
            <div class="stat-box">
                <div class="label">Tamu Bulan Ini</div>
                <div class="value">{{ $tamu_bulan_ini }}</div>
            </div>
            <div class="stat-box">
                <div class="label">Tamu Tahun Ini</div>
                <div class="value">{{ $tamu_tahun_ini }}</div>
            </div>
        </div>
    
        <!-- Top 10 Nama -->
        <h2> 10 Nama yang Sering Berkunjung</h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 40%;">Nama</th>
                    <th style="width: 15%;">Jumlah Kunjungan</th>
                    <th style="width: 40%;">Visualisasi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $max_nama = $top_nama->max('count') ?? 1;
                @endphp
                @forelse ($top_nama as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama ?? 'Tidak Diketahui' }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ $item->count }}</td>
                        <td>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ ($item->count / $max_nama) * 100 }}%;">
                                    {{ round(($item->count / $max_nama) * 100) }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;">Belum ada data nama</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    
        <!-- Tujuan Kunjungan -->
        <h2> Statistik Berdasarkan Tujuan Kunjungan</h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Tujuan Kunjungan</th>
                    <th style="width: 15%;">Jumlah Tamu</th>
                    <th style="width: 65%;">Visualisasi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $max_count = $by_tujuan->max('count') ?? 1;
                @endphp
                @foreach ($by_tujuan as $item)
                    <tr>
                        <td>{{ $item->tujuan }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ $item->count }}</td>
                        <td>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ ($item->count / $max_count) * 100 }}%;">
                                    {{ round(($item->count / $max_count) * 100) }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <!-- Top 10 Instansi -->
        <h2> 10 Instansi Terbanyak Berkunjung</h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 45%;">Instansi</th>
                    <th style="width: 15%;">Jumlah Kunjungan</th>
                    <th style="width: 35%;">Visualisasi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $max_instansi = $top_instansi->max('count') ?? 1;
                @endphp
                @forelse ($top_instansi as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->instansi ?? 'Tidak Diketahui' }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ $item->count }}</td>
                        <td>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ ($item->count / $max_instansi) * 100 }}%;">
                                    {{ round(($item->count / $max_instansi) * 100) }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;">Belum ada data instansi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    
        <!-- Daily Stats -->
        <h2> Statistik Kunjungan 30 Hari Terakhir</h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Tanggal</th>
                    <th style="width: 20%;">Jumlah Tamu</th>
                    <th style="width: 60%;">Visualisasi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $max_daily = $daily_stats->max('count') ?? 1;
                @endphp
                @if ($daily_stats->count() > 0)
                    @foreach ($daily_stats as $stat)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($stat->tanggal)->format('d/m/Y') }}</td>
                            <td style="text-align: center; font-weight: bold;">{{ $stat->count }}</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ ($stat->count / $max_daily) * 100 }}%;">
                                        {{ round(($stat->count / $max_daily) * 100) }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 20px;">Belum ada data untuk 30 hari terakhir</td>
                    </tr>
                @endif
            </tbody>
        </table>
    
        <div class="footer">
            <p>Laporan ini dibuat otomatis oleh Sistem Buku Tamu Digital</p>
            <p>Total Data Tamu: {{ $total_tamu }} | Dicetak pada {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </body>
    </html>

