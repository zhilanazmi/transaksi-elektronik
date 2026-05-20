<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin LaundryPay',
            'email' => 'admin@laundrypay.test',
            'role' => 'admin',
            'phone' => '081200000001',
            'password' => Hash::make('password'),
        ]);

        $staff = User::factory()->create([
            'name' => 'Staff POS',
            'email' => 'staff@laundrypay.test',
            'role' => 'staff',
            'phone' => '081200000002',
            'password' => Hash::make('password'),
        ]);

        $customer = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'customer@laundrypay.test',
            'role' => 'customer',
            'phone' => '081200000003',
            'address' => 'Jl. Merdeka No. 17, Bandung',
            'password' => Hash::make('password'),
        ]);

        $project = Project::create([
            'user_id' => $customer->id,
            'approved_by' => $admin->id,
            'project_code' => 'PRJ-'.now()->format('Ymd').'-0001',
            'title' => 'Laundry Kiloan Harian',
            'construction_type' => 'Cuci kering setrika',
            'location' => 'Jl. Merdeka No. 17, Bandung',
            'laundry_weight' => 5,
            'service_price' => 8000,
            'budget' => 40000,
            'start_date' => now()->addDay()->toDateString(),
            'description' => 'Cuci kering setrika untuk pakaian harian sekitar 5 kg dengan layanan pickup dan antar.',
            'status' => 'waiting_payment',
            'approved_at' => now(),
            'admin_notes' => 'Detail cucian lengkap dan estimasi biaya disetujui.',
        ]);

        Payment::create([
            'project_id' => $project->id,
            'user_id' => $customer->id,
            'invoice_number' => 'INV-'.now()->format('Ymd').'-0001',
            'method' => 'qris',
            'amount' => 40000,
            'status' => 'pending',
            'notes' => 'Pembayaran pesanan laundry. Upload gambar QRIS ke public/images/qris.png lalu set path saat implementasi final.',
        ]);
    }
}
