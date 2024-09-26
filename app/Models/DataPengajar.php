<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataPengajar extends Model
{
    use HasFactory;

    protected $table = 'data_pengajars';
    protected $fillable = ['foto', 'no_ktp', 'nama', 'jenis_kelamin', 'usia', 'alamat', 'jabatan'];

    protected $guarded = ['created_at', 'updated_at'];
}
