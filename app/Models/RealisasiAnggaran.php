<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiAnggaran extends Model
{
    protected $table = 'realisasi_anggarans';
    protected $fillable = [
        'tanggal_transaksi',
        'kode',
        'deskripsi',
        'anggaran',
        'realisasi',
        'selisih',
        'persentase'
    ];

    // Fungsi untuk menghitung selisih dan persentase secara otomatis
    public function hitungSelisihDanPersentase()
    {
        // Pastikan 'anggaran' dan 'realisasi' memiliki nilai sebelum perhitungan
        if (!empty($this->anggaran) && !empty($this->realisasi)) {
            // Hitung selisih
            $this->selisih = $this->realisasi - $this->anggaran;

            // Hitung persentase
            $this->persentase = ($this->realisasi / $this->anggaran) * 100;
        }
    }

    // Override metode save agar perhitungan dilakukan sebelum data disimpan
    public function save(array $options = [])
    {
        // Hitung selisih dan persentase sebelum menyimpan data
        $this->hitungSelisihDanPersentase();

        parent::save($options);
    }
}
