<?php

namespace App\Models;

use App\Traits\Acessor\ConverDateToIndonesia;
use App\Traits\GenUid;
use Illuminate\Database\Eloquent\Model;

class JanjiTemu extends Model
{
    use GenUid, ConverDateToIndonesia;

    protected $fillabe = [
        'user_id',
        'poli_id',
        'tanggal_kunjungan',
        'nomor_antrian',
        'status_pasien',
        'status_penanganan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');

    }
    public function dokter()
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id', 'id');
    }
}


