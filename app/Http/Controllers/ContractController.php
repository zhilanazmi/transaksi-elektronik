<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{
    public function download(Contract $contract)
    {
        $user = request()->user();
        
        if ($contract->project_id) {
            $contract->load('project.customer');
            $project = $contract->project;
            abort_if($project->user_id !== $user->id && ! $user->isAdmin() && ! $user->isStaff(), 403);
            
            $pdf = Pdf::loadView('contracts.pdf', [
                'contract' => $contract,
                'project' => $project,
            ])->setPaper('a4');
        } else {
            $contract->load('mitraApplication.user');
            $application = $contract->mitraApplication;
            abort_if($application->user_id !== $user->id && ! $user->isAdmin(), 403);
            
            $pdf = Pdf::loadView('contracts.mitra-pdf', [
                'contract' => $contract,
                'application' => $application,
            ])->setPaper('a4');
        }

        return $pdf->download('kontrak-'.$contract->contract_number.'.pdf');
    }
}
