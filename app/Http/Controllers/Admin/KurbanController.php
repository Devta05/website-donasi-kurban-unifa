<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class KurbanController extends Controller
{
    public function index(Request $request)
{
    $query = Kurban::with(['paketKurban', 'slotSapi']);

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

    $kurban = $query->latest()->paginate(10)->withQueryString();

    return view('admin.kurban.index', compact('kurban'));
}

    public function show(Kurban $kurban)
    {
        return view('admin.kurban.show', compact('kurban'));
    }

    public function verifikasi(Kurban $kurban)
    {
        $kurban->update(['status' => 'terverifikasi']);

        return back()->with('success', "Kurban {$kurban->kode_transaksi} berhasil diverifikasi.");
    }

    public function tolak(Kurban $kurban)
    {
        $kurban->update(['status' => 'ditolak']);

        if ($kurban->slot_sapi_id) {
            $kurban->slotSapi()->update(['status' => 'kosong']);
        }

        return back()->with('success', "Kurban {$kurban->kode_transaksi} ditolak.");
    }

    public function exportPdf(Request $request)
{
    $query = Kurban::with(['paketKurban', 'slotSapi']);

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

    $kurban = $query->latest()->get();

    $tanggalMulai = $request->tanggal_mulai;
    $tanggalAkhir = $request->tanggal_akhir;

    $pdf = Pdf::loadView('admin.kurban.pdf', compact('kurban', 'tanggalMulai', 'tanggalAkhir'));

    return $pdf->download('laporan-kurban-' . now()->format('Ymd-His') . '.pdf');
}

    public function destroy(Kurban $kurban)
    {
        if ($kurban->slot_sapi_id) {
            $kurban->slotSapi()->update(['status' => 'kosong']);
        }

        if ($kurban->bukti_pembayaran) {
            Storage::disk('public')->delete($kurban->bukti_pembayaran);
        }

        $kurban->delete();

        return back()->with('success', 'Data kurban berhasil dihapus.');
    }
}
