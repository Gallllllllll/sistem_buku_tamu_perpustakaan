<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tamu;
use Carbon\Carbon;

class MemberDashboardController extends Controller
{
    // Dashboard member
    public function index()
    {
        $userId = auth()->id();

        // Total tamu member
        $totalTamu = Tamu::where('user_id', $userId)->count();

        // Statistik per nama
        $tamuPerNama = Tamu::selectRaw('nama, COUNT(*) as jumlah')
            ->where('user_id', $userId)
            ->groupBy('nama')
            ->orderBy('jumlah', 'desc')
            ->get();

        // Statistik per hari
        $tamuPerHari = Tamu::selectRaw('DATE(waktu_kedatangan) as tanggal, COUNT(*) as jumlah')
            ->where('user_id', $userId)
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function($item) {
                $item->tanggal = Carbon::parse($item->tanggal)->format('Y-m-d');
                return $item;
            });

        // Statistik per aktivitas/tujuan
        $tamuPerAktivitas = Tamu::selectRaw('tujuan as aktivitas, COUNT(*) as jumlah')
            ->where('user_id', $userId)
            ->groupBy('aktivitas')
            ->orderBy('jumlah', 'desc')
            ->get();

        return view('member.dashboard', compact(
            'totalTamu',
            'tamuPerNama',
            'tamuPerHari',
            'tamuPerAktivitas'
        ));
    }

    // Simpan tamu baru dari dashboard
    public function storeTamu(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'waktu_kedatangan' => 'nullable|date',
        ]);

        Tamu::create([
            'nama' => $request->nama,
            'instansi' => $request->instansi,
            'tujuan' => $request->tujuan,
            'waktu_kedatangan' => $request->waktu_kedatangan ?? now(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('member.dashboard')->with('success', 'Tamu baru berhasil ditambahkan!');
    }
}
