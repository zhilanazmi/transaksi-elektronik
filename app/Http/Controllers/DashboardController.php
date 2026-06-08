<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Project;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = request()->user();

        $projects = Project::with(['customer', 'payments'])->latest()->when(
            $user->role === 'customer',
            fn ($query) => $query->where('user_id', $user->id)
        );

        $mitraApplications = $user->mitraApplications()->latest();

        return view('dashboard', [
            'projects' => $user->role === 'mitra' ? collect() : $projects->take(6)->get(),
            'totalProjects' => $user->role === 'mitra' ? 0 : (clone $projects)->count(),
            'pendingProjects' => $user->role === 'mitra' ? 0 : Project::when($user->role === 'customer', fn ($query) => $query->where('user_id', $user->id))->where('status', 'pending')->count(),
            'waitingPaymentProjects' => $user->role === 'mitra' ? 0 : Project::when($user->role === 'customer', fn ($query) => $query->where('user_id', $user->id))->where('status', 'waiting_payment')->count(),
            'approvedProjects' => $user->role === 'mitra' ? 0 : Project::when($user->role === 'customer', fn ($query) => $query->where('user_id', $user->id))->where('status', 'approved')->count(),
            'paidRevenue' => $user->role === 'mitra' ? 0 : Payment::when($user->role === 'customer', fn ($query) => $query->where('user_id', $user->id))->where('status', 'paid')->sum('amount'),
            
            // Mitra Data
            'mitraApps' => $user->role === 'mitra' ? $mitraApplications->take(6)->get() : collect(),
            'totalMitraApps' => $user->role === 'mitra' ? $mitraApplications->count() : 0,
            'approvedMitraApps' => $user->role === 'mitra' ? (clone $mitraApplications)->where('status', 'approved')->count() : 0,
        ]);
    }
}
