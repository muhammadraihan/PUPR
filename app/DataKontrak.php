<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class DataKontrak extends Model
{
    use Uuid;

    protected $fillable = [
        'pekerjaan_id','pagu','nilai_kontrak','panjang_jalan','panjang_jembatan','tahun_anggaran','tanggal_kontrak_awal','tanggal_adendum_kontrak','tanggal_adendum_akhir','tanggal_pho','tanggal_fho','keterangan','created_by','edited_by'
    ];
}
