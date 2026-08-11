@extends('layouts.admin')

@section('title', 'Kelola Donasi')

@section('content')
<div class="card card-modern p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <form class="d-flex gap-2 flex-wrap align-items-center" method="GET">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama / kode / whatsapp" style="max-width:220px;">
        <select name="status" class="form-select" style="max-width:180px;">
            <option value="">-- Semua Status --</option>
            <option value="menunggu_verifikasi" {{ request('status')=='menunggu_verifikasi'?'selected':'' }}>Menunggu Verifikasi</option>
            <option value="terverifikasi" {{ request('status')=='terverifikasi'?'selected':'' }}>Terverifikasi</option>
            <option value="ditolak" {{ request('status')=='ditolak'?'selected':'' }}>Ditolak</option>
        </select>
        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control" style="max-width:160px;" title="Dari Tanggal">
        <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control" style="max-width:160px;" title="Sampai Tanggal">
        <button class="btn btn-outline-primary"><i class="bi bi-search"></i> Cari</button>
        @if (request('search') || request('status') || request('tanggal_mulai') || request('tanggal_akhir'))
            <a href="{{ route('admin.donasi.index') }}" class="btn btn-outline-secondary">Reset</a>
        @endif
    </form>
    <a href="{{ route('admin.donasi.export-pdf', request()->query()) }}" class="btn btn-brand-green">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>
</div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Kode</th><th>Nama</th><th>Jenis</th><th>Nominal</th><th>Tanggal</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($donasi as $item)
                    <tr>
                        <td>{{ $item->kode_transaksi }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jenisDonasi->nama }}</td>
                        <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td>
                            {{ $item->tanggal->format('d/m/Y') }}
                            <div class="small text-muted">{{ $item->created_at->timezone('Asia/Makassar')->format('H:i:s') }}</div>
                        </td>
                        <td><span class="badge badge-status-{{ $item->status }}">{{ str_replace('_',' ',$item->status) }}</span></td>
                        <td>
                            <a href="{{ route('admin.donasi.show', $item) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <form action="{{ route('admin.donasi.destroy', $item) }}" method="POST" class="d-inline btn-delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data donasi.</td></tr>
                @endforelse
            </tbody>
            @if ($donasi->count() > 0)
                <tfoot>
                    <tr class="table-light fw-bold">
                        <td colspan="3" class="text-end">Total Donasi Terverifikasi:</td>
                        <td colspan="2" class="text-success">Rp {{ number_format($totalDana, 0, ',', '.') }}</td>
                        <td colspan="2" class="text-muted fw-normal small">{{ $jumlahDonasi }} transaksi terverifikasi</td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
    <div class="mt-3">{{ $donasi->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.btn-delete').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus data ini?', text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal'
            }).then(res => { if (res.isConfirmed) form.submit(); });
        });
    });
</script>
@endpush