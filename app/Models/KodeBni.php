<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeBni extends Model
{
    use HasFactory;

    protected $table = 'kode_bnis';
    protected $fillable = ['kode', 'nama'];

    protected $guarded = ['created_at', 'updated_at'];

    public function TabunganBnis()
    {
        return $this->hasMany(TabunganBni::class);
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
