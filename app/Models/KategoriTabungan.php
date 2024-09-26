<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriTabungan extends Model
{
    use HasFactory;

    protected $table = 'kategori_tabungans';
    protected $fillable = ['kode', 'nama'];
    protected $guarded = ['created_at', 'updated_at'];

    public function tabungans()
    {
        return $this->hasMany(Tabungan::class, 'kategori_tabungan_id');
    }
}