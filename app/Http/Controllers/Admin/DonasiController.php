<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DonasiController extends Controller
{
    public function index(Request $request)
{
    $query = Donasi::with('jenisDonasi');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('kode_transaksi', 'like', "%{$search}%")
              ->orWhere('whatsapp', 'like', "%{$search}%");
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
        $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
    }

    $donasi = $query->latest()->paginate(10)->withQueryString();

    $totalQuery = Donasi::where('status', 'terverifikasi');
    if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
        $totalQuery->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
    }
    $totalDana = $totalQuery->sum('nominal');
    $jumlahDonasi = $totalQuery->count();

    return view('admin.donasi.index', compact('donasi', 'totalDana', 'jumlahDonasi'));
}

    public function show(Donasi $donasi)
    {
        return view('admin.donasi.show', compact('donasi'));
    }

    /**
     * Verifikasi pembayaran donasi -> status "terverifikasi".
     */
    public function verifikasi(Donasi $donasi)
    {
        $donasi->update(['status' => 'terverifikasi']);

        return back()->with('success', "Donasi {$donasi->kode_transaksi} berhasil diverifikasi.");
    }

    /**
     * Tolak pembayaran donasi -> status "ditolak".
     */
    public function tolak(Donasi $donasi)
    {
        $donasi->update(['status' => 'ditolak']);

        return back()->with('success', "Donasi {$donasi->kode_transaksi} ditolak.");
    }

    public function destroy(Donasi $donasi)
    {
        if ($donasi->bukti_pembayaran) {
            Storage::disk('public')->delete($donasi->bukti_pembayaran);
        }

        $donasi->delete();

        return back()->with('success', 'Data donasi berhasil dihapus.');
    }

    public function exportPdf(Request $request)
{
    $query = Donasi::with('jenisDonasi');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('kode_transaksi', 'like', "%{$search}%")
              ->orWhere('whatsapp', 'like', "%{$search}%");
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
        $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
    }

    $donasi = $query->latest()->get();

    $totalDana = $donasi->where('status', 'terverifikasi')->sum('nominal');
    $jumlahTerverifikasi = $donasi->where('status', 'terverifikasi')->count();

    $tanggalMulai = $request->tanggal_mulai;
    $tanggalAkhir = $request->tanggal_akhir;

    $pdf = Pdf::loadView('admin.donasi.pdf', compact(
        'donasi', 'totalDana', 'jumlahTerverifikasi', 'tanggalMulai', 'tanggalAkhir'
    ));

    return $pdf->download('laporan-donasi-' . now()->format('Ymd-His') . '.pdf');
}
}
