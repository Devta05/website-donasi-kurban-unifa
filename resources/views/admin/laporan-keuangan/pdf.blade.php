<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 4px; }
        p.subtitle { text-align: center; margin-top: 0; color: #555; }

        table.riwayat { width: 100%; border-collapse: collapse; margin-top: 16px; }
        table.riwayat th, table.riwayat td { border: 1px solid #999; padding: 6px 8px; text-align: left; }
        table.riwayat th { background-color: #0d6efd; color: #fff; }
        .text-end { text-align: right; }
    </style>
</head>
<body>
    <h2>Laporan Keuangan</h2>
    <p class="subtitle">
        Masjid Al-Fajri UNIFA &bull; Dicetak pada {{ now()->timezone('Asia/Makassar')->translatedFormat('d F Y H:i') }}
        <br>
        @if ($tanggalMulai && $tanggalAkhir)
            Dari Tanggal {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }} sampai {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}
        @else
            Belum ada data transaksi
        @endif
    </p>

    <table class="riwayat">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                @if ($jenis !== 'pengeluaran')
                    <th class="text-end">Debet</th>
                @endif
                @if ($jenis !== 'pemasukan')
                    <th class="text-end">Kredit</th>
                @endif
                <th class="text-end">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($riwayat as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}</td>
                    <td>{{ $item['keterangan'] }}</td>
                    @if ($jenis !== 'pengeluaran')
                        <td class="text-end">{{ $item['debet'] > 0 ? number_format($item['debet'], 0, ',', '.') : '' }}</td>
                    @endif
                    @if ($jenis !== 'pemasukan')
                        <td class="text-end">{{ $item['kredit'] > 0 ? number_format($item['kredit'], 0, ',', '.') : '' }}</td>
                    @endif
                    <td class="text-end">{{ number_format($item['saldo'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="{{ $jenis === 'semua' ? 6 : 5 }}" style="text-align:center;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
        @if ($riwayat->count() > 0)
            <tfoot>
                <tr style="font-weight:bold; background-color:#f1f8f4;">
                    <td colspan="3" style="text-align:center;">Jumlah</td>
                    @if ($jenis !== 'pengeluaran')
                        <td class="text-end">{{ number_format($totalDebet, 0, ',', '.') }}</td>
                    @endif
                    @if ($jenis !== 'pemasukan')
                        <td class="text-end">{{ number_format($totalKredit, 0, ',', '.') }}</td>
                    @endif
                    <td class="text-end">{{ number_format($saldoAkhir, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>
</body>
</html>