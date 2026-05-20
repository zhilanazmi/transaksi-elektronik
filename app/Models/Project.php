<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'approved_by',
        'project_code',
        'title',
        'construction_type',
        'location',
        'laundry_weight',
        'service_price',
        'budget',
        'start_date',
        'description',
        'status',
        'approved_at',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'budget' => 'decimal:2',
            'laundry_weight' => 'decimal:2',
            'service_price' => 'integer',
            'start_date' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paidAmount(): float
    {
        return (float) $this->payments()->where('status', 'paid')->sum('amount');
    }

    public function remainingAmount(): float
    {
        return max(0, (float) $this->budget - $this->paidAmount());
    }
}
