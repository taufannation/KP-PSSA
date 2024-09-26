<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasKecil extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_transaksi',
        'kode',
        'mata_anggaran_id',
        'nama_transaksi',
        'debet',
        'kredit',
        'saldo',
    ];

    public function mata_anggaran()
    {
        return $this->belongsTo(MataAnggaran::class, 'mata_anggaran_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ambil saldo dari data dengan ID terbesar
            $saldo_terbaru = static::orderBy('id', 'desc')->first();

            // Tentukan nilai saldo untuk data saat ini
            $model->saldo = $saldo_terbaru
                ? $saldo_terbaru->saldo + $model->debet - $model->kredit
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
