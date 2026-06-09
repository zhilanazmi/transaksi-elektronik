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

    public function uploadContract(Request $request, User $mitra)
    {
        $this->authorizeAdmin();
        
        $request->validate([
            'contract_pdf' => 'required|file|mimes:pdf|max:5120', // Hanya PDF, max 5MB
        ], [
            'contract_pdf.mimes' => 'Hanya file PDF yang diperbolehkan!',
        ]);

        $path = $request->file('contract_pdf')->store('contracts', 'public');

        // Cari atau buat pengajuan mitra dummy jika admin upload manual tanpa pengajuan
        $application = $mitra->mitraApplications()->where('status', 'approved')->first();
        
        if (!$application) {
            $application = $mitra->mitraApplications()->create([
                'nama_mitra' => $mitra->name,
                'jenis_mitra' => 'supplier',
                'produk_mitra' => 'Manual Upload',
                'durasi_mitra' => '12 Bulan',
                'kewajiban_mitra' => 'Sesuai dokumen terlampir',
                'kewajiban_pemilik' => 'Sesuai dokumen terlampir',
                'status' => 'approved',
                'approved_at' => now(),
            ]);
        }

        $application->contract()->create([
            'contract_number' => 'CTR-MANUAL-'.now()->format('YmdHis'),
            'issued_at' => now()->toDateString(),
            'contract_value' => 0,
            'status' => 'active',
            'content' => 'Kontrak diunggah manual oleh Admin.',
            'pdf_path' => $path,
        ]);

        return back()->with('success', 'Kontrak PDF berhasil diunggah.');
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
