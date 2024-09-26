<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataAnggaran extends Model
{
    use HasFactory;

    protected $table = 'mata_anggarans';
    protected $fillable = ['kode', 'nama'];

    protected $guarded = ['created_at', 'updated_at'];

    public function kaskecils()
    {
        return $this->hasMany(KasKecil::class);
    }
}






// <?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;

// class MataAnggaran extends Model
// {
//     use HasFactory;

//     protected $table = 'mata_anggarans';
//     protected $fillable = ['kode', 'nama'];

//     protected $guarded = ['created_at', 'updated_at'];
// }
