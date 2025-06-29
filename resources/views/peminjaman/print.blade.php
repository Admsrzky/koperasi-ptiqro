<!DOCTYPE html>
<html>
<head>
    <title>Cetak Pengajuan Peminjaman</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
            color: #333;
            font-size: 12px;
        }
        .container { 
            width: 100%;
            height: 100vh;
            max-width: none;
            margin: 0;
            padding: 15px;
            border: 2px solid #000;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
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
            font-weight: bold;
            font-size: 12px;
        }
        .content-section {
            margin: 10px 0;
            flex-grow: 1;
        }
        .content-section p {
            margin: 5px 0;
            font-size: 11px;
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 10px 0;
            font-size: 11px;
        }
        .table th, .table td { 
            border: 1px solid #000; 
            padding: 6px 8px; 
            text-align: left;
        }
        .table th { 
            background-color: #f8f8f8; 
            font-weight: bold;
            width: 35%;
        }
        .approval-section {
            margin-top: 15px;
        }
        .approval-text {
            text-align: justify;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .signature-box {
            text-align: center;
            width: 45%;
            font-size: 10px;
        }
        .signature-space {
            height: 60px;
            border-bottom: 1px solid #000;
            margin: 10px 0 5px 0;
        }
        .signature-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .date-place {
            margin-bottom: 8px;
            font-size: 10px;
        }
        .footer {
            margin-top: 15px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            font-size: 9px;
            color: #666;
        }
        .print-info {
            text-align: right;
            font-style: italic;
        }
        @media print {
            body { margin: 0; }
            .container { border: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Kop Surat -->
        <div class="letterhead">
            <div class="company-name">PT. IQRO LAUTAN PENA</div>
            <div class="company-address">
                Alamat: Cilegon - Serang<br>
                Telp: 08123456789 | Email: iqrolautanpena.co.id
            </div>
        </div>

        <!-- Judul Dokumen -->
        <div class="document-title">
            Formulir Pengajuan Peminjaman Karyawan
        </div>

        <div class="document-number">
            Nomor: {{ $peminjaman->nomor_pengajuan }}
        </div>

        <!-- Data Peminjaman -->
        <div class="content-section">
            <p>Dengan hormat,</p>
            <p>Bersama ini disampaikan pengajuan peminjaman dengan rincian sebagai berikut:</p>
            
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
                    <th>Departemen</th>
                    <td>{{ $peminjaman->karyawan->departemen ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Pinjaman</th>
                    <td><strong>Rp {{ number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <th>Tanggal Pengajuan</th>
                    <td>{{ $peminjaman->tanggal_pengajuan->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Keperluan/Tujuan Pinjaman</th>
                    <td>{{ $peminjaman->keperluan }}</td>
                </tr>
                <tr>
                    <th>Status Persetujuan</th>
                    <td><strong>{{ strtoupper($peminjaman->status) }}</strong></td>
                </tr>
                <tr>
                    <th>Catatan Tambahan</th>
                    <td>{{ $peminjaman->catatan ?: 'Tidak ada catatan khusus' }}</td>
                </tr>
            </table>
        </div>

        <!-- Bagian Persetujuan -->
        <div class="approval-section">
            <div class="approval-text">
                Demikian pengajuan peminjaman ini dibuat dengan sebenar-benarnya untuk dapat diproses lebih lanjut sesuai dengan ketentuan yang berlaku di perusahaan.
            </div>

            <!-- Tanda Tangan -->
            <div class="signature-section">
                <div class="signature-box left">
                    <div class="date-place">Cilegon, {{ now()->format('d F Y') }}</div>
                    <div class="signature-label">Yang Mengajukan,</div>
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $peminjaman->karyawan->nama }}</div>
                    <div>NIP: {{ $peminjaman->karyawan->nip }}</div>
                </div>

                <div class="signature-box right">
                    <div class="date-place">Cilegon, {{ now()->format('d F Y') }}</div>
                    <div class="signature-label">Mengetahui & Menyetujui,<br>Direktur Perusahaan</div>
                    <div class="signature-space"></div>
                    <div class="signature-name">{{ $namaDirektur ?? '(........................................)' }}</div>
                    <div>Direktur Utama</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="print-info">
                Dokumen ini dicetak pada: {{ now()->format('d F Y, H:i') }} WIB<br>
                <em>Dokumen ini sah tanpa tanda tangan basah jika telah disetujui melalui sistem</em>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>