<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeBri extends Model
{
    use HasFactory;

    protected $table = 'kode_bris';
    protected $fillable = ['kode', 'nama'];

    protected $guarded = ['created_at', 'updated_at'];

    public function tabunganbris()
    {
        return $this->hasMany(TabunganBri::class);
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
