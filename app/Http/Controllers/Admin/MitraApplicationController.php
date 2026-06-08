<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MitraApplication;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;

class MitraApplicationController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        $applications = MitraApplication::with('user')->latest()->paginate(10);
        return view('admin.mitra.index', compact('applications'));
    }

    public function partners()
    {
        $this->authorizeAdmin();
        $partners = User::where('role', 'mitra')->whereHas('mitraApplications', function($q) {
            $q->where('status', 'approved');
        })->paginate(10);
        return view('admin.mitra.partners', compact('partners'));
    }

    public function show(MitraApplication $application)
    {
        $this->authorizeAdmin();
        return view('admin.mitra.show', compact('application'));
    }

    public function approve(Request $request, MitraApplication $application)
    {
        $this->authorizeAdmin();
        
        $application->update([
            'status' => 'approved',
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        $this->createContract($application);

        return redirect()->route('admin.mitra.index')->with('success', 'Pengajuan mitra disetujui dan kontrak telah dibuat.');
    }

    public function reject(Request $request, MitraApplication $application)
    {
        $this->authorizeAdmin();
        
        $application->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.mitra.index')->with('success', 'Pengajuan mitra ditolak.');
    }

    private function createContract(MitraApplication $application)
    {
        $application->contract()->create([
            'contract_number' => 'CTR-MITRA-'.now()->format('Ymd').'-'.$application->id,
            'issued_at' => now()->toDateString(),
            'contract_value' => 0, // Nilai kontrak mitra bisa disesuaikan jika perlu
            'status' => 'active',
            'content' => $this->generateContractContent($application),
        ]);
    }

    private function generateContractContent(MitraApplication $application)
    {
        $content = "KONTRAK KERJASAMA MITRA\n\n";
        $content .= "Nama Mitra: {$application->nama_mitra}\n";
        $content .= "Jenis Mitra: " . ucfirst($application->jenis_mitra) . "\n";
        $content .= "Produk: {$application->produk_mitra}\n";
        $content .= "Durasi: {$application->durasi_mitra}\n\n";
        $content .= "KEWAJIBAN MITRA:\n{$application->kewajiban_mitra}\n\n";
        $content .= "KEWAJIBAN PEMILIK:\n{$application->kewajiban_pemilik}\n\n";
        $content .= "Kontrak ini berlaku sejak tanggal disetujui oleh Admin.";

        return $content;
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
    }
}
