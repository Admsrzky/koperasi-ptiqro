<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: auto;
            border: 1px solid #000;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }
        .table th {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .table td {
            vertical-align: top;
        }
        .table .total {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .footer {
            text-align: right;
            font-size: 12px;
            margin-top: 20px;
        }
        .company-info {
            text-align: left;
            font-size: 14px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Slip Gaji Karyawan</h1>
            <p>PT. IQRO LAUTAN PENA</p>
            <p>Periode: {{ $penggajian->periode }}</p>
        </div>

        <div class="company-info">
            <p><strong>Nama Karyawan:</strong> {{ $penggajian->karyawan->nama }}</p>
            <p><strong>NIP:</strong> {{ $penggajian->karyawan->nip }}</p>
        </div>

        <table class="table">
            <tr>
                <th>Rincian</th>
                <th>Jumlah</th>
            </tr>
            <tr>
                <td>Gaji Pokok</td>
                <td>Rp {{ number_format($penggajian->gaji_pokok, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tunjangan</td>
                <td>Rp {{ number_format($penggajian->tunjangan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Lembur</td>
                <td>Rp {{ number_format($penggajian->lembur, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Bonus</td>
                <td>Rp {{ number_format($penggajian->bonus, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Potongan Pinjaman</td>
                <td>Rp {{ number_format($penggajian->potongan_pinjaman, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Potongan Lain</td>
                <td>Rp {{ number_format($penggajian->potongan_lain, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td>Total Gaji</td>
                <td>Rp {{ number_format($penggajian->total_gaji, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Dicetak pada: {{ now()->format('d-m-Y') }}</p>
            <p>Disetujui oleh,</p>
            <p style="margin-top: 50px;">______________________</p>
            <p>Manajer Keuangan</p>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>