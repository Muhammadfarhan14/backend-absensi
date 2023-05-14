<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use  HasFactory;

    protected $guarded = ['id'];

    // kegiatan
    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class);
    }

    // kendala
    public function kendala()
    {
        return $this->hasOne(Kendala::class);
    }

    // datang
    public function datang()
    {
        return $this->hasOne(Datang::class);
    }

    // pulang
    public function pulang()
    {
        return $this->hasOne(Pulang::class);
    }

    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // lokasi
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    // pembimbing lapangan
    public function pembimbing_lapangan()
    {
        return $this->belongsTo(PembimbingLapangan::class);
    }

    // dosen pembimbing
    public function dosen_pembimbing()
    {
        return $this->belongsTo(DosenPembimbing::class);
    }
}
