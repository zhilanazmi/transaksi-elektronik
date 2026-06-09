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
            
            if ($project->user_id !== $user->id && ! $user->isAdmin() && ! $user->isStaff()) {
                \App\Models\AuditLog::create([
                    'user_id' => $user->id,
                    'action' => 'unauthorized_contract_access',
                    'subject_type' => Contract::class,
                    'subject_id' => $contract->id,
                    'properties' => ['ip' => request()->ip()]
                ]);
                abort(403, 'Anda tidak berhak mengakses dokumen ini.');
            }
            
            $pdf = Pdf::loadView('contracts.pdf', [
                'contract' => $contract,
                'project' => $project,
            ])->setPaper('a4');

            return $pdf->download('kontrak-'.$contract->contract_number.'.pdf');
        } else {
            $contract->load('mitraApplication.user');
            $application = $contract->mitraApplication;
            
            if ($application->user_id !== $user->id && ! $user->isAdmin()) {
                \App\Models\AuditLog::create([
                    'user_id' => $user->id,
                    'action' => 'unauthorized_mitra_contract_access',
                    'subject_type' => Contract::class,
                    'subject_id' => $contract->id,
                    'properties' => ['ip' => request()->ip()]
                ]);
                abort(403, 'Anda tidak berhak mengakses dokumen ini.');
            }

            // Jika ada file PDF fisik (hasil upload admin)
            if ($contract->pdf_path) {
                return response()->download(storage_path('app/public/' . $contract->pdf_path));
            }
            
            $pdf = Pdf::loadView('contracts.mitra-pdf', [
                'contract' => $contract,
                'application' => $application,
            ])->setPaper('a4');

            return $pdf->download('kontrak-'.$contract->contract_number.'.pdf');
        }
    }
}
