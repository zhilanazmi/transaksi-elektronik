<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_mitra',
        'jenis_mitra',
        'produk_mitra',
        'durasi_mitra',
        'kewajiban_mitra',
        'kewajiban_pemilik',
        'status',
        'admin_notes',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }
}
