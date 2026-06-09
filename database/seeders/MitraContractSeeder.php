<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MitraApplication;
use App\Models\Contract;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MitraContractSeeder extends Seeder
{
    public function run(): void
    {
        $mitraNames = [
            'Supplier Deterjen Utama', 'Distributor Plastik Jaya', 'Supplier Pewangi Harum',
            'Distributor Mesin Cuci', 'Supplier Hanger Plastik', 'Distributor Alat Tulis',
            'Supplier Gas LPG', 'Distributor Seragam Staff', 'Supplier Keranjang Laundry',
            'Distributor Meja Setrika', 'Supplier Tag Penanda', 'Distributor Cairan Pembersih',
            'Supplier Sparepart Mesin', 'Distributor Rak Laundry', 'Supplier Timbangan Digital'
        ];

        foreach ($mitraNames as $index => $name) {
            $i = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
            
            // 1. Create User
            $user = User::create([
                'name' => $name,
                'email' => "mitra{$i}@laundrypay.test",
                'password' => Hash::make('password'),
                'role' => 'mitra',
            ]);

            // 2. Create Mitra Application
            $application = MitraApplication::create([
                'user_id' => $user->id,
                'nama_mitra' => $name,
                'jenis_mitra' => ($index % 2 == 0) ? 'supplier' : 'distributor',
                'produk_mitra' => 'Produk Perlengkapan Laundry ' . ($index + 1),
                'durasi_mitra' => '12 Bulan',
                'kewajiban_mitra' => "1. Menyediakan barang tepat waktu\n2. Menjamin kualitas produk\n3. Memberikan harga kompetitif.",
                'kewajiban_pemilik' => "1. Melakukan pembayaran tepat waktu\n2. Memberikan laporan kebutuhan barang.",
                'status' => 'approved',
            ]);

            // 3. Create Contract
            Contract::create([
                'mitra_application_id' => $application->id,
                'contract_number' => "LND-2026-DK{$i}",
                'content' => "Kontrak Kerjasama Kemitraan antara LaundryPay dan {$name} untuk pengadaan perlengkapan laundry.",
                'issued_at' => now(),
                'contract_value' => 0, // Nilai kontrak kerjasama mitra
                'status' => 'active',
            ]);
        }
    }
}
