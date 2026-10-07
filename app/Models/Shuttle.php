<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shuttle extends Model
{
    //Mendaftarkan kolom yang boleh diisi
    protected $fillable = [
        'nama',
        'umur',
        'keahlian',
        'jenis_kelamin',
        'status_kerja',
    ];
}
// nama_armada
// kapasitas
//rute operasional
// status aktif
