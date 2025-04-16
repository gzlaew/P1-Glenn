<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members'; // <--- ini penting

    protected $primaryKey = 'id_member'; // <--- ini juga penting

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
        'password',
        'saldo',
        'tanggal_daftar',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
    ];
}
