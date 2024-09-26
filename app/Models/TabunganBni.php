<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabunganBni extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_transaksi',
        'kode',
        'kode_bni_id',
        'nama_transaksi',
        'debet',
        'kredit',
        'saldo',
    ];

    public function kode_bni()
    {
        return $this->belongsTo(KodeBni::class, 'kode_bni_id', 'id');
    }

    // Trigger untuk mengupdate saldo setiap kali debet atau kredit diisi
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ambil saldo dari data sebelumnya
            $saldo_sebelumnya = static::latest('tanggal_transaksi')->first();

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
