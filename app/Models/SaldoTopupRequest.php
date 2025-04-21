<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaldoTopupRequest extends Model
{
    use HasFactory;

    protected $table = 'tb_saldo_topup_requests';

    protected $fillable = [
        'user_id',
        'jumlah',
        'status',
        'bukti_transfer',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
