<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'contract_number',
        'issued_at',
        'contract_value',
        'status',
        'content',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'date',
            'contract_value' => 'decimal:2',
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
