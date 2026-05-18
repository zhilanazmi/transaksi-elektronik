<?php

namespace Database\Seeders;

use App\Models\Contract;
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
            'name' => 'Admin ConstructPay',
            'email' => 'admin@constructpay.test',
            'role' => 'admin',
            'phone' => '081200000001',
            'password' => Hash::make('password'),
        ]);

        $staff = User::factory()->create([
            'name' => 'Staff POS',
            'email' => 'staff@constructpay.test',
            'role' => 'staff',
            'phone' => '081200000002',
            'password' => Hash::make('password'),
        ]);

        $customer = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'customer@constructpay.test',
            'role' => 'customer',
            'phone' => '081200000003',
            'address' => 'Jl. Merdeka No. 17, Bandung',
            'password' => Hash::make('password'),
        ]);

        $project = Project::create([
            'user_id' => $customer->id,
            'approved_by' => $admin->id,
            'project_code' => 'PRJ-'.now()->format('Ymd').'-0001',
            'title' => 'Renovasi Ruko Dua Lantai',
            'construction_type' => 'Renovasi Komersial',
            'location' => 'Bandung',
            'budget' => 185000000,
            'start_date' => now()->addWeeks(2)->toDateString(),
            'description' => 'Renovasi fasad, struktur ringan, instalasi listrik, dan finishing interior ruko.',
            'status' => 'approved',
            'approved_at' => now(),
            'admin_notes' => 'Dokumen awal lengkap dan estimasi biaya disetujui.',
        ]);

        Contract::create([
            'project_id' => $project->id,
            'contract_number' => 'CTR-'.now()->format('Ymd').'-0001',
            'issued_at' => now()->toDateString(),
            'contract_value' => $project->budget,
            'content' => 'Kontrak pekerjaan konstruksi antara ConstructPay dan Budi Santoso untuk proyek Renovasi Ruko Dua Lantai dengan nilai Rp185.000.000.',
        ]);

        Payment::create([
            'project_id' => $project->id,
            'user_id' => $customer->id,
            'invoice_number' => 'INV-'.now()->format('Ymd').'-0001',
            'method' => 'qris',
            'amount' => 25000000,
            'status' => 'pending',
            'notes' => 'Down payment proyek. Upload gambar QRIS ke public/images/qris.png lalu set path saat implementasi final.',
        ]);
    }
}
