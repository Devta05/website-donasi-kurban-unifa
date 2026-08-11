<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Donasi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 4px; }
        p.subtitle { text-align: center; margin-top: 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #999; padding: 6px 8px; text-align: left; }
        th { background-color: #0d6efd; color: #fff; }
        tfoot td { font-weight: bold; background-color: #f1f8f4; }
    </style>
</head>
<body>
    <h2>Laporan Data Donasi</h2>
    <p class="subtitle">
        Masjid Al-Fajri UNIFA &bull; Dicetak pada {{ now()->translatedFormat('d F Y H:i') }}
        @if ($tanggalMulai && $tanggalAkhir)
            <br>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th><th>Kode</th><th>Nama</th><th>Jenis</th><th>Nominal</th><th>Tanggal</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($donasi as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->kode_transaksi }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenisDonasi->nama }}</td>
                    <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td>{{ str_replace('_', ' ', ucfirst($item->status)) }}</td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
        @if ($donasi->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:right;">Total Donasi Terverifikasi:</td>
                    <td colspan="3">Rp {{ number_format($totalDana, 0, ',', '.') }} ({{ $jumlahTerverifikasi }} transaksi)</td>
                </tr>
            </tfoot>
        @endif
    </table>
</body>
</html>