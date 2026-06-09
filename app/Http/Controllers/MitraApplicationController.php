<?php

namespace App\Http\Controllers;

use App\Models\MitraApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MitraApplicationController extends Controller
{
    public function index()
    {
        $applications = Auth::user()->mitraApplications()->latest()->get();
        return view('mitra.applications.index', compact('applications'));
    }

    public function create()
    {
        return view('mitra.applications.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_mitra' => 'required|string|max:255',
            'jenis_mitra' => 'required|in:supplier,distributor',
            'produk_mitra' => 'required|string|max:255',
            'durasi_mitra' => 'required|string|max:255',
            'kewajiban_mitra' => 'required|string',
            'kewajiban_pemilik' => 'required|string',
        ]);

        // Proteksi XSS: Sanitasi input
        $data['kewajiban_mitra'] = strip_tags($data['kewajiban_mitra']);
        $data['kewajiban_pemilik'] = strip_tags($data['kewajiban_pemilik']);

        Auth::user()->mitraApplications()->create($data);

        return redirect()->route('mitra.applications.index')->with('success', 'Pengajuan mitra berhasil dikirim.');
    }

    public function show(MitraApplication $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        return view('mitra.applications.show', compact('application'));
    }
}
