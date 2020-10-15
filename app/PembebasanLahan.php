<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class PembebasanLahan extends Model
{
    use Uuid;

    protected $fillable = [
        'pekerjaan_id','kebutuhan','sudah_bebas','belum_bebas','dokumentasi_id','permasalahan','tindak_lanjut','created_by','edited_by'
    ];
}
