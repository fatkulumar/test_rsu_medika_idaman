<?php

namespace App\Models;

use App\Traits\GenUid;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use GenUid;

    protected $fillable = [
        'user_id',
        'poli_id',
        'spesialisasi',
    ];

    function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id', 'id');
    }
}
