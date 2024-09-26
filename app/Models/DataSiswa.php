<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataSiswa extends Model
{
    use HasFactory;

    protected $table = 'data_siswas';
    protected $fillable = ['nama', 'foto', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'pendidikan_terakhir', 'nama_ayah', 'nama_ibu', 'pekerjaan_orangtua', 'alamat', 'tanggal_masuk', 'tanggal_keluar', 'status', 'keterangan'];
    protected $guarded = ['created_at', 'updated_at'];

    // Aksesors untuk menggabungkan tempat lahir dan tanggal lahir
    public function getTempatTanggalLahirAttribute($value)
    {
        $tanggal = date('d F Y', strtotime($this->tanggal_lahir));
        return "{$this->tempat_lahir}, {$tanggal}";
    }
}
