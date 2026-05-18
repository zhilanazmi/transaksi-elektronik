<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Contract;
use App\Models\Project;
use Illuminate\Http\Request;

class AdminProjectController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();

        $projects = Project::with(['customer', 'contract'])
            ->latest()
            ->paginate(12);

        return view('admin.projects.index', compact('projects'));
    }

    public function approve(Request $request, Project $project)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $project->update([
            'status' => 'waiting_payment',
            'approved_by' => $request->user()->id,
            'approved_at' => now(),
            'admin_notes' => $data['admin_notes'] ?? null,
        ]);

        $project->contract()->firstOrCreate([], [
            'contract_number' => 'CTR-'.now()->format('Ymd').'-'.$project->id,
            'issued_at' => now()->toDateString(),
            'contract_value' => $project->budget,
            'content' => $this->contractContent($project->fresh(['customer'])),
        ]);

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'project_waiting_payment',
            'subject_type' => Project::class,
            'subject_id' => $project->id,
        ]);

        return back()->with('status', 'Proyek di-ACC, kontrak dibuat, dan status menunggu pembayaran.');
    }

    public function reject(Request $request, Project $project)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'admin_notes' => ['required', 'string', 'max:1000'],
        ]);

        $project->update([
            'status' => 'rejected',
            'approved_by' => $request->user()->id,
            'approved_at' => null,
            'admin_notes' => $data['admin_notes'],
        ]);

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'project_rejected',
            'subject_type' => Project::class,
            'subject_id' => $project->id,
        ]);

        return back()->with('status', 'Proyek ditolak.');
    }

    private function authorizeAdmin(): void
    {
        abort_unless(request()->user()->isAdmin(), 403);
    }

    private function contractContent(Project $project): string
    {
        return "Kontrak pekerjaan konstruksi antara ConstructPay dan {$project->customer->name} untuk proyek {$project->title} di {$project->location}. Nilai kontrak Rp".number_format((float) $project->budget, 0, ',', '.').". Pembayaran dapat dilakukan melalui cash, debit, kredit, QRIS, atau transfer digital. Pelaksanaan mengikuti spesifikasi pekerjaan dan validasi admin.";
    }
}
