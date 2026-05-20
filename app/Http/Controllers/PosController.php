<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PosTransaction;
use App\Models\Project;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        $this->authorizeAdminOrStaff();

        return view('pos.index', [
            'projects' => Project::with('customer')->whereIn('status', ['waiting_payment', 'approved'])->latest()->get(),
            'payments' => Payment::with(['project.customer', 'posTransaction'])->latest()->take(15)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeAdminOrStaff();

        $data = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'method' => ['required', 'in:cash,debit,credit,qris,digital,bank_transfer'],
            'amount' => ['required', 'numeric', 'min:10000'],
            'received_amount' => ['required', 'numeric', 'gte:amount'],
            'reference' => ['nullable', 'string', 'max:255'],
        ]);

        $project = Project::with('customer')->findOrFail($data['project_id']);
        abort_unless(in_array($project->status, ['waiting_payment', 'approved'], true), 422, 'Pesanan belum di-ACC admin.');
        abort_if($data['amount'] > $project->remainingAmount(), 422, 'Nominal melebihi sisa tagihan.');

        $payment = Payment::create([
            'project_id' => $project->id,
            'user_id' => $project->user_id,
            'invoice_number' => 'POS-'.now()->format('Ymd').'-'.$project->id.'-'.random_int(100, 999),
            'method' => $data['method'],
            'amount' => $data['amount'],
            'status' => 'paid',
            'reference' => $data['reference'] ?? null,
            'paid_at' => now(),
        ]);

        PosTransaction::create([
            'payment_id' => $payment->id,
            'cashier_id' => $request->user()->id,
            'received_amount' => $data['received_amount'],
            'change_amount' => $data['received_amount'] - $data['amount'],
            'terminal_name' => 'Main Counter',
        ]);

        if ($project->status === 'waiting_payment') {
            $project->update(['status' => 'approved']);
        }

        return redirect()->route('pos.index')->with('status', 'Transaksi POS berhasil dicatat.');
    }

    private function authorizeAdminOrStaff(): void
    {
        abort_unless(request()->user()->isAdmin() || request()->user()->isStaff(), 403);
    }
}
