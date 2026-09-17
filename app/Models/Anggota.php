<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = ['nomor_induk', 'nama', 'peran'];

    /**
     * Otomatis seragamkan nama menjadi Title Case (Huruf besar di setiap awal kata).
     * Contoh: "yonathan tobias buttok" atau "YONATHAN TOBIAS" -> "Yonathan Tobias Buttok"
     */
    protected function nama(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? ucwords(strtolower($value)) : $value,
            set: fn ($value) => $value ? ucwords(strtolower(preg_replace('/\s+/', ' ', trim($value)))) : $value,
        );
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}