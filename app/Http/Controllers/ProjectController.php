<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    private const SERVICE_PRICES = [
        'Cuci kering' => 6000,
        'Cuci kering setrika' => 8000,
        'Setrika saja' => 5000,
        'Express cuci kering setrika' => 12000,
        'Bed cover' => 25000,
    ];

    public function index()
    {
        $projects = Project::with(['contract', 'payments'])
            ->where('user_id', request()->user()->id)
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create', [
            'servicePrices' => self::SERVICE_PRICES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'construction_type' => ['required', 'string', 'max:255', 'in:'.implode(',', array_keys(self::SERVICE_PRICES))],
            'location' => ['required', 'string', 'max:255'],
            'laundry_weight' => ['required', 'numeric', 'min:1', 'max:100'],
            'start_date' => ['nullable', 'date', 'after_or_equal:today'],
            'description' => ['required', 'string', 'min:20'],
        ]);

        // Proteksi XSS
        $data['title'] = strip_tags($data['title']);
        $data['location'] = strip_tags($data['location']);
        $data['description'] = strip_tags($data['description']);

        $data['service_price'] = self::SERVICE_PRICES[$data['construction_type']];
        $data['budget'] = $this->calculateLaundryTotal((float) $data['laundry_weight'], $data['service_price']);

        $project = Project::create($data + [
            'user_id' => $request->user()->id,
            'project_code' => 'PRJ-'.now()->format('Ymd').'-'.Str::upper(Str::random(5)),
            'status' => 'pending',
        ]);

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'project_submitted',
            'subject_type' => Project::class,
            'subject_id' => $project->id,
        ]);

        return redirect()->route('projects.show', $project)->with('status', 'Pengajuan pesanan laundry berhasil dikirim.');
    }

    public function show(Project $project)
    {
        if ($project->user_id !== request()->user()->id && ! request()->user()->isAdmin() && ! request()->user()->isStaff()) {
            AuditLog::create([
                'user_id' => request()->user()->id,
                'action' => 'unauthorized_project_access',
                'subject_type' => Project::class,
                'subject_id' => $project->id,
                'properties' => ['ip' => request()->ip()]
            ]);
            abort(403, 'Akses Ilegal Terdeteksi!');
        }

        PaymentController::syncProjectMidtransPayments($project);
        $project->load(['customer', 'approver', 'contract', 'payments.posTransaction']);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        abort_if($project->user_id !== request()->user()->id || $project->status !== 'pending', 403);

        return view('projects.edit', [
            'project' => $project,
            'servicePrices' => self::SERVICE_PRICES,
        ]);
    }

    public function update(Request $request, Project $project)
    {
        abort_if($project->user_id !== $request->user()->id || $project->status !== 'pending', 403);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'construction_type' => ['required', 'string', 'max:255', 'in:'.implode(',', array_keys(self::SERVICE_PRICES))],
            'location' => ['required', 'string', 'max:255'],
            'laundry_weight' => ['required', 'numeric', 'min:1', 'max:100'],
            'start_date' => ['nullable', 'date', 'after_or_equal:today'],
            'description' => ['required', 'string', 'min:20'],
        ]);

        $data['service_price'] = self::SERVICE_PRICES[$data['construction_type']];
        $data['budget'] = $this->calculateLaundryTotal((float) $data['laundry_weight'], $data['service_price']);

        $project->update($data);

        return redirect()->route('projects.show', $project)->with('status', 'Pengajuan pesanan laundry diperbarui.');
    }

    public function destroy(Project $project)
    {
        abort_if($project->user_id !== request()->user()->id || $project->status !== 'pending', 403);

        $project->delete();

        return redirect()->route('projects.index')->with('status', 'Pengajuan pesanan laundry dibatalkan.');
    }

    private function calculateLaundryTotal(float $weight, int $price): int
    {
        return (int) ceil($weight * $price);
    }
}
