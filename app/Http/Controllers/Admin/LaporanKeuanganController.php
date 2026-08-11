<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->get('tanggal_mulai');
        $tanggalAkhir = $request->get('tanggal_akhir');
        $jenis = $request->get('jenis', 'semua');

        $data = $this->buildData($tanggalMulai, $tanggalAkhir);

        $riwayat = $data['riwayat'];
        if ($jenis === 'pemasukan') {
            $riwayat = $riwayat->where('tipe', 'donasi')->values();
        } elseif ($jenis === 'pengeluaran') {
            $riwayat = $riwayat->where('tipe', 'pengeluaran')->values();
        }

        return view('admin.laporan-keuangan.index', [
            'riwayat' => $riwayat,
            'totalPemasukan' => $data['totalPemasukan'],
            'totalPengeluaran' => $data['totalPengeluaran'],
            'saldo' => $data['saldo'],
            'pengeluaranList' => $data['pengeluaranList'],
            'tanggalMulai' => $tanggalMulai,
            'tanggalAkhir' => $tanggalAkhir,
            'jenis' => $jenis,
        ]);
    }

    public function exportPdf(Request $request)
{
    $tanggalMulai = $request->get('tanggal_mulai');
    $tanggalAkhir = $request->get('tanggal_akhir');
    $jenis = $request->get('jenis', 'semua');

    $data = $this->buildData($tanggalMulai, $tanggalAkhir);

    $riwayat = $data['riwayat'];
    if ($jenis === 'pemasukan') {
        $riwayat = $riwayat->where('tipe', 'donasi')->values();
    } elseif ($jenis === 'pengeluaran') {
        $riwayat = $riwayat->where('tipe', 'pengeluaran')->values();
    }

    if (! $tanggalMulai || ! $tanggalAkhir) {
        $semuaTanggal = $data['riwayat']->pluck('tanggal');
        $tanggalMulai = $semuaTanggal->min();
        $tanggalAkhir = $semuaTanggal->max();
    }

    $totalDebet = $riwayat->sum('debet');
    $totalKredit = $riwayat->sum('kredit');
    $saldoAkhir = $riwayat->isNotEmpty() ? $riwayat->last()['saldo'] : 0;

    $pdf = Pdf::loadView('admin.laporan-keuangan.pdf', [
        'riwayat' => $riwayat,
        'totalDebet' => $totalDebet,
        'totalKredit' => $totalKredit,
        'saldoAkhir' => $saldoAkhir,
        'tanggalMulai' => $tanggalMulai,
        'tanggalAkhir' => $tanggalAkhir,
        'jenis' => $jenis,
    ]);

    return $pdf->download('laporan-keuangan-' . now()->format('Ymd-His') . '.pdf');
}

    private function buildData(?string $tanggalMulai, ?string $tanggalAkhir): array
{
    $donasiQuery = Donasi::where('status', 'terverifikasi')->with('jenisDonasi');
    $pengeluaranQuery = Pengeluaran::query();

    if ($tanggalMulai && $tanggalAkhir) {
        $donasiQuery->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        $pengeluaranQuery->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
    }

    $totalPemasukan = (clone $donasiQuery)->sum('nominal');
    $pengeluaranList = $pengeluaranQuery->latest('tanggal')->get();
    $totalPengeluaran = $pengeluaranList->sum('jumlah');
    $saldoAkhir = $totalPemasukan - $totalPengeluaran;

    $pemasukan = $donasiQuery->get()->map(function ($item) {
        return [
            'tipe' => 'donasi',
            'id' => null,
            'tanggal' => $item->tanggal,
            'urutan' => $item->created_at->format('Y-m-d H:i:s'),
            'waktu_input' => $item->created_at->timezone('Asia/Makassar'),
            'diedit' => false,
            'waktu_edit' => null,
            'keterangan' => 'Donasi ' . ($item->jenisDonasi->nama ?? '-') . ' - ' . $item->nama,
            'debet' => (float) $item->nominal,
            'kredit' => 0,
        ];
    });

    $pengeluaran = $pengeluaranList->map(function ($item) {
        $sudahDiedit = $item->updated_at->ne($item->created_at);

        return [
            'tipe' => 'pengeluaran',
            'id' => $item->id,
            'tanggal' => $item->tanggal,
            'urutan' => $item->created_at->format('Y-m-d H:i:s'),
            'waktu_input' => $item->created_at->timezone('Asia/Makassar'),
            'diedit' => $sudahDiedit,
            'waktu_edit' => $sudahDiedit ? $item->updated_at->timezone('Asia/Makassar') : null,
            'keterangan' => $item->kategori . ($item->keterangan ? ' - ' . $item->keterangan : ''),
            'debet' => 0,
            'kredit' => (float) $item->jumlah,
        ];
    });

    $riwayat = $pemasukan->concat($pengeluaran)
        ->sortBy('urutan')
        ->values();

    $saldoBerjalan = 0;
    $riwayat = $riwayat->map(function ($item) use (&$saldoBerjalan) {
        $saldoBerjalan += $item['debet'] - $item['kredit'];
        $item['saldo'] = $saldoBerjalan;
        return $item;
    });

    return [
        'riwayat' => $riwayat,
        'totalPemasukan' => $totalPemasukan,
        'totalPengeluaran' => $totalPengeluaran,
        'saldo' => $saldoAkhir,
        'pengeluaranList' => $pengeluaranList,
    ];
}
}