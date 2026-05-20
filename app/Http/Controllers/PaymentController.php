<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Config;

class PaymentController extends Controller
{
    private function configureMidtrans(): void
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized');
        Config::$is3ds = (bool) config('services.midtrans.is_3ds');
    }
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
            'method' => ['required', 'in:midtrans,cash,debit,credit,qris,digital,bank_transfer'],
            'amount' => ['required', 'numeric', 'min:10000', 'max:'.$remaining],
            'reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
        if ($data['method'] !== 'midtrans') {
            $payment = Payment::create($data + [
                'project_id' => $project->id,
                'user_id' => $request->user()->id,
                'invoice_number' => 'INV-'.now()->format('Ymd').'-'.$project->id.'-'.random_int(100, 999),
                'status' => 'pending',
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
        $this->configureMidtrans();
        $payment = DB::transaction(function () use ($data, $project, $request) {
            $invoiceNumber = 'INV-'.now()->format('Ymd').'-'.$project->id.'-'.random_int(100, 999);
            $orderId = $invoiceNumber.'-MIDTRANS';
            $payment = Payment::create([
                'project_id' => $project->id,
                'user_id' => $request->user()->id,
                'invoice_number' => $invoiceNumber,
                'midtrans_order_id' => $orderId,
                'method' => 'midtrans',
                'amount' => $data['amount'],
                'status' => 'pending',
                'reference' => $data['reference'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $data['amount'],
                ],
                'customer_details' => [
                    'first_name' => $request->user()->name,
                    'email' => $request->user()->email,
                ],
                'item_details' => [
                    [
                        'id' => $project->project_code,
                        'price' => (int) $data['amount'],
                        'quantity' => 1,
                        'name' => 'Pembayaran '.$project->title,
                    ],
                ],
                'callbacks' => [
                    'finish' => route('projects.show', $project),
                ],
            ];
            $snapToken = Snap::getSnapToken($params);
            $payment->update([
                'snap_token' => $snapToken,
                'snap_redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/'.$snapToken,
            ]);
            AuditLog::create([
                'user_id' => $request->user()->id,
                'action' => 'midtrans_payment_created',
                'subject_type' => Payment::class,
                'subject_id' => $payment->id,
            ]);
            return $payment;
        });
    return redirect($payment->snap_redirect_url);
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

    public function notification(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');
        $expectedSignature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);
        if (! hash_equals($expectedSignature, $signatureKey)) {
            abort(403, 'Invalid signature.');
        }
        $payment = Payment::where('midtrans_order_id', $orderId)->firstOrFail();
        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');
        $status = match ($transactionStatus) {
            'capture' => $fraudStatus === 'challenge' ? 'pending' : 'paid',
            'settlement' => 'paid',
            'pending' => 'pending',
            'deny', 'cancel', 'expire' => 'failed',
            default => $payment->status,
        };
        $payment->update([
            'status' => $status,
            'paid_at' => $status === 'paid' ? now() : $payment->paid_at,
            'midtrans_transaction_id' => $request->input('transaction_id'),
            'midtrans_payment_type' => $request->input('payment_type'),
            'midtrans_transaction_status' => $transactionStatus,
            'midtrans_fraud_status' => $fraudStatus,
        ]);
        if ($status === 'paid' && $payment->project->status === 'waiting_payment') {
            $payment->project->update(['status' => 'approved']);
        }
        return response()->json([
            'message' => 'Notification processed.',
        ]);
    }
}
