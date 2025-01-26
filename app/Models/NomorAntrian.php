<?php

namespace App\Models;

use App\Traits\GenUid;
use Illuminate\Database\Eloquent\Model;

class NomorAntrian extends Model
{
    use GenUid;

    protected $fillable = [
        'nomor',
    ];
}
