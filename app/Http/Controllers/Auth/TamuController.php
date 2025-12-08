<?php

namespace App\Http\Controllers\Auth;

use App\Models\Tamu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TamuExport;
use Barryvdh\DomPDF\Facade\Pdf as DomPdf;
use Carbon\Carbon;

class TamuController extends Controller
{
    // ========================================
    // 1. DAFTAR TAMU + PENCARIAN + SORTING
    // ========================================
    public function index(Request $request)
    {
        $query = Tamu::query();

        // === FILTER ===
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('instansi', 'like', "%$search%");
            });
        }

        // === URUTKAN ===
        $tamus = $query->orderBy('waktu_kedatangan', 'DESC')->paginate(10);

        return view('tamus.index', compact('tamus'));
    }

    // ========================================
    // 2. FORM TAMBAH TAMU
    // ========================================
    public function create()
    {
        return view('tamus.create');
    }

    // ========================================
    // 3. SIMPAN TAMU BARU (FIX TIMESTAMP)
    // ========================================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'instansi' => 'required|string',
            'tujuan' => 'required|string',
        ]);

        Tamu::create([
            'nama' => $request->nama,
            'instansi' => $request->instansi,
            'tujuan' => $request->tujuan,
            'waktu_kedatangan' => now(),   // FIX: realtime
        ]);

        return back()->with('success', 'Tamu baru sudah masuk!');
    }

    // ========================================
    // 4. HAPUS TAMU
    // ========================================
    public function destroy($id)
    {
        $tamu = Tamu::findOrFail($id);
        $tamu->delete();

        return redirect()->route('tamus.index')->with('success', 'Data tamu berhasil dihapus!');
    }

    // ========================================
    // 5. STATISTIK
    // ========================================
    public function statistik()
    {
        $totalTamu = Tamu::count();
        $totalBulanIni = Tamu::whereMonth('waktu_kedatangan', now()->month)->count();
        $totalHariIni = Tamu::whereDate('waktu_kedatangan', today())->count();
        $daily_stats = $this->dailyStats();


        $tamuPerHari = Tamu::selectRaw('DATE(waktu_kedatangan) as tanggal, COUNT(*) as jumlah')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($item) {
                $item->tanggal = Carbon::parse($item->tanggal)->format('Y-m-d');
                return $item;
            });

        $tamuPerAktivitas = Tamu::selectRaw('tujuan as aktivitas, COUNT(*) as jumlah')
            ->groupBy('aktivitas')
            ->orderBy('aktivitas')
            ->get();

        $tamuPerNama = Tamu::selectRaw('nama, COUNT(*) as jumlah')
            ->groupBy('nama')
            ->orderBy('jumlah', 'desc')
            ->get();

        return view('tamus.statistik', compact(
            'totalTamu',
            'totalBulanIni',
            'totalHariIni',
            'tamuPerHari',
            'tamuPerAktivitas',
            'tamuPerNama',
            'daily_stats'
        ));
    }

    // ========================================
    // 6. EXPORT EXCEL
    // ========================================
    public function exportExcel()
    {
        return Excel::download(new TamuExport, 'tamu.xlsx');
    }

    // ========================================
    // 7. EXPORT PDF
    // ========================================
    public function exportPDF()
    {
        $tamus = Tamu::orderBy('waktu_kedatangan', 'desc')->get();
        $pdf = DomPdf::loadView('tamus.pdf', compact('tamus'));
        return $pdf->download('tamu.pdf');
    }

    // ========================================
    // 8. EDIT & UPDATE
    // ========================================
    public function edit($id)
    {
        $tamu = Tamu::findOrFail($id);
        return view('tamus.edit', compact('tamu'));
    }

    public function update(Request $request, $id)
    {
        $tamu = Tamu::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
        ]);

        $tamu->update($request->only(['nama', 'instansi', 'tujuan']));

        return redirect()->route('tamus.index')->with('success', 'Data tamu berhasil diperbarui!');
    }

    // ========================================
    // DAILY STATS (30 hari terakhir untuk grafik)
    // ========================================
    public function dailyStats()
{
    $start = Carbon::now()->subDays(29)->startOfDay();
    $end = Carbon::now()->endOfDay();

    // data real dari DB
    $rawData = Tamu::selectRaw('DATE(waktu_kedatangan) AS tanggal, COUNT(*) AS count')
        ->whereBetween('waktu_kedatangan', [$start, $end])
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'ASC')
        ->get()
        ->keyBy('tanggal');

    // generate lengkap 30 hari
    $daily_stats = collect();

    for ($date = $start->copy(); $date <= $end; $date->addDay()) {
        $formatted = $date->format('Y-m-d');

        $daily_stats->push([
            'tanggal' => $formatted,
            'count'   => isset($rawData[$formatted]) ? (int)$rawData[$formatted]->count : 0
        ]);
    }

    return $daily_stats;
}
}