<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTransaksiTabungan extends Model
{
    use HasFactory;

    protected $table = 'jenis_transaksitabungans';
    protected $fillable = ['kode', 'nama'];

    protected $guarded = ['created_at', 'updated_at'];

    public function tabungans()
    {
        return $this->hasMany(Tabungan::class, 'jenis_transaksitabungan_id');
    }
}