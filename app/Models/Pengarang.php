<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengarang extends Model
{
    protected $table = 'tb_pengarang';
    protected $primaryKey = 'id_pengarang';
    protected $fillable = ['nama_pengarang'];

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'id_pengarang');
    }
}
