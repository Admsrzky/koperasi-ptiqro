<!DOCTYPE html>
<html>
<head>
    <title>Cetak Pengajuan Kasbon - {{ $peminjaman->nomor_pengajuan }}</title>
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <style>
        @page {
            size: A4;
            margin: 2cm 1.5cm;
        }
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            line-height: 1.4;
            color: black;
            font-size: 12px;
        }
        .container {
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 0;
        }
        .letterhead {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
            text-transform: uppercase;
        }
        .company-address {
            font-size: 10px;
            margin-bottom: 5px;
        }
        .document-title {
            text-align: center;
            margin: 15px 0 10px 0;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
        }
        .document-number {
            text-align: center;
            margin-bottom: 15px;
            font-weight: normal; /* Dibuat normal agar tidak terlalu tebal */
            font-size: 12px;
        }
        .content-section {
            margin: 10px 0;
        }
        .content-section p {
            margin: 5px 0;
            font-size: 12px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 12px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
            width: 35%;
        }
        .approval-section {
            margin-top: 20px;
        }
        .approval-text {
            text-align: justify;
            margin-bottom: 25px;
            font-size: 12px;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .signature-box {
            text-align: center;
            width: 45%;
            font-size: 12px;
        }
        .signature-space {
            height: 60px;
        }
        .signature-label {
            margin-bottom: 60px; /* Jarak untuk tanda tangan */
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .date-place {
            margin-bottom: 8px;
        }
        @media print {
            body { margin: 0; }
            .container { border: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="letterhead">
            <div class="company-name">PT. IQRO LAUTAN PENA</div>
            <div class="company-address">
                Alamat: Jl. Raya Anyer No.59, Kel. Gunungsugih Ciwandan - Cilegon - Banten<br>
                Telp: (0254)7960937 | Email: iqrolautanpenapt@yahoo.com
            </div>
        </div>

        <div class="document-title">
            Formulir Pengajuan Kasbon Karyawan
        </div>
        <div class="document-number">
            Nomor: {{ $peminjaman->nomor_pengajuan }}
        </div>

        <div class="content-section">
            <p>Dengan hormat,</p>
            <p>Bersama ini disampaikan pengajuan kasbon dengan rincian sebagai berikut:</p>

            <table class="table">
                <tr>
                    <th>Nama Lengkap Karyawan</th>
                    <td>{{ $peminjaman->karyawan->nama }}</td>
                </tr>
                <tr>
                    <th>Nomor Induk Pegawai (NIP)</th>
                    <td>{{ $peminjaman->karyawan->nip }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>{{ $peminjaman->karyawan->jabatan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Pinjaman</th>
                    <td><strong>Rp {{ number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <th>Tanggal Pengajuan</th>
                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pengajuan)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Keperluan/Tujuan Pinjaman</th>
                    <td>{{ $peminjaman->keperluan }}</td>
                </tr>
            </table>
        </div>

        <div class="approval-section">
            <div class="approval-text">
                Demikian pengajuan Kasbon ini dibuat dengan sebenar-benarnya untuk dapat diproses lebih lanjut sesuai dengan ketentuan yang berlaku di perusahaan.
            </div>

            <div class="signature-section">
                <div class="signature-box left">
                    <div class="date-place">Cilegon, {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengajuan)->translatedFormat('d F Y') }}</div>
                    <div class="signature-label">Yang Mengajukan,</div>
                    <div class="signature-name">{{ $peminjaman->karyawan->nama }}</div>
                    <div>Karyawan</div>
                </div>

                <div class="signature-box right">
                    <div class="date-place">Cilegon, {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengajuan)->translatedFormat('d F Y') }}</div>
                    <div class="signature-label">Menyetujui,</div>
                    <div class="signature-name">{{ $namaDirektur }}</div>
                    <div>Direktur Utama</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
