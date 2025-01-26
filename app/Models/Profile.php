<?php

namespace App\Models;

use App\Traits\GenUid;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use GenUid;

    protected $fillable = [
        'user_id',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'hp',
    ];
}
