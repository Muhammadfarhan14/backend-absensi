<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaPenilaian extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'kriteria_penilian';

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

}
