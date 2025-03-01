<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komen extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function kendala()
    {
        return $this->belongsTo(Kendala::class);
    }

}
