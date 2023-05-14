<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class DosenPembimbing extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'dosen_pembimbing';

    protected $with = ['mahasiswa'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // mahasiswa
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
