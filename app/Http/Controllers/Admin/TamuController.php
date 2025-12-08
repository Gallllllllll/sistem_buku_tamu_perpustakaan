<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TamuExport;
use Barryvdh\DomPDF\Facade\Pdf as DomPdf;

class TamuController extends Controller
{
    public function index()
    {
        // Support basic filters from the index page and paginate
        $query = Tamu::query();

        if (request()->filled('search')) {
            $s = request('search');
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%{$s}%")
                  ->orWhere('instansi', 'like', "%{$s}%");
            });
        }

        if (request()->filled('tujuan')) {
            $query->where('tujuan', request('tujuan'));
        }

        if (request()->filled('tanggal_dari')) {
            $query->whereDate('waktu_kedatangan', '>=', request('tanggal_dari'));
        }

        if (request()->filled('tanggal_sampai')) {
            $query->whereDate('waktu_kedatangan', '<=', request('tanggal_sampai'));
        }

        $tamus = $query->orderBy('waktu_kedatangan', 'desc')->paginate(10)->withQueryString();

        $total_tamu = Tamu::count();
        $tamu_hari_ini = Tamu::whereDate('waktu_kedatangan', now()->toDateString())->count();
        $tujuan_list = Tamu::select('tujuan')->distinct()->pluck('tujuan');

        return view('tamus.index', compact('tamus', 'total_tamu', 'tamu_hari_ini', 'tujuan_list'));
    }

    public function statistik()
    {
        // Statistik total (sesuai penamaan view)
        $total_tamu = Tamu::count();

        // Bulan ini
        $tamu_bulan_ini = Tamu::whereMonth('waktu_kedatangan', date('m'))
                             ->whereYear('waktu_kedatangan', date('Y'))
                             ->count();

        // Hari ini
        $tamu_hari_ini = Tamu::whereDate('waktu_kedatangan', date('Y-m-d'))
                            ->count();

        // Tahun ini
        $tamu_tahun_ini = Tamu::whereYear('waktu_kedatangan', date('Y'))
                             ->count();

        // Top 10 nama (kunjungan terbanyak)
        $top_nama = Tamu::selectRaw('nama, COUNT(*) as count')
            ->groupBy('nama')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Statistik berdasarkan tujuan
        $by_tujuan = Tamu::selectRaw('tujuan, COUNT(*) as count')
            ->groupBy('tujuan')
            ->orderByDesc('count')
            ->get();

        // Top 10 instansi
        $top_instansi = Tamu::selectRaw('instansi, COUNT(*) as count')
            ->groupBy('instansi')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Statistik harian 30 hari terakhir
        $daily_stats = Tamu::selectRaw('DATE(waktu_kedatangan) as tanggal, COUNT(*) as count')
            ->where('waktu_kedatangan', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('tamus.statistik', compact(
            'total_tamu',
            'tamu_bulan_ini',
            'tamu_hari_ini',
            'tamu_tahun_ini',
            'top_nama',
            'by_tujuan',
            'top_instansi',
            'daily_stats'
        ));
    }

    // Export Excel (all tamu)
    public function exportExcel()
    {
        return Excel::download(new TamuExport, 'tamu.xlsx');
    }

    // Export PDF (Daftar Tamu)
    public function exportPDF()
    {
        $tamus = Tamu::orderBy('waktu_kedatangan', 'desc')->get();
        $pdf = DomPdf::loadView('tamus.pdf', compact('tamus'));
        return $pdf->download('daftar_tamu.pdf');
    }

    // Export Statistik PDF
    public function exportStatistik()
    {
        $total_tamu = Tamu::count();
        $tamu_bulan_ini = Tamu::whereMonth('waktu_kedatangan', date('m'))->whereYear('waktu_kedatangan', date('Y'))->count();
        $tamu_hari_ini = Tamu::whereDate('waktu_kedatangan', date('Y-m-d'))->count();
        $tamu_tahun_ini = Tamu::whereYear('waktu_kedatangan', date('Y'))->count();

        $top_nama = Tamu::selectRaw('nama, COUNT(*) as count')
            ->groupBy('nama')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $by_tujuan = Tamu::selectRaw('tujuan, COUNT(*) as count')
            ->groupBy('tujuan')
            ->orderByDesc('count')
            ->get();

        $top_instansi = Tamu::selectRaw('instansi, COUNT(*) as count')
            ->groupBy('instansi')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $daily_stats = Tamu::selectRaw('DATE(waktu_kedatangan) as tanggal, COUNT(*) as count')
            ->where('waktu_kedatangan', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        $pdf = DomPdf::loadView('tamus.pdf_statistik', compact(
            'total_tamu',
            'tamu_bulan_ini',
            'tamu_hari_ini',
            'tamu_tahun_ini',
            'top_nama',
            'by_tujuan',
            'top_instansi',
            'daily_stats'
        ));

        return $pdf->download('statistik_tamu.pdf');
    }

    // Show edit form for a tamu
    public function edit($id)
    {
        $tamu = Tamu::findOrFail($id);
        return view('tamus.edit', compact('tamu'));
    }

    // Update tamu
    public function update(Request $request, $id)
    {
        $tamu = Tamu::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'waktu_kedatangan' => 'nullable|date'
        ]);

        if (!empty($data['waktu_kedatangan'])) {
            $tamu->waktu_kedatangan = $data['waktu_kedatangan'];
        }

        $tamu->nama = $data['nama'];
        $tamu->instansi = $data['instansi'];
        $tamu->tujuan = $data['tujuan'];
        $tamu->save();

        return redirect()->route('tamus.index')->with('success', 'Data tamu berhasil diperbarui.');
    }

    // Delete tamu
    public function destroy($id)
    {
        $tamu = Tamu::findOrFail($id);
        $tamu->delete();

        return redirect()->route('tamus.index')->with('success', 'Data tamu berhasil dihapus.');
    }
}
