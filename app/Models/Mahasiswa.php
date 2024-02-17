<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->hasMany(Kendala::class);
    }

    // datang
    public function datang()
    {
        return $this->hasMany(Datang::class);
    }

    // pulang
    public function pulang()
    {
        return $this->hasMany(Pulang::class);
    }

     // kriteria penilian
     public function kriteria_penilaian()
     {
         return $this->hasOne(KriteriaPenilaian::class);
     }

    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // lokasi
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class,'lokasi_id','id');
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
