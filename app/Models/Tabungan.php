<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tabungan extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal_transaksi', 'kode', 'kategori_tabungan_id', 'jenis_transaksitabungan_id', 'keterangan', 'debet', 'kredit', 'saldo'];

    public function kategori_tabungan()
    {
        return $this->belongsTo(KategoriTabungan::class, 'kategori_tabungan_id', 'id');
    }

    public function jenis_transaksi_tabungan()
    {
        return $this->belongsTo(JenisTransaksiTabungan::class, 'jenis_transaksitabungan_id', 'id');
    }

    // Trigger untuk mengupdate saldo setiap kali debet atau kredit diisi
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ambil saldo dari data sebelumnya
            $saldo_sebelumnya = static::where('kategori_tabungan_id', $model->kategori_tabungan_id)
                ->latest('id')
                ->first();

            // Tentukan nilai saldo untuk data saat ini
            $model->saldo = $saldo_sebelumnya
                ? $saldo_sebelumnya->saldo + $model->debet - $model->kredit
                : $model->debet - $model->kredit;
        });
    }
}







//     public function indonesian_format_date($value)
//     {
//         return Carbon::parse($value)->format('d-m-Y');
//     }

//     public function indonesian_currency($value)
//     {
//         return number_format($value, 2, ', ', '.');
//     }
// }
