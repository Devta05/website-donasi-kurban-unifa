<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Kurban</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 4px; }
        p.subtitle { text-align: center; margin-top: 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #999; padding: 6px 8px; text-align: left; }
        th { background-color: #198754; color: #fff; }
    </style>
</head>
<body>
    <h2>Laporan Data Kurban</h2>
    <p class="subtitle">
        Masjid Al-Fajri UNIFA &bull; Dicetak pada {{ now()->timezone('Asia/Makassar')->translatedFormat('d F Y H:i') }}
        @if ($tanggalMulai && $tanggalAkhir)
            <br>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th><th>Kode</th><th>Nama</th><th>Paket</th><th>Slot</th><th>Nominal</th><th>Tanggal</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kurban as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->kode_transaksi }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->paketKurban->nama_paket ?? $item->nama_paket_snapshot ?? 'Paket telah dihapus' }}</td>
                    <td>{{ $item->slotSapi ? '#'.$item->slotSapi->nomor_slot : '-' }}</td>
                    <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td>{{ str_replace('_', ' ', ucfirst($item->status)) }}</td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>