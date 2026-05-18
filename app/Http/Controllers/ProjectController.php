<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
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
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'construction_type' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'budget' => ['required', 'numeric', 'min:1000000'],
            'start_date' => ['nullable', 'date', 'after_or_equal:today'],
            'description' => ['required', 'string', 'min:20'],
        ]);

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

        return redirect()->route('projects.show', $project)->with('status', 'Pengajuan proyek berhasil dikirim.');
    }

    public function show(Project $project)
    {
        abort_if($project->user_id !== request()->user()->id && ! request()->user()->isAdmin() && ! request()->user()->isStaff(), 403);

        $project->load(['customer', 'approver', 'contract', 'payments.posTransaction']);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        abort_if($project->user_id !== request()->user()->id || $project->status !== 'pending', 403);

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        abort_if($project->user_id !== $request->user()->id || $project->status !== 'pending', 403);

        $project->update($request->validate([
            'title' => ['required', 'string', 'max:255'],
            'construction_type' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'budget' => ['required', 'numeric', 'min:1000000'],
            'start_date' => ['nullable', 'date', 'after_or_equal:today'],
            'description' => ['required', 'string', 'min:20'],
        ]));

        return redirect()->route('projects.show', $project)->with('status', 'Pengajuan proyek diperbarui.');
    }

    public function destroy(Project $project)
    {
        abort_if($project->user_id !== request()->user()->id || $project->status !== 'pending', 403);

        $project->delete();

        return redirect()->route('projects.index')->with('status', 'Pengajuan proyek dibatalkan.');
    }
}
