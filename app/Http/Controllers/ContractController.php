<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractController extends Controller
{
    public function download(Contract $contract)
    {
        $contract->load('project.customer');
        $project = $contract->project;
        $user = request()->user();

        abort_if($project->user_id !== $user->id && ! $user->isAdmin() && ! $user->isStaff(), 403);

        $pdf = Pdf::loadView('contracts.pdf', [
            'contract' => $contract,
            'project' => $project,
        ])->setPaper('a4');

        return $pdf->download('kontrak-'.$contract->contract_number.'.pdf');
    }
}
