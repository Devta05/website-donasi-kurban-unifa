@extends('layouts.admin')

@section('title', 'Kelola Jenis Donasi')

@section('content')
<div class="card card-modern p-4">
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-brand-blue" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-circle"></i> Tambah Jenis Donasi</button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>Nama</th><th>Deskripsi</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse ($jenisDonasi as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ Str::limit($item->deskripsi, 60) }}</td>
                        <td><span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}"><i class="bi bi-pencil"></i></button>
                            <form action="{{ route('admin.jenis-donasi.destroy', $item) }}" method="POST" class="d-inline btn-delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.jenis-donasi.update', $item) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header"><h6 class="modal-title">Edit Jenis Donasi</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="nama" value="{{ $item->nama }}" class="form-control" required></div>
                                        <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control">{{ $item->deskripsi }}</textarea></div>
                                        <div class="form-check">
                                            <input type="checkbox" name="is_active" value="1" class="form-check-input" id="active{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label" for="active{{ $item->id }}">Aktif</label>
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
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada jenis donasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $jenisDonasi->links() }}</div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.jenis-donasi.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h6 class="modal-title">Tambah Jenis Donasi</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="nama" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control"></textarea></div>
                    <div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="activeNew" checked><label class="form-check-label" for="activeNew">Aktif</label></div>
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
    document.querySelectorAll('.btn-delete').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({ title: 'Hapus data ini?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal' })
                .then(res => { if (res.isConfirmed) form.submit(); });
        });
    });
</script>
@endpush
