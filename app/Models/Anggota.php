<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = ['nomor_induk', 'nama', 'peran'];

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}