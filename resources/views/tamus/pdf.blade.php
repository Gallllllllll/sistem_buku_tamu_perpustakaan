<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tamu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        
        h1 {
            text-align: center;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .info {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-bottom: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background-color: #667eea;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
        }
        
        td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <h1> Daftar Tamu Pengunjung</h1>
    <div class="info">
        Laporan Lengkap - Tanggal: {{ now()->format('d/m/Y H:i') }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 20%;">Nama</th>
                <th style="width: 25%;">Asal Instansi</th>
                <th style="width: 20%;">Tujuan Kunjungan</th>
                <th style="width: 30%;">Waktu Kedatangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tamus as $index => $tamu)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $tamu->nama }}</td>
                    <td>{{ $tamu->instansi }}</td>
                    <td>{{ $tamu->tujuan }}</td>
                    <td>{{ \Carbon\Carbon::parse($tamu->waktu_kedatangan)->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Total Tamu: {{ count($tamus) }} | Dicetak pada {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
