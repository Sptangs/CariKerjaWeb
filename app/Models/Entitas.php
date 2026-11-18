<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entitas extends Model
{
    protected $table = 'entitas';

    protected $fillable = [
        'nama',
        'umur',
        'keahlian',
        'jenis_kelamin',
        'status_kerja',
    ];
}
