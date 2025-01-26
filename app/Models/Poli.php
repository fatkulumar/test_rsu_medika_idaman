<?php

namespace App\Models;

use App\Traits\GenUid;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use GenUid;

    protected $fillable = [
        'name',
    ];
}
