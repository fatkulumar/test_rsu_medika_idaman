<?php

namespace App\Models;

use App\Traits\GenUid;
use Illuminate\Database\Eloquent\Model;

class NomorAntrian extends Model
{
    protected $fillable = [
        'nomor',
    ];
}
