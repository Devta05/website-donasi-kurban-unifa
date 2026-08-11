@extends('layouts.admin')

@section('title', 'Kelola Paket Kurban')

@section('content')
<div class="card card-modern p-4">
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-brand-blue" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-circle"></i> Tambah Paket</button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>Jenis Hewan</th><th>Nama Paket</th><th>Harga</th><th>Pendaftar</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse ($paketKurban as $item)
                    <tr>
                        <td class="text-capitalize">{{ $item->jenis_hewan }}</td>
                        <td>{{ $item->nama_paket }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->kurban_count }}</td>
                        <td><span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td>
                            @if ($item->jenis_hewan === 'sapi')
                                <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalSlot{{ $item->id }}"><i class="bi bi-grid-3x3-gap"></i> Kelola Slot</button>
                            @endif
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}"><i class="bi bi-pencil"></i></button>
                            <form action="{{ route('admin.paket-kurban.destroy', $item) }}" method="POST" class="d-inline btn-delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada paket kurban.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $paketKurban->links() }}</div>
</div>

{{-- Modal Kelola Slot (khusus paket Sapi) --}}
@foreach ($paketKurban as $item)
    @if ($item->jenis_hewan === 'sapi')
        <div class="modal fade" id="modalSlot{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">Kelola Slot - {{ $item->nama_paket }}</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small">
                            <i class="bi bi-info-circle"></i> Reset slot akan mengosongkan slot agar bisa dipilih pendaftar lain.
                            Jika slot ini masih terhubung dengan data kurban yang belum ditolak, data tersebut akan otomatis
                            ditandai "Ditolak" supaya data tidak bentrok.
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            @forelse ($item->slotSapi->sortBy('nomor_slot') as $slot)
                                <div class="text-center">
                                    <div class="border rounded-3 p-3 mb-1 {{ $slot->status === 'terisi' ? 'bg-danger text-white' : 'bg-light' }}" style="width:90px;">
                                        <div class="fw-bold">Slot {{ $slot->nomor_slot }}</div>
                                        <small>{{ $slot->status === 'terisi' ? 'Terisi' : 'Kosong' }}</small>
                                    </div>
                                    @if ($slot->status === 'terisi')
                                        <form action="{{ route('admin.slot-sapi.reset', $slot) }}" method="POST" class="form-reset-slot">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-secondary w-100">Reset</button>
                                        </form>
                                    @endif
                                </div>
                            @empty
                                <p class="text-muted">Belum ada slot untuk paket ini.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

{{-- Modal Edit Paket --}}
@foreach ($paketKurban as $item)
    <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.paket-kurban.update', $item) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header"><h6 class="modal-title">Edit Paket Kurban</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Jenis Hewan</label>
                            <select name="jenis_hewan" class="form-select" required>
                                <option value="sapi" {{ $item->jenis_hewan=='sapi'?'selected':'' }}>Sapi</option>
                                <option value="kambing" {{ $item->jenis_hewan=='kambing'?'selected':'' }}>Kambing</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Paket</label>
                            <input type="text" name="nama_paket" value="{{ $item->nama_paket }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="text" inputmode="numeric" class="form-control input-harga" value="{{ number_format($item->harga, 0, ',', '.') }}" required>
                            <input type="hidden" name="harga" class="hidden-harga" value="{{ $item->harga }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control">{{ $item->deskripsi }}</textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="activeP{{ $item->id }}" {{ $item->is_active?'checked':'' }}>
                            <label class="form-check-label" for="activeP{{ $item->id }}">Aktif</label>
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

{{-- Modal Tambah Paket --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.paket-kurban.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h6 class="modal-title">Tambah Paket Kurban</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jenis Hewan</label>
                        <select name="jenis_hewan" class="form-select" required>
                            <option value="sapi">Sapi</option>
                            <option value="kambing">Kambing</option>
                        </select>
                        <small class="text-muted">Jika Sapi, 7 slot akan otomatis dibuat.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Paket</label>
                        <input type="text" name="nama_paket" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="text" inputmode="numeric" class="form-control input-harga" placeholder="Contoh: 2.800.000" required>
                        <input type="hidden" name="harga" class="hidden-harga">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="activePNew" checked>
                        <label class="form-check-label" for="activePNew">Aktif</label>
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

        document.querySelectorAll('.form-reset-slot').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Reset slot ini?',
                    html: 'Jika slot ini masih terhubung dengan data kurban yang belum ditolak, data tersebut akan <strong>otomatis ditandai "Ditolak"</strong> agar data tetap sinkron.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, reset',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#dc3545',
                }).then(function (res) { if (res.isConfirmed) form.submit(); });
            });
        });

        document.querySelectorAll('.input-harga').forEach(function (input) {
            input.addEventListener('input', function () {
                let angka = this.value.replace(/\D/g, '');
                const hidden = this.closest('form').querySelector('.hidden-harga');
                if (hidden) hidden.value = angka;
                this.value = angka ? new Intl.NumberFormat('id-ID').format(angka) : '';
            });
        });
    });
</script>
@endpush