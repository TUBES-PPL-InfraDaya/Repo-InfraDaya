<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelurahan extends Model
{
    use HasFactory;

    protected $table = 'kelurahan';

    protected $fillable = [
        'kecamatan_id',
        'kode_kelurahan',
        'nama_kelurahan',
    ];

    /**
     * Relasi ke kecamatan induk.
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }
}
