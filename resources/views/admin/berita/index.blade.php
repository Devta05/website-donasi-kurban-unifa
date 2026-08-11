@extends('layouts.admin')

@section('title', 'Kelola Berita')

@section('content')
<div class="card card-modern p-4">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.berita.create') }}" class="btn btn-brand-blue"><i class="bi bi-plus-circle"></i> Tambah Berita</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>Gambar</th><th>Judul</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse ($berita as $item)
                    <tr>
                        <td style="width:90px;">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" style="width:70px; height:50px; object-fit:cover; border-radius:6px;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="width:70px; height:50px; border-radius:6px;"><i class="bi bi-image text-secondary"></i></div>
                            @endif
                        </td>
                        <td>{{ Str::limit($item->judul, 60) }}</td>
                        <td>
                            {{ $item->created_at->timezone('Asia/Makassar')->format('d/m/Y') }}
                            <div class="small text-muted">Diupload: {{ $item->created_at->timezone('Asia/Makassar')->format('H:i:s') }}</div>
                        </td>
                        <td>
                            <a href="{{ route('admin.berita.edit', $item) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.berita.destroy', $item) }}" method="POST" class="d-inline btn-delete">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada berita.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $berita->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.btn-delete').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({ title: 'Hapus berita ini?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal' })
                .then(res => { if (res.isConfirmed) form.submit(); });
        });
    });
</script>
@endpush
