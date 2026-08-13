@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end mb-3 gap-2">
    <form method="GET" class="d-flex flex-wrap gap-2 align-items-end">
        <input type="hidden" name="jenis" value="{{ $jenis }}">
        <div>
            <label class="form-label small text-muted mb-1">Dari Tanggal</label>
            <input type="date" name="tanggal_mulai" value="{{ $tanggalMulai }}" class="form-control">
        </div>
        <div>
            <label class="form-label small text-muted mb-1">Sampai Tanggal</label>
            <input type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-brand-blue"><i class="bi bi-search"></i> Tampilkan</button>
        @if ($tanggalMulai || $tanggalAkhir)
            <a href="{{ route('admin.laporan-keuangan.index', ['jenis' => $jenis]) }}" class="btn btn-outline-secondary">Reset Tanggal</a>
        @endif
    </form>
    <div class="d-flex gap-2">
        <button class="btn btn-brand-green" data-bs-toggle="modal" data-bs-target="#modalTambahPengeluaran">
            <i class="bi bi-plus-circle"></i> Tambah Pengeluaran
        </button>
        <a href="{{ route('admin.laporan-keuangan.export-pdf', request()->query()) }}" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>
</div>

<div class="btn-group mb-4" role="group">
    <a href="{{ route('admin.laporan-keuangan.index', array_merge(request()->except('jenis'), ['jenis' => 'semua'])) }}"
       class="btn btn-sm {{ $jenis == 'semua' ? 'btn-brand-blue' : 'btn-outline-primary' }}">Semua</a>
    <a href="{{ route('admin.laporan-keuangan.index', array_merge(request()->except('jenis'), ['jenis' => 'pemasukan'])) }}"
       class="btn btn-sm {{ $jenis == 'pemasukan' ? 'btn-brand-blue' : 'btn-outline-primary' }}">Pemasukan</a>
    <a href="{{ route('admin.laporan-keuangan.index', array_merge(request()->except('jenis'), ['jenis' => 'pengeluaran'])) }}"
       class="btn btn-sm {{ $jenis == 'pengeluaran' ? 'btn-brand-blue' : 'btn-outline-primary' }}">Pengeluaran</a>
</div>

<div class="card card-modern p-4">
    <h6 class="fw-semibold mb-3">Laporan Keuangan</h6>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-success">
                <tr class="text-center">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
    @forelse ($riwayat as $i => $item)
        <tr>
            <td class="text-center">{{ $i + 1 }}</td>
            <td>
                {{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}
                <div class="small text-muted">
                        Diinput: {{ $item['waktu_input']->format('d/m/Y H:i:s') }}
                </div>
                @if ($item['diedit'])
                    <div class="small text-warning">
                        Diedit: {{ $item['waktu_edit']->format('d/m/Y H:i:s') }}
                    </div>
                @endif
            </td>
            <td>
                {{ $item['keterangan'] }}
            </td>
            <td class="text-end">{{ $item['debet'] > 0 ? number_format($item['debet'], 0, ',', '.') : '' }}</td>
            <td class="text-end">{{ $item['kredit'] > 0 ? number_format($item['kredit'], 0, ',', '.') : '' }}</td>
            <td class="text-end fw-semibold">{{ number_format($item['saldo'], 0, ',', '.') }}</td>
            <td class="text-center">
                @if ($item['tipe'] === 'pengeluaran')
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditPengeluaran{{ $item['id'] }}"><i class="bi bi-pencil"></i></button>
                    <form action="{{ route('admin.pengeluaran.destroy', $item['id']) }}" method="POST" class="d-inline btn-delete">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                @else
                    <span class="text-muted small">-</span>
                @endif
            </td>
        </tr>
    @empty
        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
    @endforelse
</tbody>
            @if ($riwayat->count() > 0)
                <tfoot class="table-success">
                    <tr class="fw-bold">
                        <td colspan="3" class="text-center">Jumlah</td>
                        <td class="text-end">{{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($saldo, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</div>

{{-- Modal edit diletakkan di LUAR tabel, bukan di dalam tbody --}}
@foreach ($pengeluaranList as $item)
    <div class="modal fade" id="modalEditPengeluaran{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.pengeluaran.update', $item) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="modal-header"><h6 class="modal-title">Edit Pengeluaran</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ $item->tanggal->format('Y-m-d') }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" value="{{ $item->kategori }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="text" inputmode="numeric" class="form-control input-jumlah" value="{{ number_format($item->jumlah, 0, ',', '.') }}" required>
                            <input type="hidden" name="jumlah" class="hidden-jumlah" value="{{ $item->jumlah }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control">{{ $item->keterangan }}</textarea>
                        </div>
                        @if ($item->bukti)
                            <a href="{{ asset('storage/' . $item->bukti) }}" target="_blank" class="d-block small mb-2">Lihat bukti saat ini</a>
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Ganti Bukti (opsional)</label>
                            <input type="file" name="bukti" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-brand-blue">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<div class="modal fade" id="modalTambahPengeluaran" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header"><h6 class="modal-title">Tambah Pengeluaran</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Contoh: Listrik, Air, Perawatan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="text" inputmode="numeric" class="form-control input-jumlah" placeholder="Contoh: 1.000.000" required>
                        <input type="hidden" name="jumlah" class="hidden-jumlah">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan (opsional)</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bukti (opsional)</label>
                        <input type="file" name="bukti" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-brand-blue">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({ title: 'Hapus data ini?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal' })
                    .then(function (res) { if (res.isConfirmed) form.submit(); });
            });
        });

        document.querySelectorAll('.input-jumlah').forEach(function (input) {
            input.addEventListener('input', function () {
                let angka = this.value.replace(/\D/g, '');
                const hidden = this.closest('form').querySelector('.hidden-jumlah');
                if (hidden) hidden.value = angka;
                this.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
            });
        });
    });
</script>
@endpush