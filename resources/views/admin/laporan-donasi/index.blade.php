@extends('layouts.admin')

@section('title', 'Kelola Laporan Donasi')

@section('content')
<div class="card card-modern p-4">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.laporan-donasi.create') }}" class="btn btn-brand-blue"><i class="bi bi-plus-circle"></i> Tambah Laporan</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
    <thead><tr><th>Tanggal</th><th>Judul Laporan</th><th>Status Penyaluran</th><th>File</th><th>Aksi</th></tr></thead>
    <tbody>
        @forelse ($laporan as $item)
            <tr>
                <td>
                    {{ $item->tanggal->format('d/m/Y') }}
                    <div class="small text-muted">Diupload: {{ $item->created_at->timezone('Asia/Makassar')->format('H:i:s') }}</div>
                </td>
                <td>{{ $item->jenis_donasi }}</td>
                <td><span class="badge bg-success">{{ $item->status_penyaluran }}</span></td>
                <td>
                    @if ($item->file_laporan)
                        <a href="{{ asset('storage/' . $item->file_laporan) }}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="bi bi-file-earmark-pdf"></i> Lihat PDF</a>
                    @else
                        <span class="text-muted small">Belum ada file</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.laporan-donasi.edit', $item) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.laporan-donasi.destroy', $item) }}" method="POST" class="d-inline btn-delete">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada laporan donasi.</td></tr>
        @endforelse
    </tbody>
</table>
    </div>
    <div class="mt-3">{{ $laporan->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.btn-delete').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({ title: 'Hapus laporan ini?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal' })
                .then(res => { if (res.isConfirmed) form.submit(); });
        });
    });
</script>
@endpush
