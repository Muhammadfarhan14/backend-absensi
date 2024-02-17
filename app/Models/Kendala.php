<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendala extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function komen()
    {
        return $this->hasMany(Komen::class);
    }


}
