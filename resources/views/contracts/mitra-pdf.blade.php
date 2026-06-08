<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kontrak Mitra {{ $contract->contract_number }}</title>
    <style>
        @page { margin: 34px 42px; }
        body { color: #111827; font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.55; }
        .header { border-bottom: 3px solid #111827; padding-bottom: 14px; text-align: center; }
        .brand { font-size: 22px; font-weight: 800; letter-spacing: 1px; margin: 0; }
        .subtitle { font-size: 11px; margin: 3px 0 0; }
        .title { font-size: 16px; font-weight: 800; margin: 26px 0 4px; text-align: center; text-decoration: underline; text-transform: uppercase; }
        .number { margin: 0 0 24px; text-align: center; }
        .section-title { font-weight: 800; margin: 18px 0 8px; text-transform: uppercase; }
        table { border-collapse: collapse; width: 100%; }
        .meta td { padding: 3px 0; vertical-align: top; }
        .meta td:first-child { width: 155px; }
        .article { margin: 0 0 10px; text-align: justify; }
        .terms td { border: 1px solid #d1d5db; padding: 8px; vertical-align: top; }
        .terms td:first-child { width: 32px; text-align: center; }
        .signatures { margin-top: 42px; }
        .signatures td { text-align: center; width: 50%; }
        .sign-space { height: 72px; }
        .muted { color: #4b5563; }
        .content-box { border: 1px solid #d1d5db; padding: 10px; white-space: pre-line; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <p class="brand">LAUNDRYPAY</p>
        <p class="subtitle">Sistem Transaksi Elektronik Jasa Laundry</p>
        <p class="subtitle">Jl. Laundry Digital No. 10, Bandung | admin@laundrypay.test</p>
    </div>

    <p class="title">Kontrak Kerjasama Kemitraan</p>
    <p class="number">Nomor: {{ $contract->contract_number }}</p>

    <p class="article">
        Pada hari ini, {{ $contract->issued_at->translatedFormat('d F Y') }}, para pihak yang bertanda tangan di bawah ini sepakat untuk menjalin kerjasama kemitraan dengan ketentuan sebagai berikut.
    </p>

    <p class="section-title">I. Para Pihak</p>
    <table class="meta">
        <tr><td>PIHAK PERTAMA</td><td>: LaundryPay, penyedia sistem dan pengelola layanan laundry.</td></tr>
        <tr><td>PIHAK KEDUA</td><td>: {{ $application->nama_mitra }}</td></tr>
        <tr><td>Perwakilan</td><td>: {{ $application->user->name }}</td></tr>
        <tr><td>Email</td><td>: {{ $application->user->email }}</td></tr>
        <tr><td>Telepon</td><td>: {{ $application->user->phone ?? '-' }}</td></tr>
    </table>

    <p class="section-title">II. Detail Kemitraan</p>
    <table class="meta">
        <tr><td>Jenis Mitra</td><td>: {{ ucfirst($application->jenis_mitra) }}</td></tr>
        <tr><td>Produk/Layanan</td><td>: {{ $application->produk_mitra }}</td></tr>
        <tr><td>Durasi Kerjasama</td><td>: {{ $application->durasi_mitra }}</td></tr>
        <tr><td>Tanggal Mulai</td><td>: {{ $application->approved_at ? $application->approved_at->translatedFormat('d F Y') : '-' }}</td></tr>
    </table>

    <p class="section-title">III. Kewajiban Mitra (Pihak Kedua)</p>
    <div class="content-box">
{{ $application->kewajiban_mitra }}
    </div>

    <p class="section-title">IV. Kewajiban Pemilik (Pihak Pertama)</p>
    <div class="content-box">
{{ $application->kewajiban_pemilik }}
    </div>

    <p class="section-title">V. Penutup</p>
    <p class="article">Perjanjian ini dibuat secara elektronik dan berlaku sebagai dokumen resmi kerjasama antara kedua belah pihak. Setiap perubahan dalam perjanjian ini harus disepakati secara tertulis oleh kedua belah pihak.</p>

    <table class="signatures">
        <tr>
            <td>PIHAK PERTAMA<br><strong>LaundryPay</strong><div class="sign-space"></div><strong>Admin LaundryPay</strong></td>
            <td>PIHAK KEDUA<br><strong>{{ $application->nama_mitra }}</strong><div class="sign-space"></div><strong>{{ $application->user->name }}</strong></td>
        </tr>
    </table>

    <p class="muted">Dicetak otomatis oleh LaundryPay pada {{ now()->translatedFormat('d F Y H:i') }}.</p>
</body>
</html>
