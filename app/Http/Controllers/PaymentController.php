<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Project $project)
    {
        abort_if($project->user_id !== request()->user()->id || ! in_array($project->status, ['waiting_payment', 'approved'], true), 403);

        return view('payments.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        abort_if($project->user_id !== $request->user()->id || ! in_array($project->status, ['waiting_payment', 'approved'], true), 403);

        $remaining = $project->remainingAmount();
        $data = $request->validate([
            'method' => ['required', 'in:cash,debit,credit,qris,digital,bank_transfer'],
            'amount' => ['required', 'numeric', 'min:10000', 'max:'.$remaining],
            'reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $payment = Payment::create($data + [
            'project_id' => $project->id,
            'user_id' => $request->user()->id,
            'invoice_number' => 'INV-'.now()->format('Ymd').'-'.$project->id.'-'.random_int(100, 999),
            'status' => in_array($data['method'], ['cash', 'debit', 'credit'], true) ? 'pending' : 'pending',
            'qris_image' => $data['method'] === 'qris' ? 'images/qris.jpeg' : null,
        ]);

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'payment_created',
            'subject_type' => Payment::class,
            'subject_id' => $payment->id,
        ]);

        return redirect()->route('projects.show', $project)->with('status', 'Invoice pembayaran berhasil dibuat.');
    }

    public function markPaid(Payment $payment)
    {
        abort_unless(request()->user()->isAdmin() || request()->user()->isStaff(), 403);

        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        if ($payment->project->status === 'waiting_payment') {
            $payment->project->update(['status' => 'approved']);
        }

        return back()->with('status', 'Pembayaran ditandai lunas.');
    }
}
