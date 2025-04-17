<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    protected $table = 'tb_penerbit';
    protected $primaryKey = 'id_penerbit';
    protected $fillable = ['nama_penerbit'];
    public $timestamps = true;
}
