@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card card-modern p-4">
            <i class="bi bi-cash-coin text-primary fs-2"></i>
            <h5 class="fw-bold mt-2 mb-0">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</h5>
            <p class="text-muted small mb-0">Total Donasi</p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-modern p-4">
            <i class="bi bi-flower1 text-success fs-2"></i>
            <h5 class="fw-bold mt-2 mb-0">{{ $totalKurban }}</h5>
            <p class="text-muted small mb-0">Total Kurban</p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-modern p-4">
            <i class="bi bi-people text-primary fs-2"></i>
            <h5 class="fw-bold mt-2 mb-0">{{ $totalDonatur }}</h5>
            <p class="text-muted small mb-0">Total Donatur</p>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-modern p-4">
            <i class="bi bi-newspaper text-success fs-2"></i>
            <h5 class="fw-bold mt-2 mb-0">{{ $totalBerita }}</h5>
            <p class="text-muted small mb-0">Total Berita</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-modern p-4 border-start border-4 border-warning">
            <i class="bi bi-hourglass-split text-warning fs-2"></i>
            <h5 class="fw-bold mt-2 mb-0">{{ $donasiMenunggu }}</h5>
            <p class="text-muted small mb-0">Donasi Menunggu Verifikasi</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-modern p-4 border-start border-4 border-warning">
            <i class="bi bi-hourglass-split text-warning fs-2"></i>
            <h5 class="fw-bold mt-2 mb-0">{{ $kurbanMenunggu }}</h5>
            <p class="text-muted small mb-0">Kurban Menunggu Verifikasi</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card card-modern p-4">
            <h6 class="fw-semibold mb-3">Donasi Terbaru</h6>
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead><tr><th>Kode</th><th>Nama</th><th>Nominal</th><th>Waktu</th><th>Status</th></tr></thead>
<tbody>
    @forelse ($donasiTerbaru as $d)
        <tr>
            <td class="small">{{ $d->kode_transaksi }}</td>
            <td class="small">{{ $d->nama }}</td>
            <td class="small">Rp {{ number_format($d->nominal, 0, ',', '.') }}</td>
            <td class="small">{{ $d->created_at->timezone('Asia/Makassar')->format('d/m/Y H:i') }}</td>
            <td><span class="badge badge-status-{{ $d->status }}">{{ str_replace('_',' ',$d->status) }}</span></td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center text-muted">Belum ada data.</td></tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-modern p-4">
            <h6 class="fw-semibold mb-3">Kurban Terbaru</h6>
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead><tr><th>Kode</th><th>Nama</th><th>Paket</th><th>Waktu</th><th>Status</th></tr></thead>
<tbody>
    @forelse ($kurbanTerbaru as $k)
        <tr>
            <td class="small">{{ $k->kode_transaksi }}</td>
            <td class="small">{{ $k->nama }}</td>
            <td class="small">{{ $k->paketKurban->nama_paket ?? $k->nama_paket_snapshot ?? 'Paket dihapus' }}</td>
            <td class="small">{{ $k->created_at->timezone('Asia/Makassar')->format('d/m/Y H:i') }}</td>
            <td><span class="badge badge-status-{{ $k->status }}">{{ str_replace('_',' ',$k->status) }}</span></td>
        </tr>
    @empty
        <tr><td colspan="5" class="text-center text-muted">Belum ada data.</td></tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
