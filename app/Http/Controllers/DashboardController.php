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

        return view('dashboard', [
            'projects' => $projects->take(6)->get(),
            'totalProjects' => (clone $projects)->count(),
            'pendingProjects' => Project::when($user->role === 'customer', fn ($query) => $query->where('user_id', $user->id))->where('status', 'pending')->count(),
            'approvedProjects' => Project::when($user->role === 'customer', fn ($query) => $query->where('user_id', $user->id))->where('status', 'approved')->count(),
            'paidRevenue' => Payment::when($user->role === 'customer', fn ($query) => $query->where('user_id', $user->id))->where('status', 'paid')->sum('amount'),
        ]);
    }
}
