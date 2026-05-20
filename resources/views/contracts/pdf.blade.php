<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Kontrak {{ $contract->contract_number }}</title>
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
    </style>
</head>
<body>
    <div class="header">
        <p class="brand">LAUNDRYPAY</p>
        <p class="subtitle">Sistem Transaksi Elektronik Jasa Laundry</p>
        <p class="subtitle">Jl. Laundry Digital No. 10, Bandung | admin@laundrypay.test</p>
    </div>

    <p class="title">Perjanjian Layanan Laundry</p>
    <p class="number">Nomor: {{ $contract->contract_number }}</p>

    <p class="article">
        Pada hari ini, {{ $contract->issued_at->translatedFormat('d F Y') }}, para pihak yang bertanda tangan di bawah ini sepakat untuk mengikatkan diri dalam Perjanjian Layanan Laundry dengan ketentuan sebagai berikut.
    </p>

    <p class="section-title">I. Para Pihak</p>
    <table class="meta">
        <tr><td>PIHAK PERTAMA</td><td>: LaundryPay, penyedia sistem dan pengelola layanan laundry.</td></tr>
        <tr><td>PIHAK KEDUA</td><td>: {{ $project->customer->name }}</td></tr>
        <tr><td>Email</td><td>: {{ $project->customer->email }}</td></tr>
        <tr><td>Telepon</td><td>: {{ $project->customer->phone ?? '-' }}</td></tr>
        <tr><td>Alamat</td><td>: {{ $project->customer->address ?? '-' }}</td></tr>
    </table>

    <p class="section-title">II. Data Pesanan</p>
    <table class="meta">
        <tr><td>Kode Pesanan</td><td>: {{ $project->project_code }}</td></tr>
        <tr><td>Nama Pesanan</td><td>: {{ $project->title }}</td></tr>
        <tr><td>Jenis Layanan</td><td>: {{ $project->construction_type }}</td></tr>
        <tr><td>Berat Cucian</td><td>: {{ number_format((float) ($project->laundry_weight ?? 0), 1, ',', '.') }} kg</td></tr>
        <tr><td>Harga Layanan</td><td>: Rp{{ number_format((int) ($project->service_price ?? 0), 0, ',', '.') }}/kg</td></tr>
        <tr><td>Alamat Pickup/Antar</td><td>: {{ $project->location }}</td></tr>
        <tr><td>Tanggal Pickup</td><td>: {{ $project->start_date ? $project->start_date->translatedFormat('d F Y') : '-' }}</td></tr>
        <tr><td>Nilai Layanan</td><td>: Rp{{ number_format($contract->contract_value, 0, ',', '.') }}</td></tr>
    </table>

    <p class="section-title">III. Ruang Lingkup Layanan</p>
    <p class="article">PIHAK PERTAMA melaksanakan layanan sesuai pengajuan pesanan yang telah disetujui melalui sistem LaundryPay, yaitu: {{ $project->description }}</p>

    <p class="section-title">IV. Ketentuan Pembayaran</p>
    <table class="terms">
        <tr><td>1</td><td>PIHAK KEDUA wajib melakukan pembayaran sesuai invoice yang diterbitkan oleh sistem LaundryPay.</td></tr>
        <tr><td>2</td><td>Metode pembayaran yang diakui meliputi cash, debit, kredit, QRIS, dompet digital, dan transfer bank.</td></tr>
        <tr><td>3</td><td>Pembayaran dinyatakan sah setelah status transaksi tercatat sebagai lunas pada sistem.</td></tr>
        <tr><td>4</td><td>Apabila pembayaran belum lunas, pekerjaan dapat dijadwalkan bertahap berdasarkan kebijakan admin.</td></tr>
    </table>

    <p class="section-title">V. Hak dan Kewajiban</p>
    <table class="terms">
        <tr><td>1</td><td>PIHAK PERTAMA wajib menyediakan pencatatan pesanan, kontrak, invoice, dan bukti pembayaran secara elektronik.</td></tr>
        <tr><td>2</td><td>PIHAK KEDUA wajib memberikan data pesanan dan detail cucian yang benar dan dapat dipertanggungjawabkan.</td></tr>
        <tr><td>3</td><td>Setiap perubahan ruang lingkup layanan wajib disetujui oleh kedua belah pihak.</td></tr>
        <tr><td>4</td><td>Perselisihan diselesaikan terlebih dahulu melalui musyawarah berdasarkan data transaksi pada sistem.</td></tr>
    </table>

    <p class="section-title">VI. Penutup</p>
    <p class="article">Perjanjian ini dibuat secara elektronik dan memiliki kekuatan pembuktian sebagai dokumen transaksi elektronik dalam lingkup tugas akademik. Dokumen ini sah setelah pesanan disetujui oleh admin LaundryPay.</p>

    <table class="signatures">
        <tr>
            <td>PIHAK PERTAMA<br><strong>LaundryPay</strong><div class="sign-space"></div><strong>Admin LaundryPay</strong></td>
            <td>PIHAK KEDUA<br><strong>{{ $project->customer->name }}</strong><div class="sign-space"></div><strong>{{ $project->customer->name }}</strong></td>
        </tr>
    </table>

    <p class="muted">Dicetak otomatis oleh LaundryPay pada {{ now()->translatedFormat('d F Y H:i') }}.</p>
</body>
</html>
