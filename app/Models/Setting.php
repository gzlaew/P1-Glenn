<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $incrementing = false;
    public $timestamps = true; // atau false jika tidak pakai created_at, updated_at
    protected $primaryKey = 'key';
    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
}
