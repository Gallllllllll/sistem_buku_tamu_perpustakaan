<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tamu;

class TamuController extends Controller
{
    public function index()
    {
        $tamus = Tamu::latest()->get();
        return view('tamus.index', compact('tamus'));
    }

    public function statistik()
    {
        // Statistik total
        $totalTamu = Tamu::count();

        // Bulan ini (tanpa Carbon)
        $totalBulanIni = Tamu::whereMonth('waktu_kedatangan', date('m'))
                             ->whereYear('waktu_kedatangan', date('Y'))
                             ->count();

        // Hari ini (tanpa Carbon)
        $totalHariIni = Tamu::whereDate('waktu_kedatangan', date('Y-m-d'))
                            ->count();

        // Statistik tamu per hari (tanpa Carbon)
        $tamuPerHari = Tamu::selectRaw('DATE(waktu_kedatangan) as tanggal, COUNT(*) as jumlah')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        // Statistik tamu per aktivitas (tujuan)
        $tamuPerAktivitas = Tamu::selectRaw('tujuan as aktivitas, COUNT(*) as jumlah')
            ->groupBy('aktivitas')
            ->orderBy('aktivitas')
            ->get();
        
        $tamuPerMember = Tamu::selectRaw('nama, COUNT(*) as jumlah')
            ->groupBy('nama')
            ->orderBy('nama')
            ->get();


        return view('tamus.statistik', compact(
            'totalTamu',
            'totalBulanIni',
            'totalHariIni',
            'tamuPerHari',
            'tamuPerAktivitas',
            'tamuPerMember',
        ));
    }
}
