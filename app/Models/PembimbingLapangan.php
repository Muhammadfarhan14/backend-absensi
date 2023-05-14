<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PembimbingLapangan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'pembimbing_lapangan';

    protected $with = ['mahasiswa'];

    public function user()
    {
        return $this->belongsTo(PembimbingLapangan::class);
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
