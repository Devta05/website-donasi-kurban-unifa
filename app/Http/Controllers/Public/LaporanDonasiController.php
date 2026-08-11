<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\LaporanDonasi;

class LaporanDonasiController extends Controller
{
    public function index()
    {
        $laporan = LaporanDonasi::latest('tanggal')->paginate(10);

        $totalDana = Donasi::where('status', 'terverifikasi')->sum('nominal');
        $jumlahDonasi = Donasi::where('status', 'terverifikasi')->count();

        return view('laporan.index', compact('laporan', 'totalDana', 'jumlahDonasi'));
    }
}