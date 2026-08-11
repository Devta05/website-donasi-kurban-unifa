<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Donasi;
use App\Models\Kurban;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDonasi = Donasi::where('status', 'terverifikasi')->sum('nominal');
        $totalKurban = Kurban::where('status', 'terverifikasi')->count();
        $totalDonatur = Donasi::where('status', 'terverifikasi')->distinct('whatsapp')->count('whatsapp');
        $totalBerita = Berita::count();
        $donasiMenunggu = Donasi::where('status', 'menunggu_verifikasi')->count();
        $kurbanMenunggu = Kurban::where('status', 'menunggu_verifikasi')->count();

        // Grafik Donasi per Bulan (PostgreSQL: TO_CHAR)
        $grafikDonasi = Donasi::select(
                DB::raw("TO_CHAR(tanggal, 'YYYY-MM') as bulan"),
                DB::raw('SUM(nominal) as total')
            )
            ->where('status', 'terverifikasi')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Grafik Kurban per Tahun
        $grafikKurban = Kurban::select(
                DB::raw("TO_CHAR(tanggal, 'YYYY') as tahun"),
                DB::raw('COUNT(*) as total')
            )
            ->where('status', 'terverifikasi')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $donasiTerbaru = Donasi::with('jenisDonasi')->latest()->take(5)->get();
        $kurbanTerbaru = Kurban::with('paketKurban')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalDonasi', 'totalKurban', 'totalDonatur', 'totalBerita',
            'donasiMenunggu', 'kurbanMenunggu', 'grafikDonasi', 'grafikKurban',
            'donasiTerbaru', 'kurbanTerbaru'
        ));
    }
}
