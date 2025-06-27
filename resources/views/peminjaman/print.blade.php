<!DOCTYPE html>
<html>
<head>
    <title>Cetak Pengajuan Peminjaman</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 800px; margin: auto; }
        .header { text-align: center; margin-bottom: 40px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Formulir Pengajuan Peminjaman</h2>
            <p>Nomor: {{ $peminjaman->nomor_pengajuan }}</p>
        </div>

        <table class="table">
            <tr>
                <th>Nama Karyawan</th>
                <td>{{ $peminjaman->karyawan->nama }}</td>
            </tr>
            <tr>
                <th>NIP</th>
                <td>{{ $peminjaman->karyawan->nip }}</td>
            </tr>
            <tr>
                <th>Jumlah Pinjaman</th>
                <td>Rp {{ number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Tanggal Pengajuan</th>
                <td>{{ $peminjaman->tanggal_pengajuan->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Keperluan</th>
                <td>{{ $peminjaman->keperluan }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($peminjaman->status) }}</td>
            </tr>
            <tr>
                <th>Catatan</th>
                <td>{{ $peminjaman->catatan ?: '-' }}</td>
            </tr>
        </table>

        <div class="mt-8 text-right">
            <p>Dicetak pada: {{ now()->format('d-m-Y') }}</p>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>