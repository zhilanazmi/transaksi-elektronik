<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'invoice_number',
        'method',
        'amount',
        'status',
        'reference',
        'qris_image',
        'paid_at',
        'notes',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'midtrans_payment_type',
        'midtrans_transaction_status',
        'midtrans_fraud_status',
        'snap_token',
        'snap_redirect_url',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posTransaction()
    {
        return $this->hasOne(PosTransaction::class);
    }
}
