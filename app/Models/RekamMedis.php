<?php

namespace App\Models;

use App\Traits\Acessor\ConverDateToIndonesia;
use App\Traits\GenUid;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use GenUid, ConverDateToIndonesia;
    protected $fillable = [
        'janji_temu_id',
        'user_id',
        'keluhan',
        'diagnosa',
        'tindakan',
        'obat',
        'keterangan',
        'nomor_antrian',
        'status_rawat',
        'nomor_rekam_medis',
    ];

    public function janjiTemu()
    {
        return $this->belongsTo(JanjiTemu::class, 'janji_temu_id', 'id');
    }
}
