<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pulang extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // class
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
