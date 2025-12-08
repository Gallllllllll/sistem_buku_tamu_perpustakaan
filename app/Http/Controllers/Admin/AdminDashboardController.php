<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Gather dashboard data and support filters via query params
        $query = \App\Models\Tamu::query();

        // Filters from request
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

        $total_tamu = \App\Models\Tamu::count();
        $tamu_hari_ini = \App\Models\Tamu::whereDate('waktu_kedatangan', now()->toDateString())->count();
        $tujuan_list = \App\Models\Tamu::select('tujuan')->distinct()->pluck('tujuan');

        return view('tamus.index', compact('tamus', 'total_tamu', 'tamu_hari_ini', 'tujuan_list'));
    }
}
